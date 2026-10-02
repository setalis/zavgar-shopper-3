<?php

declare(strict_types=1);

namespace App\Storefront\Checkout;

use App\CheckoutSession;
use App\Storefront\Cart\CartGateway;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Shopper\Cart\Actions\CreateOrderFromCartAction;
use Shopper\Core\Models\Order;

final readonly class PlaceOrder
{
    public function __construct(
        private CartGateway $cart,
        private CreateOrderFromCartAction $createOrderFromCart,
    ) {}

    public function handle(): Order
    {
        $checkout = session()->get(CheckoutSession::KEY);

        abort_unless(
            $checkout
            && data_get($checkout, 'shipping_option')
            && data_get($checkout, 'payment'),
            422,
            __('backend.order.session_incomplete'),
        );

        $cart = $this->cart->currentOrCreate();

        abort_if(
            $cart->customer_id !== null && $cart->customer_id !== Auth::id(),
            403,
        );

        if (Auth::check() && $cart->customer_id === null) {
            $cart->update(['customer_id' => Auth::id()]);
        }

        if (Auth::check() && blank($cart->email)) {
            $cart->update(['email' => Auth::user()?->email]);
        }

        if (! Auth::check()) {
            $guestEmail = data_get($checkout, 'email');

            abort_if(blank($guestEmail), 422, __('backend.order.session_incomplete'));

            $cart->update(['email' => $guestEmail]);
        }

        $paymentMethodId = data_get($checkout, 'payment.0.id');

        if (filled($paymentMethodId)) {
            $this->cart->setPaymentMethod($cart, (int) $paymentMethodId);
        }

        $lock = Cache::lock('checkout.create-order.'.$cart->id, 10);

        abort_unless($lock->get(), 409, __('backend.order.checkout_in_progress'));

        try {
            $order = DB::transaction(fn (): Order => $this->createOrderFromCart->execute($cart));

            CheckoutOrderAccess::remember($order);

            return $order;
        } finally {
            $lock->release();
        }
    }
}
