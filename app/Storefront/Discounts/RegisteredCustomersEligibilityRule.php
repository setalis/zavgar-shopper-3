<?php

declare(strict_types=1);

namespace App\Storefront\Discounts;

use Shopper\Cart\Contracts\DiscountEligibilityRule;
use Shopper\Cart\Discounts\DiscountValidationResult;
use Shopper\Cart\Pipelines\CartPipelineContext;
use Shopper\Core\Models\Discount;

final class RegisteredCustomersEligibilityRule implements DiscountEligibilityRule
{
    public const string KEY = 'registered';

    public function key(): string
    {
        return self::KEY;
    }

    public function label(): string
    {
        return __('shopper-core::enum/discount.eligibility.registered_customers');
    }

    public function description(): string
    {
        return __('shopper-core::enum/discount.eligibility.registered_customers_description');
    }

    public function discountableType(): ?string
    {
        return null;
    }

    public function passes(Discount $discount, CartPipelineContext $context): DiscountValidationResult
    {
        if (! $context->cart->customer_id) {
            return new DiscountValidationResult(false, __('shopper-cart::messages.discount.requires_login'));
        }

        return new DiscountValidationResult(true);
    }
}
