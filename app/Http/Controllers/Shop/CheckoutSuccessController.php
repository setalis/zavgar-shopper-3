<?php

declare(strict_types=1);

namespace App\Http\Controllers\Shop;

use App\CheckoutSession;
use App\Http\Controllers\Controller;
use App\Storefront\Cart\CartGateway;
use Inertia\Inertia;
use Inertia\Response;
use Shopper\Core\Models\Order;

final class CheckoutSuccessController extends Controller
{
    public function __invoke(Order $order, CartGateway $cart): Response
    {
        abort_unless($order->customer_id === auth()->id(), 403);

        session()->forget(['stripe_payment', 'stripe_order_number', 'checkout_cart_id', CheckoutSession::KEY]);
        $cart->forget();

        return Inertia::render('shop/checkout-success', [
            'order' => $order,
        ]);
    }
}
