<?php

declare(strict_types=1);

namespace App\Storefront\Checkout;

use Shopper\Core\Models\Order;

final class CheckoutOrderAccess
{
    public const string SESSION_KEY = 'guest_order_ids';

    public static function remember(Order $order): void
    {
        if (auth()->check()) {
            return;
        }

        session()->push(self::SESSION_KEY, $order->id);
    }

    public static function canView(Order $order): bool
    {
        if ($order->customer_id !== null) {
            return $order->customer_id === auth()->id();
        }

        return in_array($order->id, session()->get(self::SESSION_KEY, []), true);
    }
}
