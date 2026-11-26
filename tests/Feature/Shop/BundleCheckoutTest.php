<?php

declare(strict_types=1);

use App\Actions\GetCountriesByZone;
use App\Actions\ZoneSessionManager;
use App\Listeners\RestoreBundleComponentStock;
use App\Models\Product;
use App\Models\ProductBundleItem;
use App\Models\ProductVariant;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Shopper\Core\Contracts\StockReserver;
use Shopper\Core\Events\Orders\OrderCancelled;
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

    $this->seed(AuthTableSeeder::class);

    $this->inventory = Inventory::factory()->create([
        'is_default' => true,
        'code' => 'bundle-checkout-wh',
    ]);

    $this->oil = Product::factory()->variant()->create(['name' => 'Engine oil']);
    $this->oilVariant = ProductVariant::factory()->create([
        'product_id' => $this->oil->id,
        'name' => '1 L',
        'sku' => 'OIL-1L',
    ]);
    $this->filter = Product::factory()->standard()->create(['name' => 'Oil filter', 'sku' => 'FILTER']);
    $this->oilVariant->mutateStock($this->inventory->id, 10);
    $this->filter->mutateStock($this->inventory->id, 5);

    $this->bundle = Product::factory()->standard()->create([
        'name' => 'Oil change kit',
        'slug' => 'oil-change-kit',
        'is_bundle' => true,
    ]);

    ProductBundleItem::factory()->forVariant($this->oilVariant)->create([
        'bundle_id' => $this->bundle->id,
        'quantity' => 4,
    ]);
    ProductBundleItem::factory()->create([
        'bundle_id' => $this->bundle->id,
        'product_id' => $this->filter->id,
        'quantity' => 1,
        'position' => 1,
    ]);

    Price::query()->create([
        'priceable_type' => 'product',
        'priceable_id' => $this->bundle->id,
        'amount' => 4000,
        'currency_id' => $currency->id,
    ]);

    $zone = Zone::factory()->create([
        'name' => 'Ukraine',
        'currency_id' => $currency->id,
        'is_enabled' => true,
    ]);

    $this->country = Country::factory()->create([
        'name' => 'Ukraine',
        'cca2' => 'UA',
        'cca3' => 'UKR',
    ]);

    $zone->countries()->attach($this->country->id);

    $this->paymentMethod = PaymentMethod::factory()->create([
        'title' => 'Cash on delivery',
        'slug' => 'cod',
        'driver' => 'manual',
        'is_enabled' => true,
    ]);

    $zone->paymentMethods()->attach($this->paymentMethod->id);

    $carrier = Carrier::factory()->create([
        'name' => 'Manual Post',
        'slug' => 'manual-post',
        'is_enabled' => true,
        'driver' => null,
    ]);

    $zone->carriers()->attach($carrier->id);

    $this->shippingOption = CarrierOption::factory()->create([
        'name' => 'Standard delivery',
        'price' => 500,
        'carrier_id' => $carrier->id,
        'zone_id' => $zone->id,
        'is_enabled' => true,
    ]);

    GetCountriesByZone::flush();
    Cache::forget("zone.country.{$this->country->id}");
});

function checkoutBundle(int $quantity): void
{
    ZoneSessionManager::setSessionForCountryCode(test()->country->cca2);

    test()->post(route('shop.cart.add'), [
        'product_id' => test()->bundle->id,
        'quantity' => $quantity,
    ])->assertSessionHasNoErrors();

    test()->post(route('shop.checkout.shipping-address'), [
        'first_name' => 'Olena',
        'last_name' => 'Koval',
        'email' => 'guest@example.com',
        'street_address' => 'Khreshchatyk 1',
        'street_address_plus' => null,
        'postal_code' => '01001',
        'city' => 'Kyiv',
        'state' => null,
        'phone_number' => '0955807707',
    ]);

    test()->post(route('shop.checkout.shipping-option'), [
        'service_code' => test()->shippingOption->public_id ?? test()->shippingOption->id,
    ]);

    test()->post(route('shop.checkout.prepare-payment'), [
        'payment_method_id' => test()->paymentMethod->id,
    ]);
}

test('placing an order reserves the bundle components instead of the bundle', function (): void {
    checkoutBundle(2);

    $this->post(route('shop.checkout.place-order'), [
        'payment_method_id' => $this->paymentMethod->id,
    ])->assertSessionHasNoErrors();

    $order = Order::query()->with('items')->sole();

    expect($this->oilVariant->fresh()->stock)->toBe(2)
        ->and($this->filter->fresh()->stock)->toBe(3)
        ->and($this->bundle->inventoryHistories()->exists())->toBeFalse()
        ->and($order->items)->toHaveCount(1)
        ->and($order->items->first()->metadata['bundle'])->toBe([
            [
                'name' => 'Engine oil / 1 L',
                'sku' => 'OIL-1L',
                'quantity' => 4,
                'stockable_type' => $this->oilVariant->getMorphClass(),
                'stockable_id' => $this->oilVariant->id,
            ],
            [
                'name' => 'Oil filter',
                'sku' => 'FILTER',
                'quantity' => 1,
                'stockable_type' => $this->filter->getMorphClass(),
                'stockable_id' => $this->filter->id,
            ],
        ]);
});

test('the order is rolled back when a component runs short at checkout', function (): void {
    checkoutBundle(2);

    $this->filter->decreaseStock($this->inventory->id, 4);

    $this->post(route('shop.checkout.place-order'), [
        'payment_method_id' => $this->paymentMethod->id,
    ])->assertSessionHasErrors();

    expect(Order::query()->exists())->toBeFalse()
        ->and($this->oilVariant->fresh()->stock)->toBe(10)
        ->and($this->filter->fresh()->stock)->toBe(1);
});

test('a short component releases the components already reserved for the bundle', function (): void {
    $reserved = resolve(StockReserver::class)->reserve($this->bundle->fresh(), 3);

    expect($reserved)->toBe(2)
        ->and($this->filter->fresh()->stock)->toBe(5)
        ->and($this->oilVariant->fresh()->stock)->toBe(10);
});

test('cancelling the order returns the bundle components to stock', function (): void {
    checkoutBundle(1);

    $this->post(route('shop.checkout.place-order'), [
        'payment_method_id' => $this->paymentMethod->id,
    ])->assertSessionHasNoErrors();

    $order = Order::query()->sole();

    resolve(RestoreBundleComponentStock::class)->handle(new OrderCancelled($order));
    resolve(RestoreBundleComponentStock::class)->handle(new OrderCancelled($order));

    expect($this->oilVariant->fresh()->stock)->toBe(10)
        ->and($this->filter->fresh()->stock)->toBe(5);
});
