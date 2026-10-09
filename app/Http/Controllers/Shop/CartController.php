<?php

declare(strict_types=1);

namespace App\Http\Controllers\Shop;

use App\Actions\Cart\AddToCart;
use App\Actions\LocalizeCatalog;
use App\CheckoutSession;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Storefront\Cart\CartGateway;
use Illuminate\Contracts\Cache\LockTimeoutException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Shopper\Cart\Exceptions\InsufficientStockException;
use Shopper\Cart\Exceptions\MissingPriceException;
use Shopper\Cart\Exceptions\PaymentSessionCollectedException;
use Shopper\Cart\Exceptions\QuantityRuleViolationException;
use Shopper\Core\Exceptions\PaymentProviderUnavailableException;

final class CartController extends Controller
{
    public function __construct(
        private CartGateway $cart,
    ) {}

    public function index(LocalizeCatalog $localizeCatalog): Response
    {
        $cart = $this->cart->current();

        $cart?->load(['lines.purchasable.media']);

        $localizeCatalog->cart($cart);

        return Inertia::render('shop/cart', [
            'cart' => $cart,
            'cartContext' => $cart ? $this->cart->totals($cart) : null,
        ]);
    }

    public function add(Request $request, AddToCart $addToCart): RedirectResponse
    {
        $data = $request->validate([
            'product_id' => ['required', 'integer', 'exists:'.shopper_table('products').',id'],
            'variant_id' => ['nullable', 'integer', 'exists:'.shopper_table('product_variants').',id'],
            'quantity' => ['nullable', 'integer', 'min:1', 'max:10'],
        ]);

        $product = Product::query()->scopes('publish')->findOrFail($data['product_id']);
        $variant = isset($data['variant_id'])
            ? ProductVariant::query()->where('product_id', $product->id)->findOrFail($data['variant_id'])
            : null;

        $error = $this->mutateCart(fn () => $addToCart->handle($product, $variant, $data['quantity'] ?? 1));

        if ($error) {
            return $error;
        }

        $this->invalidateCheckoutSession();

        Inertia::flash('toast', ['type' => 'success', 'message' => __('backend.cart.added')]);

        return back();
    }

    public function update(Request $request, int $line): RedirectResponse
    {
        $data = $request->validate([
            'quantity' => ['required', 'integer', 'min:1', 'max:10'],
        ]);

        $cart = $this->cart->current();

        if (! $cart) {
            return back();
        }

        $error = $this->mutateCart(fn () => $this->cart->update($cart, $line, ['quantity' => $data['quantity']]));

        if ($error) {
            return $error;
        }

        $this->invalidateCheckoutSession();

        return back();
    }

    public function destroy(int $line): RedirectResponse
    {
        $cart = $this->cart->current();

        if (! $cart) {
            return back();
        }

        $error = $this->mutateCart(fn () => $this->cart->remove($cart, $line));

        if ($error) {
            return $error;
        }

        $this->invalidateCheckoutSession();

        return back();
    }

    public function clear(): RedirectResponse
    {
        $cart = $this->cart->current();

        if (! $cart) {
            return back();
        }

        $error = $this->mutateCart(fn () => $this->cart->clear($cart));

        if ($error) {
            return $error;
        }

        $this->invalidateCheckoutSession();

        return back();
    }

    /**
     * @param  callable(): mixed  $mutation
     */
    private function mutateCart(callable $mutation): ?RedirectResponse
    {
        try {
            $mutation();
        } catch (InsufficientStockException) {
            return back()->withErrors(['cart' => __('backend.cart.insufficient_stock')]);
        } catch (MissingPriceException) {
            return back()->withErrors(['cart' => __('backend.cart.price_missing')]);
        } catch (LockTimeoutException) {
            return back()->withErrors(['cart' => __('backend.order.checkout_in_progress')]);
        } catch (PaymentProviderUnavailableException|PaymentSessionCollectedException|QuantityRuleViolationException $exception) {
            return back()->withErrors(['cart' => $exception->getMessage()]);
        }

        return null;
    }

    private function invalidateCheckoutSession(): void
    {
        session()->forget([
            CheckoutSession::KEY,
            'stripe_payment',
            'stripe_intent_id',
            'stripe_order_number',
            'checkout_cart_id',
        ]);
    }
}
