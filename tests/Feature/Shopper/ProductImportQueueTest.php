<?php

declare(strict_types=1);

use App\Enums\PendingProductStatus;
use App\Enums\ProductImportRowOutcome;
use App\Import\ProductImportRow;
use App\Import\RoutesProductImportRow;
use App\Jobs\ImportProductsChunkJob;
use App\Livewire\Shopper\Pages\BlacklistedProducts\Index as BlacklistIndex;
use App\Livewire\Shopper\Pages\PendingProducts\Index as PendingProductsIndex;
use App\Models\BlacklistedProduct;
use App\Models\PendingProduct;
use App\Models\Product;
use App\Models\User;
use Filament\Actions\Testing\TestAction;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Shopper\Core\Enum\ImportStatus;
use Shopper\Core\Import\ProductRow;
use Shopper\Core\Import\VariantRow;
use Shopper\Core\Models\ProductImport;
use Shopper\Database\Seeders\AuthTableSeeder;

uses(RefreshDatabase::class);

beforeEach(function (): void {
    $this->seed(AuthTableSeeder::class);

    $this->admin = User::factory()->create();
    $this->admin->assignRole(config('shopper.admin.roles.admin'));

    $this->import = ProductImport::query()->create([
        'source' => 'xlsx',
        'disk' => 'local',
        'file_path' => 'shopper/imports/test.xlsx',
        'status' => ImportStatus::Processing,
        'user_id' => $this->admin->id,
    ]);
});

function queueImportRow(string $handle, string $name, ?string $sku): ProductImportRow
{
    return new ProductImportRow(
        product: new ProductRow(
            handle: $handle,
            name: $name,
            published: true,
            variants: [new VariantRow(sku: $sku)],
        ),
        sku: $sku,
    );
}

test('an existing sku updates the product even when the handle differs', function (): void {
    $product = Product::factory()->standard()->create(['name' => 'Old name', 'slug' => 'old-slug', 'sku' => 'OIL-1']);

    $outcome = resolve(RoutesProductImportRow::class)->route(queueImportRow('new-slug', 'New name', 'OIL-1'));

    expect($outcome)->toBe(ProductImportRowOutcome::Updated)
        ->and($product->refresh()->name)->toBe('New name')
        ->and($product->slug)->toBe('old-slug')
        ->and(Product::query()->count())->toBe(1)
        ->and(PendingProduct::query()->count())->toBe(0);
});

test('a new sku is queued without creating a product and a reimport refreshes the entry', function (): void {
    $router = resolve(RoutesProductImportRow::class);

    expect($router->route(queueImportRow('oil', 'Oil', 'OIL-1'), $this->import->id))->toBe(ProductImportRowOutcome::Queued);

    PendingProduct::query()->update(['status' => PendingProductStatus::Failed, 'error' => 'Broken']);

    $router->route(queueImportRow('oil', 'Oil v2', 'OIL-1'), $this->import->id);

    $pending = PendingProduct::query()->sole();

    expect(Product::query()->count())->toBe(0)
        ->and($pending->name)->toBe('Oil v2')
        ->and($pending->status)->toBe(PendingProductStatus::Pending)
        ->and($pending->error)->toBeNull()
        ->and($pending->product_import_id)->toBe($this->import->id)
        ->and($pending->importRow()->product->name)->toBe('Oil v2');
});

test('a blacklisted sku is neither created nor updated', function (): void {
    $product = Product::factory()->standard()->create(['name' => 'Kept', 'sku' => 'OIL-1']);
    BlacklistedProduct::factory()->create(['sku' => 'OIL-1']);
    BlacklistedProduct::factory()->create(['sku' => 'OIL-2']);

    (new ImportProductsChunkJob($this->import->id, [
        queueImportRow('oil-1', 'Changed', 'OIL-1'),
        queueImportRow('oil-2', 'New', 'OIL-2'),
    ]))->handle(resolve(RoutesProductImportRow::class));

    expect($product->refresh()->name)->toBe('Kept')
        ->and(PendingProduct::query()->count())->toBe(0)
        ->and($this->import->refresh()->skipped_count)->toBe(2)
        ->and($this->import->imported_count)->toBe(0);
});

test('a row without sku is recorded as an import error', function (): void {
    (new ImportProductsChunkJob($this->import->id, [
        queueImportRow('no-sku', 'No SKU', null),
    ]))->handle(resolve(RoutesProductImportRow::class));

    $this->import->refresh();

    expect($this->import->failed_count)->toBe(1)
        ->and($this->import->errors[0]['message'])->toBe(__('backend.pending_products.missing_sku'))
        ->and(PendingProduct::query()->count())->toBe(0)
        ->and(Product::query()->count())->toBe(0);
});

test('a product without sku is matched by handle and receives the sku from the file', function (): void {
    $product = Product::factory()->variant()->create(['name' => 'Old name', 'slug' => 'diesel-oil', 'sku' => null]);
    PendingProduct::factory()->create(['sku' => '7245']);

    $outcome = resolve(RoutesProductImportRow::class)->route(new ProductImportRow(
        product: new ProductRow(
            handle: 'diesel-oil',
            name: 'Diesel oil',
            published: true,
            optionNames: ['Volume'],
            variants: [new VariantRow(options: ['Volume' => '1 l'], sku: '7245/01')],
        ),
        sku: '7245',
    ));

    expect($outcome)->toBe(ProductImportRowOutcome::Updated)
        ->and($product->refresh()->name)->toBe('Diesel oil')
        ->and($product->sku)->toBe('7245')
        ->and(Product::query()->count())->toBe(1)
        ->and(PendingProduct::query()->count())->toBe(0);
});

test('a product with another sku is not matched by handle', function (): void {
    Product::factory()->standard()->create(['name' => 'Kept', 'slug' => 'oil', 'sku' => 'OIL-OTHER']);

    expect(resolve(RoutesProductImportRow::class)->route(queueImportRow('oil', 'Oil', 'OIL-1')))->toBe(ProductImportRowOutcome::Queued)
        ->and(Product::query()->sole()->name)->toBe('Kept');
});

test('the preview predicts the outcome of each sku without writing', function (): void {
    Product::factory()->standard()->create(['sku' => 'OIL-1']);
    Product::factory()->variant()->create(['slug' => 'legacy-oil', 'sku' => null]);
    BlacklistedProduct::factory()->create(['sku' => 'OIL-2']);

    $outcomes = resolve(RoutesProductImportRow::class)->outcomesFor(
        ['OIL-1', 'OIL-2', 'OIL-3', 'OIL-4'],
        ['OIL-3' => 'new-oil', 'OIL-4' => 'legacy-oil'],
    );

    expect($outcomes)->toBe([
        'OIL-1' => ProductImportRowOutcome::Updated,
        'OIL-2' => ProductImportRowOutcome::Skipped,
        'OIL-3' => ProductImportRowOutcome::Queued,
        'OIL-4' => ProductImportRowOutcome::Updated,
    ])->and(PendingProduct::query()->count())->toBe(0)
        ->and(Product::query()->whereNull('sku')->count())->toBe(1);
});

test('users without permission cannot open the import queue or the blacklist', function (): void {
    $user = User::factory()->create();

    Livewire::actingAs($user)->test(PendingProductsIndex::class)->assertForbidden();
    Livewire::actingAs($user)->test(BlacklistIndex::class)->assertForbidden();
});

test('admins see queued products and can filter them by import', function (): void {
    $fromImport = PendingProduct::factory()->create(['product_import_id' => $this->import->id]);
    $other = PendingProduct::factory()->create();

    Livewire::actingAs($this->admin)
        ->test(PendingProductsIndex::class)
        ->assertSuccessful()
        ->assertCanSeeTableRecords([$fromImport, $other])
        ->filterTable('product_import_id', $this->import->id)
        ->assertCanSeeTableRecords([$fromImport])
        ->assertCanNotSeeTableRecords([$other]);
});

test('guests cannot open the import queue', function (): void {
    $this->get(route('shopper.products.pending.index'))->assertRedirect();
    $this->get(route('shopper.products.blacklist.index'))->assertRedirect();
});

test('creating a queued product imports it and removes the entry', function (): void {
    Product::factory()->standard()->create(['slug' => 'oil', 'sku' => 'OTHER']);
    $pending = PendingProduct::factory()->create(PendingProduct::attributesFromImportRow(queueImportRow('oil', 'Oil', 'OIL-1')));

    Livewire::actingAs($this->admin)
        ->test(PendingProductsIndex::class)
        ->assertCanSeeTableRecords([$pending])
        ->callAction(TestAction::make('create')->table($pending));

    $product = Product::query()->where('sku', 'OIL-1')->first();

    expect($product)->not->toBeNull()
        ->and($product->name)->toBe('Oil')
        ->and($product->slug)->toBe('oil-2')
        ->and(PendingProduct::query()->count())->toBe(0);
});

test('a queued product that fails to import is marked as failed', function (): void {
    $pending = PendingProduct::factory()->create(PendingProduct::attributesFromImportRow(queueImportRow('', '', 'OIL-1')));

    Livewire::actingAs($this->admin)
        ->test(PendingProductsIndex::class)
        ->callAction(TestAction::make('create')->table($pending));

    expect($pending->refresh()->status)->toBe(PendingProductStatus::Failed)
        ->and($pending->error)->not->toBeEmpty()
        ->and(Product::query()->count())->toBe(0);
});

test('queued products can be deleted', function (): void {
    $pending = PendingProduct::factory()->create();

    Livewire::actingAs($this->admin)
        ->test(PendingProductsIndex::class)
        ->callAction(TestAction::make('delete')->table($pending));

    expect(PendingProduct::query()->count())->toBe(0)
        ->and(BlacklistedProduct::query()->count())->toBe(0);
});

test('queued products can be moved to the blacklist in bulk', function (): void {
    $entries = PendingProduct::factory()->count(2)->create();

    Livewire::actingAs($this->admin)
        ->test(PendingProductsIndex::class)
        ->selectTableRecords($entries->pluck('id')->all())
        ->callAction(TestAction::make('blacklist')->table()->bulk());

    expect(PendingProduct::query()->count())->toBe(0)
        ->and(BlacklistedProduct::query()->pluck('sku')->sort()->values()->all())->toBe($entries->pluck('sku')->sort()->values()->all())
        ->and(BlacklistedProduct::query()->value('user_id'))->toBe($this->admin->id);
});

test('admins can add a sku to the blacklist and it leaves the queue', function (): void {
    PendingProduct::factory()->create(['sku' => 'OIL-1']);

    Livewire::actingAs($this->admin)
        ->test(BlacklistIndex::class)
        ->callAction(TestAction::make('add')->table(), ['sku' => 'OIL-1', 'name' => 'Oil'])
        ->assertHasNoFormErrors();

    expect(BlacklistedProduct::query()->where('sku', 'OIL-1')->value('name'))->toBe('Oil')
        ->and(PendingProduct::query()->count())->toBe(0);
});

test('admins can remove a sku from the blacklist', function (): void {
    $entry = BlacklistedProduct::factory()->create();

    Livewire::actingAs($this->admin)
        ->test(BlacklistIndex::class)
        ->callAction(TestAction::make('remove')->table($entry));

    expect(BlacklistedProduct::query()->count())->toBe(0);
});
