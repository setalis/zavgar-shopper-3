<?php

declare(strict_types=1);

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Shopper\Core\Models\Currency;
use Shopper\Core\Models\ProductTag;
use Shopper\Core\Models\Setting;

uses(RefreshDatabase::class);

beforeEach(function (): void {
    $currency = Currency::query()->create([
        'name' => 'US Dollar',
        'code' => 'USD',
        'symbol' => '$',
        'format' => '$1,234.56',
    ]);

    Setting::query()->create([
        'key' => 'default_currency_id',
        'display_name' => 'Currency',
        'value' => $currency->id,
        'locked' => true,
    ]);

    Cache::forget('shopper-setting.default_currency_id');
    Cache::forget('shopper-setting.default_currency');
});

test('search page finds a published product by sku', function (): void {
    $product = Product::factory()->standard()->create([
        'name' => 'Wireless Headphones',
        'slug' => 'wireless-headphones',
        'sku' => 'SKU-1001',
    ]);

    Product::factory()->standard()->create([
        'name' => 'Desk Lamp',
        'slug' => 'desk-lamp',
        'sku' => 'SKU-2002',
    ]);

    $this->get(route('shop.search', ['q' => 'SKU-1001']))
        ->assertOk()
        ->assertInertia(fn ($page) => $page
            ->component('shop/search')
            ->where('query', 'SKU-1001')
            ->has('products.data', 1)
            ->where('products.data.0.id', $product->id)
        );
});

test('search page finds a variant product by variant sku', function (): void {
    $product = Product::factory()->variant()->create([
        'name' => 'Winter Jacket',
        'slug' => 'winter-jacket',
        'sku' => 'SKU-PARENT',
    ]);

    ProductVariant::factory()->create([
        'product_id' => $product->id,
        'name' => 'Red',
        'sku' => 'SKU-JACKET-RED',
        'position' => 1,
    ]);

    Product::factory()->standard()->create([
        'name' => 'Other Product',
        'slug' => 'other-product',
        'sku' => 'SKU-OTHER',
    ]);

    $this->get(route('shop.search', ['q' => 'SKU-JACKET-RED']))
        ->assertOk()
        ->assertInertia(fn ($page) => $page
            ->component('shop/search')
            ->has('products.data', 1)
            ->where('products.data.0.id', $product->id)
            ->where('products.data.0.name', 'Winter Jacket')
        );
});

test('search page still finds products by name', function (): void {
    $product = Product::factory()->standard()->create([
        'name' => 'Wireless Headphones',
        'slug' => 'wireless-headphones',
        'sku' => 'SKU-1001',
    ]);

    Product::factory()->standard()->create([
        'name' => 'Desk Lamp',
        'slug' => 'desk-lamp',
        'sku' => 'SKU-2002',
    ]);

    $this->get(route('shop.search', ['q' => 'Headphones']))
        ->assertOk()
        ->assertInertia(fn ($page) => $page
            ->component('shop/search')
            ->has('products.data', 1)
            ->where('products.data.0.id', $product->id)
        );
});

test('search page does not return unpublished products matching the sku', function (): void {
    Product::factory()->create([
        'name' => 'Draft Widget',
        'slug' => 'draft-widget',
        'sku' => 'SKU-DRAFT-99',
        'is_visible' => false,
        'published_at' => now(),
    ]);

    $this->get(route('shop.search', ['q' => 'SKU-DRAFT-99']))
        ->assertOk()
        ->assertInertia(fn ($page) => $page
            ->component('shop/search')
            ->has('products.data', 0)
        );
});

test('search suggestions find a published product by sku', function (): void {
    $product = Product::factory()->standard()->create([
        'name' => 'Wireless Headphones',
        'slug' => 'wireless-headphones',
        'sku' => 'SKU-1001',
    ]);

    Product::factory()->standard()->create([
        'name' => 'Desk Lamp',
        'slug' => 'desk-lamp',
        'sku' => 'SKU-2002',
    ]);

    $this->getJson(route('shop.search.suggest', ['q' => 'SKU-1001']))
        ->assertSuccessful()
        ->assertJsonCount(1, 'products')
        ->assertJsonPath('products.0.id', $product->id)
        ->assertJsonPath('products.0.name', 'Wireless Headphones')
        ->assertJsonPath('products.0.slug', 'wireless-headphones')
        ->assertJsonPath('products.0.sku', 'SKU-1001');
});

test('search suggestions find a variant product by variant sku', function (): void {
    $product = Product::factory()->variant()->create([
        'name' => 'Winter Jacket',
        'slug' => 'winter-jacket',
        'sku' => 'SKU-PARENT',
    ]);

    ProductVariant::factory()->create([
        'product_id' => $product->id,
        'name' => 'Red',
        'sku' => 'SKU-JACKET-RED',
        'position' => 1,
    ]);

    Product::factory()->standard()->create([
        'name' => 'Other Product',
        'slug' => 'other-product',
        'sku' => 'SKU-OTHER',
    ]);

    $this->getJson(route('shop.search.suggest', ['q' => 'SKU-JACKET-RED']))
        ->assertSuccessful()
        ->assertJsonCount(1, 'products')
        ->assertJsonPath('products.0.id', $product->id)
        ->assertJsonPath('products.0.name', 'Winter Jacket');
});

test('search suggestions find products by name', function (): void {
    $product = Product::factory()->standard()->create([
        'name' => 'Wireless Headphones',
        'slug' => 'wireless-headphones',
        'sku' => 'SKU-1001',
    ]);

    Product::factory()->standard()->create([
        'name' => 'Desk Lamp',
        'slug' => 'desk-lamp',
        'sku' => 'SKU-2002',
    ]);

    $this->getJson(route('shop.search.suggest', ['q' => 'Headphones']))
        ->assertSuccessful()
        ->assertJsonCount(1, 'products')
        ->assertJsonPath('products.0.id', $product->id);
});

test('search suggestions do not return unpublished products', function (): void {
    Product::factory()->create([
        'name' => 'Draft Widget',
        'slug' => 'draft-widget',
        'sku' => 'SKU-DRAFT-99',
        'is_visible' => false,
        'published_at' => now(),
    ]);

    $this->getJson(route('shop.search.suggest', ['q' => 'SKU-DRAFT-99']))
        ->assertSuccessful()
        ->assertJsonCount(0, 'products');
});

test('search suggestions reject queries shorter than two characters', function (): void {
    $this->getJson(route('shop.search.suggest', ['q' => 'a']))
        ->assertUnprocessable()
        ->assertJsonValidationErrors(['q']);
});

test('search suggestions accept queries of two characters', function (): void {
    $product = Product::factory()->standard()->create([
        'name' => 'OC Adapter',
        'slug' => 'oc-adapter',
        'sku' => 'OC-205',
    ]);

    $this->getJson(route('shop.search.suggest', ['q' => 'OC']))
        ->assertSuccessful()
        ->assertJsonCount(1, 'products')
        ->assertJsonPath('products.0.id', $product->id);
});

test('search suggestions find products when punctuation differs from the sku', function (string $sku, string $query): void {
    $product = Product::factory()->standard()->create([
        'name' => 'OC Sensor',
        'slug' => 'oc-sensor',
        'sku' => $sku,
    ]);

    $this->getJson(route('shop.search.suggest', ['q' => $query]))
        ->assertSuccessful()
        ->assertJsonCount(1, 'products')
        ->assertJsonPath('products.0.id', $product->id);
})->with([
    'hyphenated sku and spaced query' => ['oc-205', 'oc 205'],
    'compact sku and spaced query' => ['oc205', 'oc 205'],
    'spaced sku and hyphenated query' => ['oc 205', 'oc-205'],
]);

test('search suggestions find a published product by category name', function (): void {
    $category = Category::factory()->create([
        'name' => 'Motor Oils',
        'slug' => 'motor-oils',
        'is_enabled' => true,
        'parent_id' => null,
    ]);

    $product = Product::factory()->standard()->create([
        'name' => 'Desk Lamp',
        'slug' => 'desk-lamp',
        'sku' => 'SKU-LAMP',
    ]);
    $product->categories()->attach($category);

    Product::factory()->standard()->create([
        'name' => 'Other Product',
        'slug' => 'other-product',
        'sku' => 'SKU-OTHER',
    ]);

    $this->getJson(route('shop.search.suggest', ['q' => 'Motor Oils']))
        ->assertSuccessful()
        ->assertJsonCount(1, 'products')
        ->assertJsonPath('products.0.id', $product->id);
});

test('search suggestions find a published product when punctuation differs from the category name', function (): void {
    $category = Category::factory()->create([
        'name' => 'OC-205 Filters',
        'slug' => 'oc-205-filters',
        'is_enabled' => true,
        'parent_id' => null,
    ]);

    $product = Product::factory()->standard()->create([
        'name' => 'Cabin Filter',
        'slug' => 'cabin-filter',
        'sku' => 'SKU-FILTER',
    ]);
    $product->categories()->attach($category);

    $this->getJson(route('shop.search.suggest', ['q' => 'oc 205']))
        ->assertSuccessful()
        ->assertJsonCount(1, 'products')
        ->assertJsonPath('products.0.id', $product->id);
});

test('search suggestions do not find products by a disabled category name', function (): void {
    $category = Category::factory()->create([
        'name' => 'Hidden Gear',
        'slug' => 'hidden-gear',
        'is_enabled' => false,
        'parent_id' => null,
    ]);

    $product = Product::factory()->standard()->create([
        'name' => 'Desk Lamp',
        'slug' => 'desk-lamp',
        'sku' => 'SKU-LAMP',
    ]);
    $product->categories()->attach($category);

    $this->getJson(route('shop.search.suggest', ['q' => 'Hidden']))
        ->assertSuccessful()
        ->assertJsonCount(0, 'products');
});

test('search suggestions find a published product by tag name', function (): void {
    $tag = ProductTag::factory()->create([
        'name' => 'Summer Sale',
        'slug' => 'summer-sale',
    ]);

    $product = Product::factory()->standard()->create([
        'name' => 'Desk Lamp',
        'slug' => 'desk-lamp',
        'sku' => 'SKU-LAMP',
    ]);
    $product->tags()->attach($tag);

    Product::factory()->standard()->create([
        'name' => 'Other Product',
        'slug' => 'other-product',
        'sku' => 'SKU-OTHER',
    ]);

    $this->getJson(route('shop.search.suggest', ['q' => 'Summer Sale']))
        ->assertSuccessful()
        ->assertJsonCount(1, 'products')
        ->assertJsonPath('products.0.id', $product->id);
});

test('search suggestions find a published product when punctuation differs from the tag name', function (): void {
    $tag = ProductTag::factory()->create([
        'name' => 'oc-205',
        'slug' => 'oc-205',
    ]);

    $product = Product::factory()->standard()->create([
        'name' => 'Cabin Filter',
        'slug' => 'cabin-filter',
        'sku' => 'SKU-FILTER',
    ]);
    $product->tags()->attach($tag);

    $this->getJson(route('shop.search.suggest', ['q' => 'oc 205']))
        ->assertSuccessful()
        ->assertJsonCount(1, 'products')
        ->assertJsonPath('products.0.id', $product->id);
});

test('search suggestions find a variant product when punctuation differs from the variant sku', function (): void {
    $product = Product::factory()->variant()->create([
        'name' => 'OC Housing',
        'slug' => 'oc-housing',
        'sku' => 'SKU-PARENT',
    ]);

    ProductVariant::factory()->create([
        'product_id' => $product->id,
        'name' => 'Black',
        'sku' => 'oc-205',
        'position' => 1,
    ]);

    $this->getJson(route('shop.search.suggest', ['q' => 'oc 205']))
        ->assertSuccessful()
        ->assertJsonCount(1, 'products')
        ->assertJsonPath('products.0.id', $product->id);
});

test('search suggestions return only the expected product keys', function (): void {
    Product::factory()->standard()->create([
        'name' => 'Wireless Headphones',
        'slug' => 'wireless-headphones',
        'sku' => 'SKU-1001',
    ]);

    $product = $this->getJson(route('shop.search.suggest', ['q' => 'Headphones']))
        ->assertSuccessful()
        ->json('products.0');

    expect(array_keys($product))->toEqualCanonicalizing([
        'id',
        'name',
        'slug',
        'sku',
        'thumbnail',
        'storefront_price',
    ]);
});

test('search suggestions return at most eight products', function (): void {
    foreach (range(1, 9) as $index) {
        Product::factory()->standard()->create([
            'name' => "Widget {$index}",
            'slug' => "widget-{$index}",
            'sku' => "SKU-W-{$index}",
        ]);
    }

    $this->getJson(route('shop.search.suggest', ['q' => 'Widget']))
        ->assertSuccessful()
        ->assertJsonCount(8, 'products');
});

test('shop catalog finds a published product by sku', function (): void {
    $product = Product::factory()->standard()->create([
        'name' => 'Wireless Headphones',
        'slug' => 'wireless-headphones',
        'sku' => 'SKU-1001',
    ]);

    Product::factory()->standard()->create([
        'name' => 'Desk Lamp',
        'slug' => 'desk-lamp',
        'sku' => 'SKU-2002',
    ]);

    $this->get(route('shop.index', ['search' => 'SKU-1001']))
        ->assertOk()
        ->assertInertia(fn ($page) => $page
            ->component('shop/index')
            ->where('filters.search', 'SKU-1001')
            ->has('products.data', 1)
            ->where('products.data.0.id', $product->id)
        );
});
