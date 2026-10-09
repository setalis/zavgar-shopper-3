<?php

declare(strict_types=1);

namespace App\Actions;

use App\Storefront\Checkout\PlaceOrder;
use Closure;
use Shopper\Core\Models\Order;

final readonly class CreateOrder
{
    public function __construct(
        private PlaceOrder $placeOrder,
    ) {}

    /**
     * @param  (Closure(): bool)|null  $honoursPayment
     */
    public function handle(?Closure $honoursPayment = null): Order
    {
        return $this->placeOrder->handle($honoursPayment);
    }
}
