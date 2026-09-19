<?php

declare(strict_types=1);

namespace App\Providers;

use App\Import\Sources\NormalizedCsvSource;
use App\Import\Sources\XlsxSource;
use App\Listeners\DrainQueueAfterResponse;
use App\Listeners\MergeGuestWishlist;
use App\Livewire\Shopper\SlideOvers\ImportXlsx;
use App\Sidebar\HomepageBannersSidebar;
use App\Support\StorefrontLocale;
use Carbon\CarbonImmutable;
use Illuminate\Auth\Events\Login;
use Illuminate\Contracts\Container\Container;
use Illuminate\Queue\Events\JobQueued;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;
use Livewire\Livewire;
use Shopper\Core\Import\ImportManager;
use Shopper\Sidebar\SidebarBuilder;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        $this->registerProductExcelImport();
        $this->registerShopperSidebar();
        $this->configureDefaults();
        StorefrontLocale::applyUrlDefaults();
        URL::formatPathUsing(
            fn (string $path, mixed $route = null): string => StorefrontLocale::prefixPath($path, $route),
        );
        $this->app['events']->listen(Login::class, MergeGuestWishlist::class);
        $this->app['events']->listen(JobQueued::class, DrainQueueAfterResponse::class);
    }

    protected function registerProductExcelImport(): void
    {
        $manager = $this->app->make(ImportManager::class);
        $manager->extend(
            'csv',
            fn (Container $app): NormalizedCsvSource => $app->make(NormalizedCsvSource::class),
        );
        $manager->extend(
            'xlsx',
            fn (Container $app): XlsxSource => $app->make(XlsxSource::class),
        );

        Livewire::component('shopper-slide-overs.import-xlsx', ImportXlsx::class);
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
