<?php

declare(strict_types=1);

namespace App\Providers;

use App\Import\Sources\NormalizedCsvSource;
use App\Import\Sources\XlsxSource;
use App\Listeners\DrainQueueAfterResponse;
use App\Listeners\MergeGuestWishlist;
use App\Listeners\NotifyQueuedProductImports;
use App\Livewire\Shopper\Pages\Product\Attributes as ProductAttributes;
use App\Livewire\Shopper\SlideOvers\AddVariant;
use App\Livewire\Shopper\SlideOvers\ChooseProductAttributes;
use App\Livewire\Shopper\SlideOvers\GenerateVariants;
use App\Livewire\Shopper\SlideOvers\ImportXlsx;
use App\Livewire\Shopper\SlideOvers\UpdateVariant;
use App\Sidebar\HomepageBannersSidebar;
use App\Sidebar\ProductImportSidebar;
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
use Shopper\Core\Events\Products\ProductImportCompleted;
use Shopper\Core\Import\ImportManager;
use Shopper\Sidebar\SidebarBuilder;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // Shopper binds its product edit routes to this config value, so it must be replaced before routes load.
        config(['shopper.components.product.pages.product-attributes' => ProductAttributes::class]);
    }

    public function boot(): void
    {
        $this->registerProductVariantOptions();
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

        $this->app['events']->listen(ProductImportCompleted::class, NotifyQueuedProductImports::class);
    }

    protected function registerProductVariantOptions(): void
    {
        Livewire::component('shopper-product-attributes', ProductAttributes::class);
        Livewire::component('shopper-slide-overs.add-variant', AddVariant::class);
        Livewire::component('shopper-slide-overs.update-variant', UpdateVariant::class);
        Livewire::component('shopper-slide-overs.generate-variants', GenerateVariants::class);
        Livewire::component('shopper-slide-overs.choose-product-attributes', ChooseProductAttributes::class);
    }

    protected function registerShopperSidebar(): void
    {
        $this->app['events']->listen(SidebarBuilder::class, HomepageBannersSidebar::class);
        $this->app['events']->listen(SidebarBuilder::class, ProductImportSidebar::class);
    }

    protected function configureDefaults(): void
    {
        // Shopper core calls setlocale(LC_ALL, 'uk'), which Windows resolves to "English_United Kingdom.1252".
        // A single-byte ctype treats UTF-8 bytes like 0xA0 as whitespace and corrupts Cyrillic strings.
        setlocale(LC_CTYPE, 'C');

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
