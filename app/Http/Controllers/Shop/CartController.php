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
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Shopper\Cart\Exceptions\InsufficientStockException;
use Shopper\Cart\Exceptions\MissingPriceException;

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

        try {
            $addToCart->handle($product, $variant, $data['quantity'] ?? 1);
        } catch (InsufficientStockException) {
            return back()->withErrors(['cart' => __('backend.cart.insufficient_stock')]);
        } catch (MissingPriceException) {
            return back()->withErrors(['cart' => __('backend.cart.price_missing')]);
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

        try {
            $this->cart->update($cart, $line, ['quantity' => $data['quantity']]);
        } catch (InsufficientStockException) {
            return back()->withErrors(['cart' => __('backend.cart.insufficient_stock')]);
        } catch (MissingPriceException) {
            return back()->withErrors(['cart' => __('backend.cart.price_missing')]);
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

        $this->cart->remove($cart, $line);

        $this->invalidateCheckoutSession();

        return back();
    }

    public function clear(): RedirectResponse
    {
        $cart = $this->cart->current();

        if (! $cart) {
            return back();
        }

        $this->cart->clear($cart);

        $this->invalidateCheckoutSession();

        return back();
    }

    private function invalidateCheckoutSession(): void
    {
        session()->forget([
            CheckoutSession::KEY,
            'stripe_payment',
            'stripe_order_number',
        ]);
    }
}
