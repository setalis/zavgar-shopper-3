<?php

declare(strict_types=1);

namespace App\Actions;

use App\Storefront\Checkout\PlaceOrder;
use Shopper\Core\Models\Order;

final readonly class CreateOrder
{
    public function __construct(
        private PlaceOrder $placeOrder,
    ) {}

    public function handle(): Order
    {
        return $this->placeOrder->handle();
    }
}
