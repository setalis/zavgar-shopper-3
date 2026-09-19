<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Support\StorefrontLocale;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

final class SetApplicationLocale
{
    public function handle(Request $request, Closure $next): Response
    {
        $available = StorefrontLocale::available();
        $default = StorefrontLocale::default();
        $fromPrefix = $request->attributes->get('storefront_locale');

        $locale = $default;

        if (is_string($fromPrefix) && in_array($fromPrefix, $available, true)) {
            $locale = $fromPrefix;
        } elseif (! StorefrontLocale::isStorefrontRequest($request)) {
            $adminLocales = array_keys(config('shopper.admin.locales', []));
            $adminLocale = session('shopper_locale');

            if (is_string($adminLocale) && in_array($adminLocale, $adminLocales, true)) {
                app()->setLocale($adminLocale);
                StorefrontLocale::applyUrlDefaults($default);

                return $next($request);
            }

            $sessionLocale = session('locale', $default);

            if (is_string($sessionLocale) && in_array($sessionLocale, $available, true)) {
                $locale = $sessionLocale;
            }
        }

        if (in_array($locale, $available, true)) {
            app()->setLocale($locale);
            session(['locale' => $locale, 'shopper_locale' => $locale]);
        }

        StorefrontLocale::applyUrlDefaults($locale);

        return $next($request);
    }
}
