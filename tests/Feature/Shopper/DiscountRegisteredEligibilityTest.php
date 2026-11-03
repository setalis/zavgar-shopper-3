<?php

declare(strict_types=1);

use App\Models\User;
use App\Storefront\Discounts\RegisteredCustomersEligibilityRule;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Shopper\Cart\Discounts\DiscountEligibilityManager;
use Shopper\Cart\Discounts\DiscountValidator;
use Shopper\Cart\Discounts\SyncDiscountEligibilityAction;
use Shopper\Cart\Models\Cart;
use Shopper\Cart\Pipelines\CartPipelineContext;
use Shopper\Core\Enum\DiscountCondition;
use Shopper\Core\Enum\DiscountEligibility;
use Shopper\Core\Enum\DiscountRequirement;
use Shopper\Core\Enum\DiscountType;
use Shopper\Core\Models\Discount;

uses(RefreshDatabase::class);

function registeredOnlyDiscount(): Discount
{
    return Discount::factory()->create([
        'is_active' => true,
        'type' => DiscountType::Percentage,
        'value' => 10,
        'min_required' => DiscountRequirement::None,
        'eligibility' => RegisteredCustomersEligibilityRule::KEY,
        'start_at' => now()->subDay(),
    ]);
}

test('registered customers option is listed right after everyone', function (): void {
    expect(array_keys(resolve(DiscountEligibilityManager::class)->options()))->toBe([
        DiscountEligibility::Everyone->value,
        RegisteredCustomersEligibilityRule::KEY,
        DiscountEligibility::Customers->value,
    ]);
});

test('registered customers discount is rejected for a guest cart', function (): void {
    $cart = Cart::factory()->create(['customer_id' => null]);

    $result = resolve(DiscountValidator::class)->validateTerms(registeredOnlyDiscount(), new CartPipelineContext($cart));

    expect($result->valid)->toBeFalse()
        ->and($result->failureReason)->toBe(__('shopper-cart::messages.discount.requires_login'));
});

test('registered customers discount is accepted for a cart with a customer', function (): void {
    $cart = Cart::factory()->create(['customer_id' => User::factory()->create()->id]);

    $result = resolve(DiscountValidator::class)->validateTerms(registeredOnlyDiscount(), new CartPipelineContext($cart));

    expect($result->valid)->toBeTrue();
});

test('switching from specific customers to registered customers clears selected customers', function (): void {
    $discount = Discount::factory()->create(['eligibility' => DiscountEligibility::Customers]);
    $sync = resolve(SyncDiscountEligibilityAction::class);
    $sync->execute($discount, DiscountEligibility::Customers->value, [User::factory()->create()->id]);

    expect($discount->items()->where('condition', DiscountCondition::Eligibility)->count())->toBe(1);

    $sync->execute($discount, RegisteredCustomersEligibilityRule::KEY, []);

    expect($discount->items()->where('condition', DiscountCondition::Eligibility)->count())->toBe(0);
});
