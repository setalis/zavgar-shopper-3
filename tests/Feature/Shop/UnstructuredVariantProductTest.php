<?php

declare(strict_types=1);

use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Shopper\Core\Models\Currency;
use Shopper\Core\Models\Inventory;
use Shopper\Core\Models\Price;
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

    $this->currency = $currency;
});

test('product page exposes variant stock when variants have no attribute values', function (): void {
    $product = Product::factory()->variant()->create([
        'name' => 'Oil without options',
        'slug' => 'oil-without-options',
    ]);

    $inventory = Inventory::factory()->create([
        'is_default' => true,
        'code' => 'default-wh',
    ]);

    $oneLiter = ProductVariant::factory()->create([
        'product_id' => $product->id,
        'name' => '1 L',
        'sku' => 'oil-1l',
        'position' => 1,
        'weight_value' => 1,
        'weight_unit' => 'kg',
    ]);

    $twentyLiters = ProductVariant::factory()->create([
        'product_id' => $product->id,
        'name' => '20 L',
        'sku' => 'oil-20l',
        'position' => 2,
        'weight_value' => 20,
        'weight_unit' => 'kg',
    ]);

    Price::query()->create([
        'priceable_type' => 'variant',
        'priceable_id' => $oneLiter->id,
        'amount' => 50000,
        'compare_amount' => null,
        'cost_amount' => null,
        'currency_id' => $this->currency->id,
    ]);

    Price::query()->create([
        'priceable_type' => 'variant',
        'priceable_id' => $twentyLiters->id,
        'amount' => 800000,
        'compare_amount' => null,
        'cost_amount' => null,
        'currency_id' => $this->currency->id,
    ]);

    $oneLiter->mutateStock($inventory->id, 3);
    $twentyLiters->mutateStock($inventory->id, 6);

    $this->get(route('shop.product', $product))
        ->assertOk()
        ->assertInertia(fn ($page) => $page
            ->component('shop/product')
            ->has('product.variants', 2)
            ->where('product.variants.0.stock', 3)
            ->where('product.variants.1.stock', 6)
            ->where('variantOptions.hasStructuredAttributes', false)
            ->has('variantOptions.variantMap', 2)
        );
});
