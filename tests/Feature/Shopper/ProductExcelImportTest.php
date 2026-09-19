<?php

declare(strict_types=1);

use App\Import\Sources\XlsxSource;
use App\Livewire\Shopper\SlideOvers\ImportXlsx;
use App\Models\Product;
use App\Models\User;
use App\Support\WritesSpreadsheet;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use Shopper\Core\Enum\ImportStatus;
use Shopper\Core\Import\ImportManager;
use Shopper\Core\Import\StartProductImport;
use Shopper\Core\Models\ProductImport;
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

function writeProductImportXlsx(string $filename, array $rows): string
{
    $relativePath = 'shopper/imports/'.$filename;
    $path = Storage::disk('local')->path($relativePath);

    if (! is_dir(dirname($path))) {
        mkdir(dirname($path), 0755, true);
    }

    resolve(WritesSpreadsheet::class)->handle($path, $rows);

    return $relativePath;
}

test('excel is available as a product import source', function (): void {
    $sources = resolve(ImportManager::class)->configuredSources();

    expect($sources->keys()->all())->toContain('csv', 'xlsx')
        ->and($sources['xlsx'])->toBeInstanceOf(XlsxSource::class)
        ->and($sources['xlsx']->name())->toBe(__('backend.product_imports.sources.xlsx.name'));
});

test('it imports a standard product from an excel workbook', function (): void {
    $relativePath = writeProductImportXlsx('linen-shirt.xlsx', [
        ['handle', 'name', 'sku'],
        ['linen-shirt', 'Linen Shirt', 'SHIRT-1'],
    ]);

    $import = ProductImport::query()->create([
        'source' => 'xlsx',
        'disk' => 'local',
        'file_path' => $relativePath,
        'mapping' => [
            'handle' => 'handle',
            'name' => 'name',
            'sku' => 'sku',
        ],
        'status' => ImportStatus::Pending,
        'user_id' => $this->admin->id,
    ]);

    resolve(StartProductImport::class)->execute($import);

    $product = Product::query()->where('slug', 'linen-shirt')->first();

    expect($product)->not->toBeNull()
        ->and($product->name)->toBe('Linen Shirt')
        ->and($product->sku)->toBe('SHIRT-1');

    $import->refresh();

    expect($import->status)->toBe(ImportStatus::Completed)
        ->and($import->imported_count)->toBe(1);
});

test('it reads mapped excel columns through the xlsx source', function (): void {
    $relativePath = writeProductImportXlsx('mapped-columns.xlsx', [
        ['Title', 'Slug', 'Article'],
        ['Wool Coat', 'wool-coat', 'COAT-1'],
    ]);

    $source = resolve(ImportManager::class)->source('xlsx');

    expect($source)->toBeInstanceOf(XlsxSource::class);

    $rows = $source
        ->withMapping([
            'name' => 'Title',
            'handle' => 'Slug',
            'sku' => 'Article',
        ])
        ->read(Storage::disk('local')->path($relativePath))
        ->collect();

    expect($rows)->toHaveCount(1)
        ->and($rows->first()->name)->toBe('Wool Coat')
        ->and($rows->first()->handle)->toBe('wool-coat')
        ->and($rows->first()->variants[0]->sku)->toBe('COAT-1');
});

test('users without permission cannot open the excel import panel', function (): void {
    $user = User::factory()->create();

    Livewire::actingAs($user)
        ->test(ImportXlsx::class)
        ->assertForbidden();
});

test('admins can import products from an uploaded excel file', function (): void {
    $relativePath = writeProductImportXlsx('upload.xlsx', [
        ['handle', 'name', 'sku'],
        ['canvas-bag', 'Canvas Bag', 'BAG-1'],
    ]);

    $upload = UploadedFile::fake()->createWithContent(
        'products.xlsx',
        Storage::disk('local')->get($relativePath),
    );

    Livewire::actingAs($this->admin)
        ->test(ImportXlsx::class)
        ->set('fileHeaders', ['handle', 'name', 'sku'])
        ->set('data.file', [$upload])
        ->set('data.mapping.name', 'name')
        ->set('data.mapping.handle', 'handle')
        ->set('data.mapping.sku', 'sku')
        ->call('store')
        ->assertHasNoErrors();

    expect(Product::query()->where('slug', 'canvas-bag')->first())
        ->not->toBeNull()
        ->and(Product::query()->where('slug', 'canvas-bag')->value('name'))->toBe('Canvas Bag')
        ->and(ProductImport::query()->where('source', 'xlsx')->exists())->toBeTrue();
});

test('guests cannot download the excel import template', function (): void {
    $this->get(route('shopper.products.import-xlsx-template'))->assertRedirect();
});

test('users without permission cannot download the excel import template', function (): void {
    $this->actingAs(User::factory()->create())
        ->get(route('shopper.products.import-xlsx-template'))
        ->assertRedirect();
});

test('admins can download the excel import template', function (): void {
    $this->actingAs($this->admin)
        ->get(route('shopper.products.import-xlsx-template'))
        ->assertOk()
        ->assertDownload('product-import.xlsx');
});
