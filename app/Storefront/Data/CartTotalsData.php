<?php

declare(strict_types=1);

namespace App\Storefront\Data;

use Illuminate\Contracts\Support\Arrayable;
use Shopper\Cart\Pipelines\CartPipelineContext;

/**
 * @implements Arrayable<string, mixed>
 */
final readonly class CartTotalsData implements Arrayable
{
    /**
     * @param  array<int, int>  $lineSubtotals
     */
    public function __construct(
        public int $subtotal,
        public int $discountTotal,
        public int $taxTotal,
        public int $shippingTotal,
        public int $total,
        public bool $taxInclusive,
        public array $lineSubtotals,
    ) {}

    public static function fromContext(CartPipelineContext $context): self
    {
        return new self(
            subtotal: $context->subtotal,
            discountTotal: $context->discountTotal,
            taxTotal: $context->taxTotal,
            shippingTotal: $context->shippingTotal,
            total: $context->total,
            taxInclusive: $context->taxInclusive,
            lineSubtotals: $context->lineSubtotals,
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'subtotal' => $this->subtotal,
            'discountTotal' => $this->discountTotal,
            'taxTotal' => $this->taxTotal,
            'shippingTotal' => $this->shippingTotal,
            'total' => $this->total,
            'taxInclusive' => $this->taxInclusive,
            'lineSubtotals' => $this->lineSubtotals,
        ];
    }
}
