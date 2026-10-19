<?php

declare(strict_types=1);

use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Shopper\Core\Enum\FieldType;
use Shopper\Core\Models\Attribute;
use Shopper\Core\Models\AttributeValue;
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

test('product page lists variant options by variant position', function (): void {
    $product = Product::factory()->variant()->create([
        'name' => 'Wave power excellence 10W-30',
        'slug' => 'wave-power-excellence-10w-30',
    ]);

    $volume = Attribute::factory()->create([
        'name' => "Об'єм",
        'slug' => 'volume',
        'type' => FieldType::Select,
        'is_enabled' => true,
    ]);

    $fiveLiters = AttributeValue::factory()->create([
        'attribute_id' => $volume->id,
        'key' => '5-l',
        'value' => '5 л.',
        'position' => 1,
    ]);

    $fourLiters = AttributeValue::factory()->create([
        'attribute_id' => $volume->id,
        'key' => '4-l',
        'value' => '4 л.',
        'position' => 2,
    ]);

    $inventory = Inventory::factory()->create([
        'is_default' => true,
        'code' => 'default-wh',
    ]);

    $fourLiterVariant = ProductVariant::factory()->create([
        'product_id' => $product->id,
        'name' => '4 л.',
        'sku' => 'oil-4l',
        'position' => 1,
    ]);

    $fiveLiterVariant = ProductVariant::factory()->create([
        'product_id' => $product->id,
        'name' => '5 л.',
        'sku' => 'oil-5l',
        'position' => 2,
    ]);

    $fourLiterVariant->values()->attach($fourLiters->id);
    $fiveLiterVariant->values()->attach($fiveLiters->id);

    foreach ([$fourLiterVariant, $fiveLiterVariant] as $variant) {
        Price::query()->create([
            'priceable_type' => 'variant',
            'priceable_id' => $variant->id,
            'amount' => 50000,
            'compare_amount' => null,
            'cost_amount' => null,
            'currency_id' => $this->currency->id,
        ]);

        $variant->mutateStock($inventory->id, 1);
    }

    expect($fourLiters->id)->toBeGreaterThan($fiveLiters->id);

    $this->get(route('shop.product', $product))
        ->assertOk()
        ->assertInertia(fn ($page) => $page
            ->component('shop/product')
            ->where('variantOptions.hasStructuredAttributes', true)
            ->where('variantOptions.productOptions.0.values.0.value', '4 л.')
            ->where('variantOptions.productOptions.0.values.1.value', '5 л.')
            ->where('variantOptions.productOptions.0.values.0.id', $fourLiters->id)
            ->where('variantOptions.productOptions.0.values.1.id', $fiveLiters->id)
        );
});
