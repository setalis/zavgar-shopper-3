<?php

declare(strict_types=1);

use App\Actions\GetCountriesByZone;
use App\Actions\ZoneSessionManager;
use App\Models\Product;
use App\Models\User;
use App\Storefront\Cart\CartGateway;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Shopper\Core\Models\Carrier;
use Shopper\Core\Models\CarrierOption;
use Shopper\Core\Models\Country;
use Shopper\Core\Models\Currency;
use Shopper\Core\Models\Inventory;
use Shopper\Core\Models\Order;
use Shopper\Core\Models\PaymentMethod;
use Shopper\Core\Models\Price;
use Shopper\Core\Models\Setting;
use Shopper\Core\Models\Zone;
use Shopper\Database\Seeders\AuthTableSeeder;

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
    $this->seed(AuthTableSeeder::class);
});

test('guests are redirected away from checkout', function (): void {
    $this->get(route('shop.checkout.index'))->assertRedirect();
});

test('authenticated customers can place a cash-on-delivery order', function (): void {
    $user = User::factory()->create();
    $product = Product::factory()->standard()->create([
        'name' => 'Studio Camera',
        'slug' => 'studio-camera',
        'allow_backorder' => true,
    ]);

    Price::query()->create([
        'priceable_type' => 'product',
        'priceable_id' => $product->id,
        'amount' => 19900,
        'compare_amount' => null,
        'cost_amount' => null,
        'currency_id' => $this->currency->id,
    ]);

    $inventory = Inventory::factory()->create([
        'is_default' => true,
        'code' => 'checkout-wh',
    ]);

    $product->mutateStock($inventory->id, 5);

    $zone = Zone::factory()->create([
        'name' => 'Ukraine',
        'currency_id' => $this->currency->id,
        'is_enabled' => true,
    ]);

    $country = Country::factory()->create([
        'name' => 'Ukraine',
        'cca2' => 'UA',
        'cca3' => 'UKR',
    ]);

    $zone->countries()->attach($country->id);

    $paymentMethod = PaymentMethod::factory()->create([
        'title' => 'Cash on delivery',
        'slug' => 'cod',
        'driver' => 'manual',
        'is_enabled' => true,
    ]);

    $zone->paymentMethods()->attach($paymentMethod->id);

    $carrier = Carrier::factory()->create([
        'name' => 'Manual Post',
        'slug' => 'manual-post',
        'is_enabled' => true,
        'driver' => null,
    ]);

    $zone->carriers()->attach($carrier->id);

    $shippingOption = CarrierOption::factory()->create([
        'name' => 'Standard delivery',
        'price' => 500,
        'carrier_id' => $carrier->id,
        'zone_id' => $zone->id,
        'is_enabled' => true,
    ]);

    GetCountriesByZone::flush();
    Cache::forget("zone.country.{$country->id}");

    $this->actingAs($user);
    ZoneSessionManager::setSessionForCountryCode($country->cca2);

    $this->post(route('shop.cart.add'), [
        'product_id' => $product->id,
        'quantity' => 1,
    ])->assertRedirect();

    $this->get(route('shop.checkout.index'))
        ->assertOk()
        ->assertInertia(fn ($page) => $page->component('shop/checkout'));

    $this->post(route('shop.checkout.shipping-address'), [
        'first_name' => 'Olena',
        'last_name' => 'Koval',
        'street_address' => 'Khreshchatyk 1',
        'street_address_plus' => null,
        'postal_code' => '01001',
        'city' => 'Kyiv',
        'state' => null,
        'phone_number' => '0955807707',
    ])->assertRedirect(route('shop.checkout.index'));

    $this->post(route('shop.checkout.shipping-option'), [
        'service_code' => $shippingOption->public_id ?? $shippingOption->id,
    ])->assertRedirect(route('shop.checkout.index'));

    $this->post(route('shop.checkout.prepare-payment'), [
        'payment_method_id' => $paymentMethod->id,
    ])->assertRedirect(route('shop.checkout.index', ['step' => 3]));

    $this->post(route('shop.checkout.place-order'), [
        'payment_method_id' => $paymentMethod->id,
    ])->assertSessionHasNoErrors();

    $order = Order::query()
        ->where('customer_id', $user->id)
        ->first();

    expect($order)->not->toBeNull()
        ->and($order->payment_method_id)->toBe($paymentMethod->id)
        ->and($order->email)->toBe($user->email);

    $this->get(route('shop.checkout.success', $order))
        ->assertOk()
        ->assertInertia(fn ($page) => $page
            ->component('shop/checkout-success')
            ->where('order.id', $order->id)
        );

    expect(resolve(CartGateway::class)->current())->toBeNull();
});
