<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Storefront\Shared\ShopProps;
use App\Support\StorefrontLocale;
use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * @var string
     */
    protected $rootView = 'app';

    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        return [
            ...parent::share($request),
            'name' => config('app.name'),
            'auth' => [
                'user' => $request->user()?->append('full_name'),
            ],
            'sidebarOpen' => ! $request->hasCookie('sidebar_state') || $request->cookie('sidebar_state') === 'true',
            'locale' => fn (): string => app()->getLocale(),
            'default_locale' => fn (): string => StorefrontLocale::default(),
            'locales' => fn (): array => config('app.available_locales', []),
            'locale_urls' => fn (): array => StorefrontLocale::switchUrls($request),
            'translations' => fn (): array => $this->frontendTranslations(),
            'shop' => fn (): array => resolve(ShopProps::class)->toArray(),
        ];
    }

    /**
     * @return array<string, string>
     */
    private function frontendTranslations(): array
    {
        $locale = app()->getLocale();
        $path = lang_path("frontend/{$locale}.json");

        if (! is_file($path)) {
            return [];
        }

        $contents = file_get_contents($path);

        if ($contents === false) {
            return [];
        }

        return json_decode($contents, true) ?? [];
    }
}
