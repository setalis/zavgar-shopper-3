<?php

declare(strict_types=1);

namespace App\Actions;

use App\CheckoutSession;
use App\DTO\CountryByZoneData;
use App\Storefront\Cart\CartGateway;
use Illuminate\Contracts\Cache\LockTimeoutException;
use Illuminate\Support\Facades\Cache;
use Shopper\Cart\Exceptions\PaymentSessionCollectedException;
use Shopper\Core\Exceptions\PaymentProviderUnavailableException;

final class ZoneSessionManager
{
    private const string KEY = 'zone_country_code';

    public static function checkSession(): bool
    {
        return session()->exists(self::KEY) && self::getSession() !== null;
    }

    public static function setSession(CountryByZoneData $zone): void
    {
        session()->put(self::KEY, $zone->countryCode);
    }

    public static function getSession(): ?CountryByZoneData
    {
        $countryCode = session()->get(self::KEY);

        if (! is_string($countryCode) || $countryCode === '') {
            return null;
        }

        return resolve(GetCountriesByZone::class)
            ->handle()
            ->firstWhere('countryCode', $countryCode);
    }

    public static function ensureDefaultSession(): ?CountryByZoneData
    {
        $current = self::getSession();

        if ($current !== null) {
            return $current;
        }

        $countries = resolve(GetCountriesByZone::class)->handle();

        if ($countries->count() !== 1) {
            return null;
        }

        /** @var CountryByZoneData $only */
        $only = $countries->first();

        try {
            return self::setSessionForCountryCode($only->countryCode);
        } catch (LockTimeoutException|PaymentProviderUnavailableException|PaymentSessionCollectedException) {
            return self::getSession();
        }
    }

    public static function setSessionForCountryCode(string $countryCode): ?CountryByZoneData
    {
        $zone = resolve(GetCountriesByZone::class)
            ->handle()
            ->firstWhere('countryCode', $countryCode);

        if (! $zone) {
            return null;
        }

        $current = self::getSession();

        if ($current && $current->countryId === $zone->countryId) {
            return $zone;
        }

        $oldCurrency = current_currency();
        $cart = resolve(CartGateway::class)->current();

        if ($cart) {
            resolve(CartGateway::class)->syncZone($cart, $zone->zoneId, $zone->currencyCode);
        }

        self::setSession($zone);

        session()->forget(CheckoutSession::KEY);

        Cache::forget("home_featured_products_{$oldCurrency}");
        Cache::forget("home_featured_products_{$zone->currencyCode}");

        return $zone;
    }
}
