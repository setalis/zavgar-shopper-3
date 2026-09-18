<?php

declare(strict_types=1);

use App\Models\Product;
use App\Storefront\Cart\CartGateway;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Shopper\Core\Models\Currency;
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

function pricedStandardProduct(Currency $currency, string $name = 'Studio Camera', string $slug = 'studio-camera'): Product
{
    $product = Product::factory()->standard()->create([
        'name' => $name,
        'slug' => $slug,
        'allow_backorder' => true,
    ]);

    Price::query()->create([
        'priceable_type' => 'product',
        'priceable_id' => $product->id,
        'amount' => 19900,
        'compare_amount' => null,
        'cost_amount' => null,
        'currency_id' => $currency->id,
    ]);

    return $product;
}

test('guests can add a priced product to the cart', function (): void {
    $product = pricedStandardProduct($this->currency);

    $this->from(route('shop.product', $product))
        ->post(route('shop.cart.add'), [
            'product_id' => $product->id,
            'quantity' => 1,
        ])
        ->assertRedirect(route('shop.product', $product))
        ->assertSessionHasNoErrors();

    $this->get(route('shop.cart'))
        ->assertOk()
        ->assertInertia(fn ($page) => $page
            ->component('shop/cart')
            ->has('cart.lines', 1)
            ->where('cart.lines.0.purchasable.id', $product->id)
            ->where('cart.lines.0.quantity', 1)
            ->where('shop.cart_count', 1)
        );
});

test('cart quantity can be updated and the line can be removed', function (): void {
    $product = pricedStandardProduct($this->currency);

    $this->post(route('shop.cart.add'), [
        'product_id' => $product->id,
        'quantity' => 1,
    ])->assertRedirect();

    $lineId = resolve(CartGateway::class)->current()?->lines->first()?->id;

    expect($lineId)->toBeInt();

    $this->patch(route('shop.cart.update', $lineId), [
        'quantity' => 3,
    ])->assertRedirect();

    $this->get(route('shop.cart'))
        ->assertOk()
        ->assertInertia(fn ($page) => $page
            ->has('cart.lines', 1)
            ->where('cart.lines.0.quantity', 3)
            ->where('shop.cart_count', 3)
        );

    $this->delete(route('shop.cart.destroy', $lineId))->assertRedirect();

    $this->get(route('shop.cart'))
        ->assertOk()
        ->assertInertia(fn ($page) => $page
            ->where('shop.cart_count', 0)
        );
});

test('clearing the cart removes every line', function (): void {
    $product = pricedStandardProduct($this->currency, 'Desk Lamp', 'desk-lamp');

    $this->post(route('shop.cart.add'), [
        'product_id' => $product->id,
        'quantity' => 2,
    ])->assertRedirect();

    $this->delete(route('shop.cart.clear'))->assertRedirect();

    $this->get(route('shop.cart'))
        ->assertOk()
        ->assertInertia(fn ($page) => $page
            ->component('shop/cart')
            ->where('shop.cart_count', 0)
        );
});
