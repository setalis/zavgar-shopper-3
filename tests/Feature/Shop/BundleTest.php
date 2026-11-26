<?php

declare(strict_types=1);

use App\Actions\Bundle\SyncBundleItems;
use App\Models\Product;
use App\Models\ProductBundleItem;
use App\Models\ProductVariant;
use App\Storefront\Cart\CartGateway;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Illuminate\Validation\ValidationException;
use Shopper\Core\Models\Currency;
use Shopper\Core\Models\Inventory;
use Shopper\Core\Models\Price;
use Shopper\Core\Models\Setting;

uses(RefreshDatabase::class);

beforeEach(function (): void {
    $this->currency = Currency::query()->create([
        'name' => 'US Dollar',
        'code' => 'USD',
        'symbol' => '$',
        'format' => '$1,234.56',
    ]);

    Setting::query()->create([
        'key' => 'default_currency_id',
        'display_name' => 'Currency',
        'value' => $this->currency->id,
        'locked' => true,
    ]);

    Cache::forget('shopper-setting.default_currency_id');
    Cache::forget('shopper-setting.default_currency');

    $this->inventory = Inventory::factory()->create([
        'is_default' => true,
        'code' => 'bundle-wh',
    ]);
});

function priceBundleTestModel(Model $priceable, int $amount, Currency $currency): void
{
    Price::query()->create([
        'priceable_type' => $priceable->getMorphClass(),
        'priceable_id' => $priceable->id,
        'amount' => $amount,
        'currency_id' => $currency->id,
    ]);
}

/**
 * @param  list<array{0: Product|ProductVariant, 1: int}>  $components
 */
function makeBundleTestBundle(array $components, array $attributes = []): Product
{
    $bundle = Product::factory()->standard()->create([
        'name' => 'Oil change kit',
        'slug' => 'oil-change-kit',
        'is_bundle' => true,
        ...$attributes,
    ]);

    foreach ($components as $position => [$component, $quantity]) {
        $factory = ProductBundleItem::factory()->state([
            'bundle_id' => $bundle->id,
            'quantity' => $quantity,
            'position' => $position,
        ]);

        $component instanceof ProductVariant
            ? $factory->forVariant($component)->create()
            : $factory->create(['product_id' => $component->id]);
    }

    return $bundle->fresh();
}

test('bundle stock is the number of complete sets the components allow', function (): void {
    $oil = Product::factory()->standard()->create();
    $filter = Product::factory()->standard()->create();
    $oil->mutateStock($this->inventory->id, 9);
    $filter->mutateStock($this->inventory->id, 7);

    $bundle = makeBundleTestBundle([[$oil, 4], [$filter, 1]]);

    expect($bundle->stock)->toBe(2)
        ->and($bundle->inStock(2))->toBeTrue()
        ->and($bundle->inStock(3))->toBeFalse();
});

test('bundle stock uses the pinned variant stock', function (): void {
    $oil = Product::factory()->variant()->create();
    $fiveLitres = ProductVariant::factory()->create(['product_id' => $oil->id]);
    $oneLitre = ProductVariant::factory()->create(['product_id' => $oil->id]);
    $fiveLitres->mutateStock($this->inventory->id, 3);
    $oneLitre->mutateStock($this->inventory->id, 50);

    $bundle = makeBundleTestBundle([[$fiveLitres, 1]]);

    expect($bundle->stock)->toBe(3);
});

test('bundle is out of stock when a component is unpublished', function (): void {
    $oil = Product::factory()->standard()->unpublished()->create();
    $oil->mutateStock($this->inventory->id, 10);

    $bundle = makeBundleTestBundle([[$oil, 1]]);

    expect($bundle->stock)->toBe(0)
        ->and($bundle->inStock())->toBeFalse();
});

test('back-ordered components do not block the bundle', function (): void {
    $oil = Product::factory()->standard()->create(['allow_backorder' => true]);

    $bundle = makeBundleTestBundle([[$oil, 2]]);

    expect($bundle->inStock(5))->toBeTrue();
});

test('listings report the derived bundle stock', function (): void {
    $oil = Product::factory()->standard()->create();
    $oil->mutateStock($this->inventory->id, 6);

    makeBundleTestBundle([[$oil, 2]]);

    $this->get(route('shop.index'))
        ->assertOk()
        ->assertInertia(fn ($page) => $page
            ->component('shop/index')
            ->where('products.data', fn ($products): bool => collect($products)
                ->firstWhere('slug', 'oil-change-kit')['storefront_stock'] === 3)
        );
});

test('a bundle cannot be added to the cart beyond its component stock', function (): void {
    $oil = Product::factory()->standard()->create();
    $oil->mutateStock($this->inventory->id, 3);

    $bundle = makeBundleTestBundle([[$oil, 2]]);
    priceBundleTestModel($bundle, 5000, $this->currency);

    $this->post(route('shop.cart.add'), ['product_id' => $bundle->id, 'quantity' => 2])
        ->assertSessionHasErrors('cart');

    $this->post(route('shop.cart.add'), ['product_id' => $bundle->id, 'quantity' => 1])
        ->assertSessionHasNoErrors();

    expect(resolve(CartGateway::class)->current()->lines)->toHaveCount(1);
});

test('the product page exposes the bundle composition and savings', function (): void {
    $oil = Product::factory()->standard()->create(['name' => 'Engine oil']);
    $filter = Product::factory()->standard()->create(['name' => 'Oil filter']);
    $oil->mutateStock($this->inventory->id, 10);
    $filter->mutateStock($this->inventory->id, 10);
    priceBundleTestModel($oil, 1000, $this->currency);
    priceBundleTestModel($filter, 500, $this->currency);

    $bundle = makeBundleTestBundle([[$oil, 4], [$filter, 1]]);
    priceBundleTestModel($bundle, 4000, $this->currency);

    $this->get(route('shop.product', $bundle))
        ->assertOk()
        ->assertInertia(fn ($page) => $page
            ->component('shop/product')
            ->where('product.stock', 2)
            ->where('bundle.componentsTotal', 4500)
            ->where('bundle.bundleAmount', 4000)
            ->where('bundle.savings', 500)
            ->has('bundle.items', 2)
            ->where('bundle.items.0.name', 'Engine oil')
            ->where('bundle.items.0.quantity', 4)
        );
});

test('regular products have no bundle composition', function (): void {
    $product = Product::factory()->standard()->create(['slug' => 'plain-oil']);

    $this->get(route('shop.product', $product))
        ->assertOk()
        ->assertInertia(fn ($page) => $page->where('bundle', null));
});

test('syncing stores the bundle composition', function (): void {
    $bundle = Product::factory()->standard()->create();
    $oil = Product::factory()->variant()->create();
    $variant = ProductVariant::factory()->create(['product_id' => $oil->id]);
    $filter = Product::factory()->standard()->create();

    resolve(SyncBundleItems::class)->handle($bundle, true, [
        ['product_id' => $oil->id, 'product_variant_id' => $variant->id, 'quantity' => 2],
        ['product_id' => $filter->id, 'product_variant_id' => null, 'quantity' => 1],
    ]);

    expect($bundle->fresh()->is_bundle)->toBeTrue()
        ->and($bundle->bundleItems()->get()->map->only(['product_id', 'product_variant_id', 'quantity'])->all())
        ->toBe([
            ['product_id' => $oil->id, 'product_variant_id' => $variant->id, 'quantity' => 2],
            ['product_id' => $filter->id, 'product_variant_id' => null, 'quantity' => 1],
        ]);
});

test('turning the bundle off removes its composition', function (): void {
    $oil = Product::factory()->standard()->create();
    $bundle = makeBundleTestBundle([[$oil, 1]]);

    resolve(SyncBundleItems::class)->handle($bundle, false, []);

    expect($bundle->fresh()->is_bundle)->toBeFalse()
        ->and(ProductBundleItem::query()->where('bundle_id', $bundle->id)->exists())->toBeFalse();
});

test('syncing rejects an invalid composition', function (Closure $items): void {
    $bundle = Product::factory()->standard()->create(['is_bundle' => true]);

    expect(fn () => resolve(SyncBundleItems::class)->handle($bundle, true, $items($bundle)))
        ->toThrow(ValidationException::class);

    expect(ProductBundleItem::query()->where('bundle_id', $bundle->id)->exists())->toBeFalse();
})->with([
    'no components' => [fn (Product $bundle): array => []],
    'the bundle itself' => [fn (Product $bundle): array => [['product_id' => $bundle->id, 'quantity' => 1]]],
    'a nested bundle' => [fn (Product $bundle): array => [[
        'product_id' => Product::factory()->standard()->create(['is_bundle' => true])->id,
        'quantity' => 1,
    ]]],
    'a virtual product' => [fn (Product $bundle): array => [[
        'product_id' => Product::factory()->virtual()->create()->id,
        'quantity' => 1,
    ]]],
    'a variant product without a variant' => [fn (Product $bundle): array => [[
        'product_id' => Product::factory()->variant()->create()->id,
        'quantity' => 1,
    ]]],
    'a variant of another product' => [function (Product $bundle): array {
        $oil = Product::factory()->variant()->create();
        $foreign = ProductVariant::factory()->create(['product_id' => Product::factory()->variant()->create()->id]);

        return [['product_id' => $oil->id, 'product_variant_id' => $foreign->id, 'quantity' => 1]];
    }],
    'a zero quantity' => [fn (Product $bundle): array => [[
        'product_id' => Product::factory()->standard()->create()->id,
        'quantity' => 0,
    ]]],
    'a duplicate component' => [function (Product $bundle): array {
        $oil = Product::factory()->standard()->create();

        return [
            ['product_id' => $oil->id, 'quantity' => 1],
            ['product_id' => $oil->id, 'quantity' => 2],
        ];
    }],
]);
