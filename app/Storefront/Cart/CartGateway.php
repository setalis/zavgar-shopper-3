<?php

declare(strict_types=1);

namespace App\Storefront\Cart;

use App\Actions\ZoneSessionManager;
use App\Models\Channel;
use App\Storefront\Data\CartTotalsData;
use Shopper\Cart\CartManager;
use Shopper\Cart\CartSessionManager;
use Shopper\Cart\Models\Cart;
use Shopper\Cart\Models\CartLine;
use Shopper\Core\Contracts\Priceable;
use Shopper\Core\Enum\AddressType;

final readonly class CartGateway
{
    public function __construct(
        private CartManager $cartManager,
        private CartSessionManager $session,
    ) {}

    public function current(): ?Cart
    {
        return $this->session->current();
    }

    public function currentOrCreate(): Cart
    {
        $cart = $this->session->current();

        if ($cart instanceof Cart) {
            return $cart;
        }

        $zone = ZoneSessionManager::getSession();
        $defaultChannel = Channel::query()->scopes('default')->first();

        return $this->session->create([
            'currency_code' => current_currency(),
            'channel_id' => $defaultChannel?->id,
            'zone_id' => $zone?->zoneId,
            'customer_id' => auth()->id(),
        ]);
    }

    public function forget(): void
    {
        $this->session->forget();
    }

    public function add(Priceable $purchasable, int $quantity = 1): CartLine
    {
        return $this->cartManager->add($this->currentOrCreate(), $purchasable, $quantity);
    }

    /**
     * @param  array{quantity?: int, metadata?: array<string, mixed>|null}  $data
     */
    public function update(Cart $cart, int $lineId, array $data): CartLine
    {
        return $this->cartManager->update($cart, $lineId, $data);
    }

    public function remove(Cart $cart, int $lineId): void
    {
        $this->cartManager->remove($cart, $lineId);
    }

    public function clear(Cart $cart): void
    {
        $this->cartManager->clear($cart);
    }

    public function totals(Cart $cart): CartTotalsData
    {
        return CartTotalsData::fromContext($this->cartManager->calculate($cart));
    }

    /**
     * @param  array<string, mixed>  $data
     */
    public function addAddress(Cart $cart, AddressType $type, array $data): void
    {
        $this->cartManager->addAddress($cart, $type, $data);
    }

    public function setShippingMethod(Cart $cart, string $optionId, int $amount): void
    {
        $this->cartManager->setShippingMethod($cart, $optionId, $amount);
    }

    public function setPaymentMethod(Cart $cart, int $paymentMethodId): void
    {
        $this->cartManager->setPaymentMethod($cart, $paymentMethodId);
    }

    /**
     * @param  array<string, mixed>|null  $session
     */
    public function setPaymentSession(Cart $cart, ?array $session): bool
    {
        return $this->cartManager->setPaymentSession($cart, $session);
    }

    public function releasePaymentSession(Cart $cart): void
    {
        $this->cartManager->releasePaymentSession($cart);
    }

    public function reprice(Cart $cart): void
    {
        $this->cartManager->reprice($cart);
    }

    public function syncZone(Cart $cart, int $zoneId, string $currencyCode): void
    {
        $this->cartManager->changeContext($cart, $zoneId, $cart->channel_id);

        if ($cart->currency_code !== $currencyCode) {
            $this->cartManager->changeCurrency($cart, $currencyCode);
        }
    }
}
