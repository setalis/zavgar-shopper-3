<?php

declare(strict_types=1);

namespace App\Providers;

use App\Listeners\DrainQueueAfterResponse;
use App\Listeners\MergeGuestWishlist;
use App\Sidebar\HomepageBannersSidebar;
use App\Support\StorefrontLocale;
use Carbon\CarbonImmutable;
use Illuminate\Auth\Events\Login;
use Illuminate\Queue\Events\JobQueued;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;
use Shopper\Sidebar\SidebarBuilder;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        $this->registerShopperSidebar();
        $this->configureDefaults();
        StorefrontLocale::applyUrlDefaults();
        URL::formatPathUsing(
            fn (string $path, mixed $route = null): string => StorefrontLocale::prefixPath($path, $route),
        );
        $this->app['events']->listen(Login::class, MergeGuestWishlist::class);
        $this->app['events']->listen(JobQueued::class, DrainQueueAfterResponse::class);
    }

    protected function registerShopperSidebar(): void
    {
        $this->app['events']->listen(SidebarBuilder::class, HomepageBannersSidebar::class);
    }

    protected function configureDefaults(): void
    {
        Date::use(CarbonImmutable::class);

        DB::prohibitDestructiveCommands(
            app()->isProduction(),
        );

        Password::defaults(
            fn (): ?Password => app()->isProduction()
            ? Password::min(12)
                ->mixedCase()
                ->letters()
                ->numbers()
                ->symbols()
                ->uncompromised()
            : null,
        );
    }
}
