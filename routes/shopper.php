<?php

declare(strict_types=1);

use App\Http\Controllers\Shopper\DownloadProductImportXlsxTemplateController;
use App\Http\Controllers\Shopper\ExportProductsXlsxController;
use App\Livewire\Shopper\Pages\HomepageBanners\Edit as HomepageBannerEdit;
use App\Livewire\Shopper\Pages\HomepageBanners\Index as HomepageBannersIndex;
use App\Livewire\Shopper\Pages\MenuItems\Edit as MenuItemEdit;
use App\Livewire\Shopper\Pages\MenuItems\Index as MenuItemsIndex;
use App\Livewire\Shopper\Pages\News\Edit as NewsArticleEdit;
use App\Livewire\Shopper\Pages\News\Index as NewsArticlesIndex;
use Illuminate\Support\Facades\Route;

Route::get('/products/import-template.xlsx', DownloadProductImportXlsxTemplateController::class)
    ->name('products.import-xlsx-template');
Route::get('/products/export.xlsx', ExportProductsXlsxController::class)
    ->name('products.export-xlsx');

Route::get('/banners', HomepageBannersIndex::class)
    ->name('banners.index');
Route::get('/banners/create', HomepageBannerEdit::class)
    ->name('banners.create');
Route::get('/banners/{banner}/edit', HomepageBannerEdit::class)
    ->name('banners.edit');

Route::get('/promo-banners', HomepageBannersIndex::class)
    ->name('promo-banners.index');
Route::get('/promo-banners/create', HomepageBannerEdit::class)
    ->name('promo-banners.create');
Route::get('/promo-banners/{banner}/edit', HomepageBannerEdit::class)
    ->name('promo-banners.edit');

Route::get('/menu', MenuItemsIndex::class)
    ->name('menu.index');
Route::get('/menu/create', MenuItemEdit::class)
    ->name('menu.create');
Route::get('/menu/{menuItem}/edit', MenuItemEdit::class)
    ->name('menu.edit');

Route::get('/news', NewsArticlesIndex::class)
    ->name('news.index');
Route::get('/news/create', NewsArticleEdit::class)
    ->name('news.create');
Route::get('/news/{article}/edit', NewsArticleEdit::class)
    ->name('news.edit');
