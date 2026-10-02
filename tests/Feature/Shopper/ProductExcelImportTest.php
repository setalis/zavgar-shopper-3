<?php

declare(strict_types=1);

use App\Enums\PendingProductStatus;
use App\Import\BuildsProductExportRows;
use App\Import\ProductImportTemplate;
use App\Import\Sources\XlsxSource;
use App\Import\StartProductImport;
use App\Jobs\CreatePendingProductsJob;
use App\Livewire\Shopper\SlideOvers\ImportXlsx;
use App\Models\PendingProduct;
use App\Models\Product;
use App\Models\User;
use App\Support\WritesSpreadsheet;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use Shopper\Core\Enum\Dimension\Length;
use Shopper\Core\Enum\FieldType;
use Shopper\Core\Enum\ImportStatus;
use Shopper\Core\Enum\ProductType;
use Shopper\Core\Import\ImportManager;
use Shopper\Core\Jobs\DownloadProductImageJob;
use Shopper\Core\Models\Attribute;
use Shopper\Core\Models\AttributeProduct;
use Shopper\Core\Models\Currency;
use Shopper\Core\Models\Inventory;
use Shopper\Core\Models\ProductImport;
use Shopper\Core\Models\Setting;
use Shopper\Database\Seeders\AuthTableSeeder;
use Shopper\Livewire\Pages\Product\Index as ProductIndex;

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

function createXlsxProductImport(string $relativePath, int $userId): ProductImport
{
    $currency = Currency::query()->firstOrCreate(['code' => 'UAH'], [
        'name' => 'Hryvnia',
        'symbol' => '₴',
        'format' => '1,234.56 ₴',
    ]);
    Setting::query()->updateOrCreate(['key' => 'default_currency_id'], [
        'display_name' => 'Currency',
        'value' => $currency->id,
        'locked' => true,
    ]);
    Cache::forget('shopper-setting.default_currency_id');

    return ProductImport::query()->create([
        'source' => 'xlsx',
        'disk' => 'local',
        'file_path' => $relativePath,
        'mapping' => [],
        'status' => ImportStatus::Pending,
        'user_id' => $userId,
    ]);
}

function createQueuedProducts(): void
{
    $ids = PendingProduct::query()->pluck('id')->all();

    PendingProduct::query()->update(['status' => PendingProductStatus::Processing]);

    CreatePendingProductsJob::dispatchSync($ids);
}

function importXlsxAndCreateQueuedProducts(string $relativePath, int $userId): ProductImport
{
    $import = createXlsxProductImport($relativePath, $userId);

    resolve(StartProductImport::class)->execute($import);
    createQueuedProducts();

    return $import->refresh();
}

/**
 * @return array<string, list<string>>
 */
function productAttributeValues(Product $product): array
{
    return AttributeProduct::query()
        ->with(['attribute', 'value'])
        ->where('product_id', $product->id)
        ->get()
        ->groupBy(fn (AttributeProduct $row): string => $row->attribute->name)
        ->map(fn ($rows): array => $rows->map(fn (AttributeProduct $row): string => $row->real_value)->sort()->values()->all())
        ->sortKeys()
        ->all();
}

test('excel is available as a product import source', function (): void {
    $sources = resolve(ImportManager::class)->configuredSources();

    expect($sources->keys()->all())->toContain('csv', 'xlsx')
        ->and($sources['xlsx'])->toBeInstanceOf(XlsxSource::class)
        ->and($sources['xlsx']->name())->toBe(__('backend.product_imports.sources.xlsx.name'));
});

test('a new standard product is queued and created from the queue', function (): void {
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

    $import->refresh();

    expect(Product::query()->where('sku', 'SHIRT-1')->exists())->toBeFalse()
        ->and(PendingProduct::query()->where('sku', 'SHIRT-1')->value('name'))->toBe('Linen Shirt')
        ->and($import->status)->toBe(ImportStatus::Completed)
        ->and($import->imported_count)->toBe(0)
        ->and($import->queued_count)->toBe(1);

    createQueuedProducts();

    $product = Product::query()->where('slug', 'linen-shirt')->first();

    expect($product)->not->toBeNull()
        ->and($product->name)->toBe('Linen Shirt')
        ->and($product->sku)->toBe('SHIRT-1')
        ->and(PendingProduct::query()->count())->toBe(0);
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
        ->and($rows->first()->product->name)->toBe('Wool Coat')
        ->and($rows->first()->product->handle)->toBe('wool-coat')
        ->and($rows->first()->product->variants[0]->sku)->toBe('COAT-1');
});

test('it keeps variant rows that omit the product handle', function (): void {
    $relativePath = writeProductImportXlsx('variant-rows.xlsx', [
        ['handle', 'name', 'sku', 'variations'],
        ['wave-oil', 'Wave Oil', '7245/01', 'Size: 1L'],
        ['', '', '7245/200', 'Size: 200L'],
    ]);

    $rows = resolve(ImportManager::class)
        ->source('xlsx')
        ->read(Storage::disk('local')->path($relativePath))
        ->collect();

    expect($rows)->toHaveCount(1)
        ->and($rows->first()->product->handle)->toBe('wave-oil')
        ->and($rows->first()->product->optionNames)->toBe(['Size'])
        ->and($rows->first()->product->variants)->toHaveCount(2)
        ->and($rows->first()->product->variants[0]->sku)->toBe('7245/01')
        ->and($rows->first()->product->variants[1]->options)->toBe(['Size' => '200L']);
});

test('it separates the product row from its variation rows', function (): void {
    $relativePath = writeProductImportXlsx('variable.xlsx', [
        ['handle', 'name', 'attributes', 'variations', 'sku', 'price', 'quantity'],
        ['basic-tee', 'Basic Tee', 'Material: Cotton; Country: Ukraine', '', 'TS-BASE', '', ''],
        ['', '', '', 'Size: M; Color: Blue', 'TS-M-BLUE', '499', '10'],
        ['', '', '', 'Size: L; Color: Red', 'TS-L-RED', '529,50', '5'],
    ]);

    importXlsxAndCreateQueuedProducts($relativePath, $this->admin->id);

    $product = Product::query()->where('slug', 'basic-tee')->firstOrFail();
    $variants = $product->variants()->with('values.attribute')->orderBy('position')->get();

    expect($product->type)->toBe(ProductType::Variant)
        ->and($product->sku)->toBe('TS-BASE')
        ->and($variants)->toHaveCount(2)
        ->and($variants->pluck('sku')->all())->toBe(['TS-M-BLUE', 'TS-L-RED'])
        ->and($variants[1]->values->pluck('value', 'attribute.name')->all())->toBe(['Size' => 'L', 'Color' => 'Red'])
        ->and($variants[1]->prices()->first()->amount)->toBe(52950)
        ->and(productAttributeValues($product))->toBe(['Country' => ['Ukraine'], 'Material' => ['Cotton']]);

    expect($variants->flatMap->values->pluck('attribute.name')->unique()->sort()->values()->all())
        ->toBe(['Color', 'Size']);
});

test('it imports product attributes respecting existing attribute types', function (): void {
    Attribute::query()->create([
        'name' => 'Volume',
        'slug' => 'volume',
        'type' => FieldType::Text,
        'is_enabled' => true,
    ]);

    $relativePath = writeProductImportXlsx('attributes.xlsx', [
        ['handle', 'name', 'sku', 'attributes'],
        ['classic-perfume', 'Classic Perfume', 'PF-50', 'Volume: 50 ml; Notes: Cedar | Citrus; Origin: France'],
    ]);

    importXlsxAndCreateQueuedProducts($relativePath, $this->admin->id);

    $product = Product::query()->where('slug', 'classic-perfume')->firstOrFail();

    expect($product->type)->toBe(ProductType::Standard)
        ->and(productAttributeValues($product))->toBe([
            'Notes' => ['Cedar', 'Citrus'],
            'Origin' => ['France'],
            'Volume' => ['50 ml'],
        ])
        ->and(Attribute::query()->where('name', 'Notes')->value('type'))->toBe(FieldType::Checkbox)
        ->and(Attribute::query()->where('name', 'Origin')->value('type'))->toBe(FieldType::Select)
        ->and(AttributeProduct::query()->where('product_id', $product->id)->whereNotNull('attribute_custom_value')->value('attribute_custom_value'))->toBe('50 ml');
});

test('reimporting replaces only the attributes listed in the file', function (): void {
    $first = writeProductImportXlsx('attributes-first.xlsx', [
        ['handle', 'name', 'sku', 'attributes'],
        ['classic-perfume', 'Classic Perfume', 'PF-50', 'Origin: France; Notes: Cedar'],
    ]);
    importXlsxAndCreateQueuedProducts($first, $this->admin->id);

    $second = writeProductImportXlsx('attributes-second.xlsx', [
        ['handle', 'name', 'sku', 'attributes'],
        ['classic-perfume', 'Classic Perfume', 'PF-50', 'Origin: Italy'],
    ]);
    resolve(StartProductImport::class)->execute(createXlsxProductImport($second, $this->admin->id));

    $product = Product::query()->where('slug', 'classic-perfume')->firstOrFail();

    expect(productAttributeValues($product))->toBe([
        'Notes' => ['Cedar'],
        'Origin' => ['Italy'],
    ]);
});

test('it imports the extra product and variant fields', function (): void {
    $relativePath = writeProductImportXlsx('extras.xlsx', [
        ['handle', 'name', 'featured', 'supplier', 'allow_backorder', 'variations', 'sku', 'width_value', 'height_value', 'depth_value', 'length_unit'],
        ['canvas-bag', 'Canvas Bag', 'так', 'Textile LLC', '1', '', 'BAG', '30', '40', '10', 'cm'],
        ['', '', '', '', '1', 'Color: Black', 'BAG-BLACK', '31', '41', '11', 'mm'],
    ]);

    $import = importXlsxAndCreateQueuedProducts($relativePath, $this->admin->id);

    $product = Product::query()->where('slug', 'canvas-bag')->firstOrFail();
    $variant = $product->variants()->where('sku', 'BAG-BLACK')->firstOrFail();

    expect($import->errors ?? [])->toBe([])
        ->and($product->featured)->toBeTrue()
        ->and($product->allow_backorder)->toBeTrue()
        ->and($product->supplier?->name)->toBe('Textile LLC')
        ->and((float) $product->width_value)->toBe(30.0)
        ->and($product->width_unit)->toBe(Length::CM)
        ->and($variant->allow_backorder)->toBeTrue()
        ->and((float) $variant->depth_value)->toBe(11.0)
        ->and($variant->depth_unit)->toBe(Length::MM);
});

test('the downloadable template imports without errors', function (): void {
    Queue::fake([DownloadProductImageJob::class]);

    $relativePath = writeProductImportXlsx('template.xlsx', resolve(ProductImportTemplate::class)->rows());

    $import = importXlsxAndCreateQueuedProducts($relativePath, $this->admin->id);

    $tShirt = Product::query()->where('slug', 'futbolka-bazova')->firstOrFail();

    expect($import->errors ?? [])->toBe([])
        ->and($import->status)->toBe(ImportStatus::Completed)
        ->and($import->queued_count)->toBe(2)
        ->and(PendingProduct::query()->count())->toBe(0)
        ->and($tShirt->sku)->toBe('TS-BASE')
        ->and($tShirt->variants()->count())->toBe(3)
        ->and(productAttributeValues($tShirt))->toBe([
            'Країна виробництва' => ['Україна'],
            'Матеріал' => ['Бавовна', 'Еластан'],
        ])
        ->and(Product::query()->where('slug', 'parfum-klasychnyi')->value('type'))->toBe(ProductType::Standard);
});

test('it restores a soft-deleted product found by sku and makes it visible again', function (): void {
    $currency = Currency::query()->create([
        'name' => 'Hryvnia',
        'code' => 'UAH',
        'symbol' => '₴',
        'format' => '1,234.56 ₴',
    ]);
    Setting::query()->create([
        'key' => 'default_currency_id',
        'display_name' => 'Currency',
        'value' => $currency->id,
        'locked' => true,
    ]);
    Cache::forget('shopper-setting.default_currency_id');
    Cache::forget('shopper-setting.default_currency');

    $product = Product::factory()->standard()->create([
        'name' => 'Old Oil',
        'slug' => 'wave-oil',
        'sku' => '7245/01',
    ]);
    $product->delete();

    $relativePath = writeProductImportXlsx('restore.xlsx', [
        ['handle', 'name', 'sku'],
        ['wave-oil', 'Wave Oil', '7245/01'],
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

    $product = Product::query()->where('slug', 'wave-oil')->first();

    expect($product)->not->toBeNull()
        ->and(PendingProduct::query()->count())->toBe(0)
        ->and($product->trashed())->toBeFalse()
        ->and($product->name)->toBe('Wave Oil')
        ->and($product->isPublished())->toBeTrue()
        ->and(Product::query()->scopes('publish')->where('id', $product->id)->exists())->toBeTrue();
});

test('it prices products in the store currency when the file uses a disabled currency', function (): void {
    $currency = Currency::query()->create([
        'name' => 'Hryvnia',
        'code' => 'UAH',
        'symbol' => '₴',
        'format' => '1,234.56 ₴',
    ]);
    Setting::query()->create([
        'key' => 'default_currency_id',
        'display_name' => 'Currency',
        'value' => $currency->id,
        'locked' => true,
    ]);
    Setting::query()->create([
        'key' => 'currencies',
        'display_name' => 'Currencies',
        'value' => [$currency->id],
        'locked' => true,
    ]);
    Cache::forget('shopper-setting.default_currency_id');
    Cache::forget('shopper-setting.currencies');

    $relativePath = writeProductImportXlsx('eur-price.xlsx', [
        ['handle', 'name', 'sku', 'price', 'currency'],
        ['classic-perfume', 'Classic Perfume', 'PERF-1', '49.99', 'EUR'],
    ]);

    $import = ProductImport::query()->create([
        'source' => 'xlsx',
        'disk' => 'local',
        'file_path' => $relativePath,
        'mapping' => [
            'handle' => 'handle',
            'name' => 'name',
            'sku' => 'sku',
            'price' => 'price',
            'currency' => 'currency',
        ],
        'status' => ImportStatus::Pending,
        'user_id' => $this->admin->id,
    ]);

    resolve(StartProductImport::class)->execute($import);
    createQueuedProducts();

    $product = Product::query()->where('slug', 'classic-perfume')->first();

    expect($product)->not->toBeNull();

    $price = $product->prices()->first();

    expect($price)->not->toBeNull()
        ->and($price->currency_id)->toBe($currency->id)
        ->and($price->amount)->toBe(4999);

    $import->refresh();

    expect($import->status)->toBe(ImportStatus::Completed)
        ->and($import->failed_count)->toBe(0);
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

    expect(Product::query()->where('slug', 'canvas-bag')->exists())->toBeFalse()
        ->and(PendingProduct::query()->where('sku', 'BAG-1')->value('name'))->toBe('Canvas Bag')
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

test('users without permission cannot export products', function (): void {
    $this->get(route('shopper.products.export-xlsx'))->assertRedirect();

    $this->actingAs(User::factory()->create())
        ->get(route('shopper.products.export-xlsx'))
        ->assertRedirect();
});

test('admins see the export button and can download the export', function (): void {
    Livewire::actingAs($this->admin)
        ->test(ProductIndex::class)
        ->assertSee(route('shopper.products.export-xlsx'))
        ->assertSee(__('backend.product_imports.export_action'))
        ->assertDontSeeHtml('href="'.route('shopper.products.export-xlsx').'" wire:navigate');

    $this->actingAs($this->admin)
        ->get(route('shopper.products.export-xlsx'))
        ->assertOk()
        ->assertDownload('products-'.now()->format('Y-m-d').'.xlsx');
});

test('exported products can be imported back without changes', function (): void {
    Queue::fake([DownloadProductImageJob::class]);
    Inventory::factory()->create(['is_default' => true]);

    $template = writeProductImportXlsx('round-trip-source.xlsx', resolve(ProductImportTemplate::class)->rows());
    importXlsxAndCreateQueuedProducts($template, $this->admin->id);

    $rows = iterator_to_array(resolve(BuildsProductExportRows::class)->handle(), false);
    $exported = collect($rows)->skip(1)->map(fn (array $row): array => array_combine(ProductImportTemplate::COLUMNS, $row))->values();

    expect($rows[0])->toBe(ProductImportTemplate::COLUMNS)
        ->and($exported)->toHaveCount(5)
        ->and($exported[0])->toMatchArray([
            'handle' => 'futbolka-bazova',
            'name' => 'Футболка базова',
            'category' => 'Одяг > Футболки',
            'featured' => '1',
            'supplier' => 'ТОВ Текстиль',
            'attributes' => 'Матеріал: Бавовна | Еластан; Країна виробництва: Україна',
            'variations' => '',
            'sku' => 'TS-BASE',
        ])
        ->and($exported[1])->toMatchArray([
            'handle' => 'futbolka-bazova',
            'variations' => 'Розмір: M; Колір: Синій',
            'sku' => 'TS-M-BLUE',
            'price' => '499',
            'quantity' => '10',
            'weight_value' => '180',
            'depth_value' => '40',
        ])
        ->and($exported[4])->toMatchArray([
            'handle' => 'parfum-klasychnyi',
            'variations' => '',
            'sku' => 'PF-50',
            'price' => '1299',
            'weight_value' => '0.3',
            'weight_unit' => 'kg',
        ]);

    $export = writeProductImportXlsx('round-trip-export.xlsx', $rows);
    $import = createXlsxProductImport($export, $this->admin->id);
    resolve(StartProductImport::class)->execute($import);

    $tShirt = Product::query()->where('slug', 'futbolka-bazova')->firstOrFail();

    $import->refresh();

    expect($import->errors ?? [])->toBe([])
        ->and($import->imported_count)->toBe(2)
        ->and($import->queued_count)->toBe(0)
        ->and(PendingProduct::query()->count())->toBe(0)
        ->and(Product::query()->count())->toBe(2)
        ->and($tShirt->variants()->count())->toBe(3)
        ->and($tShirt->variants()->where('sku', 'TS-M-BLUE')->firstOrFail()->getStock())->toBe(10)
        ->and(productAttributeValues($tShirt))->toBe([
            'Країна виробництва' => ['Україна'],
            'Матеріал' => ['Бавовна', 'Еластан'],
        ]);
});

test('admins can download the excel import template', function (): void {
    $this->actingAs($this->admin)
        ->get(route('shopper.products.import-xlsx-template'))
        ->assertOk()
        ->assertDownload('product-import.xlsx');
});
