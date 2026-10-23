<?php

declare(strict_types=1);

use App\Enums\AttributeImportRowOutcome;
use App\Enums\PendingAttributeStatus;
use App\Import\AttributeImportRow;
use App\Import\AttributeImportTemplate;
use App\Import\BuildsAttributeExportRows;
use App\Import\ImportsAttributeFile;
use App\Import\RoutesAttributeImportRow;
use App\Livewire\Shopper\Pages\Attribute\Browse as AttributeBrowse;
use App\Livewire\Shopper\Pages\PendingAttributes\Index as PendingAttributesIndex;
use App\Livewire\Shopper\Pages\PendingProducts\Index as PendingProductsIndex;
use App\Livewire\Shopper\SlideOvers\ImportAttributesXlsx;
use App\Models\PendingAttribute;
use App\Models\User;
use App\Support\WritesSpreadsheet;
use Filament\Actions\Testing\TestAction;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use Shopper\Core\Enum\FieldType;
use Shopper\Core\Models\Attribute;
use Shopper\Core\Models\Setting;
use Shopper\Database\Seeders\AuthTableSeeder;

uses(RefreshDatabase::class);

beforeEach(function (): void {
    $this->seed(AuthTableSeeder::class);

    $this->admin = User::factory()->create();
    $this->admin->assignRole(config('shopper.admin.roles.admin'));

    Setting::query()->create([
        'key' => 'email',
        'display_name' => 'Email',
        'value' => 'shop@example.com',
        'locked' => true,
    ]);
    Setting::query()->create([
        'key' => 'street_address',
        'display_name' => 'Address',
        'value' => 'Khreshchatyk 1',
        'locked' => true,
    ]);
    Cache::forget('shopper-setting.email');
    Cache::forget('shopper-setting.street_address');
});

function writeAttributeImportXlsx(string $filename, array $rows): string
{
    $relativePath = 'shopper/imports/'.$filename;
    $path = Storage::disk('local')->path($relativePath);

    if (! is_dir(dirname($path))) {
        mkdir(dirname($path), 0755, true);
    }

    resolve(WritesSpreadsheet::class)->handle($path, $rows);

    return $path;
}

function attributeImportRow(
    string $slug,
    string $name,
    FieldType $type = FieldType::Select,
    array $values = [],
    ?string $description = null,
): AttributeImportRow {
    return new AttributeImportRow(
        line: 2,
        name: $name,
        slug: $slug,
        description: $description,
        type: $type,
        isEnabled: true,
        isSearchable: false,
        isFilterable: true,
        icon: null,
        values: $values,
    );
}

test('admins see the export and import actions and can download the export', function (): void {
    Livewire::actingAs($this->admin)
        ->test(AttributeBrowse::class)
        ->assertSee(route('shopper.attributes.export-xlsx'))
        ->assertSee(__('backend.attribute_imports.export_action'))
        ->assertSee(__('backend.attribute_imports.import_action'))
        ->assertDontSeeHtml('href="'.route('shopper.attributes.export-xlsx').'" wire:navigate');

    $this->actingAs($this->admin)
        ->get(route('shopper.attributes.export-xlsx'))
        ->assertOk()
        ->assertDownload('attributes-'.now()->format('Y-m-d').'.xlsx');
});

test('guests and users without permission cannot download attribute import files', function (): void {
    $this->get(route('shopper.attributes.export-xlsx'))->assertRedirect();
    $this->get(route('shopper.attributes.import-xlsx-template'))->assertRedirect();

    $user = User::factory()->create();

    $this->actingAs($user)
        ->get(route('shopper.attributes.export-xlsx'))
        ->assertRedirect();

    $this->actingAs($user)
        ->get(route('shopper.attributes.import-xlsx-template'))
        ->assertRedirect();

    Livewire::actingAs($user)
        ->test(ImportAttributesXlsx::class)
        ->assertForbidden();
});

test('exported attributes can be imported back without changes', function (): void {
    $attribute = Attribute::factory()->create([
        'name' => 'Колір',
        'slug' => 'color',
        'description' => 'Колір товару',
        'type' => FieldType::ColorPicker,
        'icon' => 'phosphor-palette',
        'is_enabled' => true,
        'is_searchable' => true,
        'is_filterable' => false,
    ]);
    $attribute->values()->createMany([
        ['key' => '#0000ff', 'value' => 'Синій', 'position' => 1],
        ['key' => '#ff0000', 'value' => 'Червоний', 'position' => 2],
    ]);

    $rows = iterator_to_array(resolve(BuildsAttributeExportRows::class)->handle(), false);

    expect($rows[0])->toBe(AttributeImportTemplate::COLUMNS)
        ->and($rows[1])->toBe([
            'Колір',
            'color',
            'Колір товару',
            FieldType::ColorPicker->value,
            '1',
            '1',
            '0',
            'phosphor-palette',
            '#0000ff: Синій | #ff0000: Червоний',
        ]);

    $result = resolve(ImportsAttributeFile::class)->handle(writeAttributeImportXlsx('attributes-round-trip.xlsx', $rows));

    $attribute->refresh();

    expect($result->updated)->toBe(1)
        ->and($result->queued)->toBe(0)
        ->and($result->errors)->toBe([])
        ->and(PendingAttribute::query()->count())->toBe(0)
        ->and($attribute->name)->toBe('Колір')
        ->and($attribute->type)->toBe(FieldType::ColorPicker)
        ->and($attribute->values()->orderBy('position')->pluck('value', 'key')->all())->toBe([
            '#0000ff' => 'Синій',
            '#ff0000' => 'Червоний',
        ]);
});

test('an existing attribute is updated and values missing from the file stay', function (): void {
    $attribute = Attribute::factory()->create([
        'name' => 'Size',
        'slug' => 'size',
        'description' => 'Old',
        'type' => FieldType::Select,
        'is_enabled' => false,
    ]);
    $attribute->values()->createMany([
        ['key' => 'm', 'value' => 'M', 'position' => 1],
        ['key' => 's', 'value' => 'S', 'position' => 2],
    ]);
    PendingAttribute::factory()->create(['slug' => 'size', 'name' => 'Queued size']);

    $outcome = resolve(RoutesAttributeImportRow::class)->route(attributeImportRow(
        slug: 'size',
        name: 'Розмір',
        description: 'Розмір товару',
        values: [
            ['key' => 'm', 'value' => 'Medium'],
            ['key' => 'l', 'value' => 'L'],
        ],
    ));

    expect($outcome)->toBe(AttributeImportRowOutcome::Updated)
        ->and($attribute->refresh()->name)->toBe('Розмір')
        ->and($attribute->description)->toBe('Розмір товару')
        ->and($attribute->is_enabled)->toBeTrue()
        ->and($attribute->is_filterable)->toBeTrue()
        ->and($attribute->values()->orderBy('key')->pluck('value', 'key')->all())->toBe([
            'l' => 'L',
            'm' => 'Medium',
            's' => 'S',
        ])
        ->and(PendingAttribute::query()->where('slug', 'size')->exists())->toBeFalse();
});

test('a type change is rejected when the attribute has values and other rows are still imported', function (): void {
    $attribute = Attribute::factory()->create([
        'name' => 'Size',
        'slug' => 'size',
        'description' => 'Size',
        'type' => FieldType::Select,
    ]);
    $attribute->values()->create(['key' => 'm', 'value' => 'M', 'position' => 1]);

    $result = resolve(ImportsAttributeFile::class)->handle(writeAttributeImportXlsx('attributes-type.xlsx', [
        AttributeImportTemplate::COLUMNS,
        ['Size', 'size', 'Size', FieldType::Text->value, '1', '0', '0', '', ''],
        ['Material', 'material', '', FieldType::Select->value, '1', '0', '1', '', 'cotton: Бавовна'],
    ]));

    expect($result->updated)->toBe(0)
        ->and($result->queued)->toBe(1)
        ->and($result->errors)->toHaveCount(1)
        ->and($attribute->refresh()->type)->toBe(FieldType::Select)
        ->and(Attribute::query()->where('slug', 'material')->exists())->toBeFalse()
        ->and(PendingAttribute::query()->where('slug', 'material')->value('name'))->toBe('Material');
});

test('a new slug is queued and a reimport refreshes the queue entry', function (): void {
    $router = resolve(RoutesAttributeImportRow::class);

    expect($router->route(attributeImportRow('material', 'Material')))->toBe(AttributeImportRowOutcome::Queued);

    PendingAttribute::query()->update([
        'status' => PendingAttributeStatus::Failed,
        'error' => 'Broken',
    ]);

    $router->route(attributeImportRow('material', 'Матеріал'));

    $pending = PendingAttribute::query()->sole();

    expect(Attribute::query()->count())->toBe(0)
        ->and($pending->name)->toBe('Матеріал')
        ->and($pending->status)->toBe(PendingAttributeStatus::Pending)
        ->and($pending->error)->toBeNull();
});

test('the import queue has an attributes tab', function (): void {
    Livewire::actingAs($this->admin)
        ->test(PendingProductsIndex::class)
        ->assertSee(__('backend.pending_products.tabs.products'))
        ->assertSee(__('backend.pending_products.tabs.attributes'))
        ->set('tab', 'attributes')
        ->assertSee(__('backend.pending_attributes.description'))
        ->assertSeeLivewire(PendingAttributesIndex::class);
});

test('creating a queued attribute adds it to the catalog and removes the queue entry', function (): void {
    $pending = PendingAttribute::create([
        ...PendingAttribute::attributesFromImportRow(attributeImportRow(
            slug: 'material',
            name: 'Material',
            values: [['key' => 'cotton', 'value' => 'Бавовна']],
        )),
        'status' => PendingAttributeStatus::Pending,
    ]);

    Livewire::actingAs($this->admin)
        ->test(PendingAttributesIndex::class)
        ->assertCanSeeTableRecords([$pending])
        ->callAction(TestAction::make('create')->table($pending));

    $attribute = Attribute::query()->where('slug', 'material')->first();

    expect($attribute)->not->toBeNull()
        ->and($attribute->name)->toBe('Material')
        ->and($attribute->values()->pluck('value', 'key')->all())->toBe(['cotton' => 'Бавовна'])
        ->and(PendingAttribute::query()->count())->toBe(0);
});

test('creating a queued attribute updates the catalog entry when the slug already exists', function (): void {
    $attribute = Attribute::factory()->create([
        'name' => 'Old',
        'slug' => 'material',
        'description' => 'Old',
        'type' => FieldType::Select,
    ]);
    $attribute->values()->create(['key' => 'wool', 'value' => 'Wool', 'position' => 1]);

    $pending = PendingAttribute::create([
        ...PendingAttribute::attributesFromImportRow(attributeImportRow(
            slug: 'material',
            name: 'Material',
            description: 'Fabric',
            values: [['key' => 'cotton', 'value' => 'Бавовна']],
        )),
        'status' => PendingAttributeStatus::Pending,
    ]);

    Livewire::actingAs($this->admin)
        ->test(PendingAttributesIndex::class)
        ->callAction(TestAction::make('create')->table($pending));

    expect($attribute->refresh()->name)->toBe('Material')
        ->and($attribute->description)->toBe('Fabric')
        ->and($attribute->values()->orderBy('key')->pluck('value', 'key')->all())->toBe([
            'cotton' => 'Бавовна',
            'wool' => 'Wool',
        ])
        ->and(PendingAttribute::query()->count())->toBe(0)
        ->and(Attribute::query()->count())->toBe(1);
});

test('deleting a queued attribute does not create it', function (): void {
    $pending = PendingAttribute::factory()->create(['slug' => 'material', 'name' => 'Material']);

    Livewire::actingAs($this->admin)
        ->test(PendingAttributesIndex::class)
        ->callAction(TestAction::make('delete')->table($pending));

    expect(PendingAttribute::query()->count())->toBe(0)
        ->and(Attribute::query()->where('slug', 'material')->exists())->toBeFalse();
});

test('users who cannot create attributes cannot create them from the queue', function (): void {
    $user = User::factory()->create();
    $user->givePermissionTo('products.create');
    $pending = PendingAttribute::factory()->create();

    Livewire::actingAs($user)
        ->test(PendingAttributesIndex::class)
        ->assertActionHidden(TestAction::make('create')->table($pending))
        ->assertActionHidden(TestAction::make('delete')->table($pending));
});

test('admins can import attributes from an uploaded excel file', function (): void {
    $path = writeAttributeImportXlsx('attributes-upload.xlsx', [
        AttributeImportTemplate::COLUMNS,
        ['Material', 'material', '', FieldType::Select->value, '1', '0', '1', '', 'cotton: Бавовна'],
    ]);

    $upload = UploadedFile::fake()->createWithContent('attributes.xlsx', file_get_contents($path));

    Livewire::actingAs($this->admin)
        ->test(ImportAttributesXlsx::class)
        ->set('data.file', [$upload])
        ->call('store')
        ->assertHasNoErrors();

    expect(Attribute::query()->where('slug', 'material')->exists())->toBeFalse()
        ->and(PendingAttribute::query()->where('slug', 'material')->value('name'))->toBe('Material');
});
