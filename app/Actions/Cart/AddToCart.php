<?php

declare(strict_types=1);

namespace App\Actions\Cart;

use App\Models\Product;
use App\Models\ProductVariant;
use App\Storefront\Cart\CartGateway;
use Shopper\Cart\Models\CartLine;

final readonly class AddToCart
{
    public function __construct(
        private CartGateway $cart,
    ) {}

    public function handle(Product $product, ?ProductVariant $variant = null, int $quantity = 1): CartLine
    {
        return $this->cart->add($variant ?? $product, $quantity);
    }
}
