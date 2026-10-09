<?php

declare(strict_types=1);

use App\Actions\CreateOrder;
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

/**
 * @return array{product: Product, paymentMethod: PaymentMethod, shippingOption: CarrierOption, country: Country}
 */
function createCheckoutCatalog(Currency $currency, int $productAmount = 19900, int $deliveryAmount = 500): array
{
    $product = Product::factory()->standard()->create([
        'name' => 'Studio Camera',
        'slug' => 'studio-camera',
        'allow_backorder' => true,
    ]);

    Price::query()->create([
        'priceable_type' => 'product',
        'priceable_id' => $product->id,
        'amount' => $productAmount,
        'compare_amount' => null,
        'cost_amount' => null,
        'currency_id' => $currency->id,
    ]);

    $inventory = Inventory::factory()->create([
        'is_default' => true,
        'code' => 'checkout-wh',
    ]);

    $product->mutateStock($inventory->id, 5);

    $zone = Zone::factory()->create([
        'name' => 'Ukraine',
        'currency_id' => $currency->id,
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
        'price' => $deliveryAmount,
        'carrier_id' => $carrier->id,
        'zone_id' => $zone->id,
        'is_enabled' => true,
    ]);

    GetCountriesByZone::flush();
    Cache::forget("zone.country.{$country->id}");

    return compact('product', 'paymentMethod', 'shippingOption', 'country');
}

/**
 * @param  array<string, mixed>  $overrides
 * @return array<string, mixed>
 */
function shippingAddressPayload(array $overrides = []): array
{
    return [
        'first_name' => 'Olena',
        'last_name' => 'Koval',
        'street_address' => 'Khreshchatyk 1',
        'street_address_plus' => null,
        'postal_code' => '01001',
        'city' => 'Kyiv',
        'state' => null,
        'phone_number' => '0955807707',
        ...$overrides,
    ];
}

/**
 * @param  array{product: Product, paymentMethod: PaymentMethod, shippingOption: CarrierOption, country: Country}  $catalog
 */
function addProductToCart(array $catalog): void
{
    ZoneSessionManager::setSessionForCountryCode($catalog['country']->cca2);

    test()->post(route('shop.cart.add'), [
        'product_id' => $catalog['product']->id,
        'quantity' => 1,
    ])->assertRedirect();
}

/**
 * @param  array{product: Product, paymentMethod: PaymentMethod, shippingOption: CarrierOption, country: Country}  $catalog
 */
function completeDeliveryAndPayment(array $catalog): void
{
    test()->post(route('shop.checkout.shipping-option'), [
        'service_code' => $catalog['shippingOption']->public_id ?? $catalog['shippingOption']->id,
    ])->assertRedirect(route('shop.checkout.index'));

    test()->post(route('shop.checkout.prepare-payment'), [
        'payment_method_id' => $catalog['paymentMethod']->id,
    ])->assertRedirect(route('shop.checkout.index', ['step' => 3]));

    test()->post(route('shop.checkout.place-order'), [
        'payment_method_id' => $catalog['paymentMethod']->id,
    ])->assertSessionHasNoErrors();
}

test('guests can open checkout', function (): void {
    $catalog = createCheckoutCatalog($this->currency);
    addProductToCart($catalog);

    $this->get(route('shop.checkout.index'))
        ->assertOk()
        ->assertInertia(fn ($page) => $page
            ->component('shop/checkout')
            ->where('isGuest', true)
            ->where('checkoutEmailExists', false)
        );
});

test('authenticated customers can place a cash-on-delivery order', function (): void {
    $user = User::factory()->create();
    $catalog = createCheckoutCatalog($this->currency);

    $this->actingAs($user);
    addProductToCart($catalog);

    $this->get(route('shop.checkout.index'))
        ->assertOk()
        ->assertInertia(fn ($page) => $page->component('shop/checkout')->where('isGuest', false));

    $this->post(route('shop.checkout.shipping-address'), shippingAddressPayload())
        ->assertRedirect(route('shop.checkout.index'));

    completeDeliveryAndPayment($catalog);

    $order = Order::query()
        ->where('customer_id', $user->id)
        ->first();

    expect($order)->not->toBeNull()
        ->and($order->payment_method_id)->toBe($catalog['paymentMethod']->id)
        ->and($order->email)->toBe($user->email);

    $this->get(route('shop.checkout.success', $order))
        ->assertOk()
        ->assertInertia(fn ($page) => $page
            ->component('shop/checkout-success')
            ->where('order.id', $order->id)
        );

    expect(resolve(CartGateway::class)->current())->toBeNull();
});

test('guests can place an order without registering', function (): void {
    $catalog = createCheckoutCatalog($this->currency);
    addProductToCart($catalog);

    $this->post(route('shop.checkout.shipping-address'), shippingAddressPayload([
        'email' => 'guest@example.com',
    ]))->assertRedirect(route('shop.checkout.index'));

    completeDeliveryAndPayment($catalog);

    $order = Order::query()->where('email', 'guest@example.com')->first();

    expect($order)->not->toBeNull()
        ->and($order->customer_id)->toBeNull();

    $this->assertGuest();

    $this->get(route('shop.checkout.success', $order))
        ->assertOk()
        ->assertInertia(fn ($page) => $page->where('order.id', $order->id));
});

test('guests cannot view another guest order', function (): void {
    $catalog = createCheckoutCatalog($this->currency);
    addProductToCart($catalog);

    $this->post(route('shop.checkout.shipping-address'), shippingAddressPayload([
        'email' => 'guest@example.com',
    ]));

    completeDeliveryAndPayment($catalog);

    $order = Order::query()->where('email', 'guest@example.com')->firstOrFail();

    $this->flushSession();

    $this->get(route('shop.checkout.success', $order))->assertForbidden();
});

test('guests can create an account during checkout', function (): void {
    $catalog = createCheckoutCatalog($this->currency);
    addProductToCart($catalog);

    $this->post(route('shop.checkout.shipping-address'), shippingAddressPayload([
        'email' => 'new-customer@example.com',
        'create_account' => true,
        'password' => 'Secret-password-123',
        'password_confirmation' => 'Secret-password-123',
    ]))->assertSessionHasNoErrors()->assertRedirect(route('shop.checkout.index'));

    $user = User::query()->where('email', 'new-customer@example.com')->first();

    expect($user)->not->toBeNull()
        ->and($user->first_name)->toBe('Olena');

    $this->assertAuthenticatedAs($user);

    completeDeliveryAndPayment($catalog);

    expect(Order::query()->where('customer_id', $user->id)->exists())->toBeTrue();
});

test('guests are offered to log in when the email already belongs to an account', function (): void {
    $user = User::factory()->create(['email' => 'existing@example.com']);
    $catalog = createCheckoutCatalog($this->currency);
    addProductToCart($catalog);

    $payload = shippingAddressPayload(['email' => $user->email]);

    $this->from(route('shop.checkout.index'))
        ->post(route('shop.checkout.shipping-address'), $payload)
        ->assertRedirect(route('shop.checkout.index'))
        ->assertSessionHas('checkout_email_exists', true)
        ->assertSessionHas('url.intended', route('shop.checkout.index'))
        ->assertSessionHasInput('email', $user->email)
        ->assertSessionMissing('checkout.shipping_address');

    $this->get(route('shop.checkout.index'))
        ->assertInertia(fn ($page) => $page->where('checkoutEmailExists', true));

    $this->assertGuest();
});

test('guests with an existing email can continue as guest', function (): void {
    $user = User::factory()->create(['email' => 'existing@example.com']);
    $catalog = createCheckoutCatalog($this->currency);
    addProductToCart($catalog);

    $this->post(route('shop.checkout.shipping-address'), shippingAddressPayload([
        'email' => $user->email,
        'continue_as_guest' => true,
    ]))->assertRedirect(route('shop.checkout.index'));

    completeDeliveryAndPayment($catalog);

    $order = Order::query()->where('email', $user->email)->first();

    expect($order)->not->toBeNull()
        ->and($order->customer_id)->toBeNull();

    $this->assertGuest();
});

test('guests cannot register with an email that already belongs to an account', function (): void {
    $user = User::factory()->create(['email' => 'existing@example.com']);
    $catalog = createCheckoutCatalog($this->currency);
    addProductToCart($catalog);

    $this->from(route('shop.checkout.index'))
        ->post(route('shop.checkout.shipping-address'), shippingAddressPayload([
            'email' => $user->email,
            'create_account' => true,
            'continue_as_guest' => true,
            'password' => 'Secret-password-123',
            'password_confirmation' => 'Secret-password-123',
        ]))
        ->assertRedirect(route('shop.checkout.index'))
        ->assertSessionHas('checkout_email_exists', true);

    expect(User::query()->where('email', $user->email)->count())->toBe(1);

    $this->assertGuest();
});

test('placing an order after a catalog price increase sends the customer back to the cart', function (): void {
    $user = User::factory()->create();
    $catalog = createCheckoutCatalog($this->currency);

    $this->actingAs($user);
    addProductToCart($catalog);

    $this->post(route('shop.checkout.shipping-address'), shippingAddressPayload())
        ->assertRedirect(route('shop.checkout.index'));

    $this->post(route('shop.checkout.shipping-option'), [
        'service_code' => $catalog['shippingOption']->public_id ?? $catalog['shippingOption']->id,
    ])->assertRedirect(route('shop.checkout.index'));

    $this->post(route('shop.checkout.prepare-payment'), [
        'payment_method_id' => $catalog['paymentMethod']->id,
    ])->assertRedirect(route('shop.checkout.index', ['step' => 3]));

    Price::query()
        ->where('priceable_id', $catalog['product']->id)
        ->update(['amount' => 25000]);

    $this->from(route('shop.checkout.index'))
        ->post(route('shop.checkout.place-order'), [
            'payment_method_id' => $catalog['paymentMethod']->id,
        ])
        ->assertRedirect(route('shop.cart'))
        ->assertSessionHasErrors('cart');

    expect(Order::query()->count())->toBe(0)
        ->and(resolve(CartGateway::class)->current()?->lines->first()?->unit_price_amount)->toBe(25000);
});

test('a collected payment still completes when the catalog price has increased', function (): void {
    $user = User::factory()->create();
    $catalog = createCheckoutCatalog($this->currency);

    $this->actingAs($user);
    addProductToCart($catalog);

    $this->post(route('shop.checkout.shipping-address'), shippingAddressPayload())
        ->assertRedirect(route('shop.checkout.index'));

    $this->post(route('shop.checkout.shipping-option'), [
        'service_code' => $catalog['shippingOption']->public_id ?? $catalog['shippingOption']->id,
    ])->assertRedirect(route('shop.checkout.index'));

    $this->post(route('shop.checkout.prepare-payment'), [
        'payment_method_id' => $catalog['paymentMethod']->id,
    ])->assertRedirect(route('shop.checkout.index', ['step' => 3]));

    $paidAmount = resolve(CartGateway::class)->current()?->lines->first()?->unit_price_amount;

    Price::query()
        ->where('priceable_id', $catalog['product']->id)
        ->update(['amount' => 25000]);

    $order = resolve(CreateOrder::class)->handle(fn (): bool => true);

    expect($order->items->first()?->unit_price_amount)->toBe($paidAmount)
        ->and($paidAmount)->toBe(19900);
});

test('checkout total includes the selected delivery amount once', function (): void {
    $user = User::factory()->create();
    $catalog = createCheckoutCatalog($this->currency, productAmount: 45000, deliveryAmount: 10000);

    $this->actingAs($user);
    addProductToCart($catalog);

    $this->post(route('shop.checkout.shipping-address'), shippingAddressPayload())
        ->assertRedirect(route('shop.checkout.index'));

    $this->post(route('shop.checkout.shipping-option'), [
        'service_code' => $catalog['shippingOption']->public_id ?? $catalog['shippingOption']->id,
    ])->assertRedirect(route('shop.checkout.index'));

    $this->get(route('shop.checkout.index'))
        ->assertOk()
        ->assertInertia(fn ($page) => $page
            ->component('shop/checkout')
            ->where('cartContext.subtotal', 45000)
            ->where('cartContext.shippingTotal', 10000)
            ->where('cartContext.taxTotal', 0)
            ->where('cartContext.total', 55000)
        );
});
