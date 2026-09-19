<?php

declare(strict_types=1);

use App\Models\CatalogTranslation;
use App\Models\NewsArticle;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Shopper\Core\Models\Currency;
use Shopper\Core\Models\Setting;

uses(RefreshDatabase::class);

beforeEach(function (): void {
    $currency = Currency::query()->create([
        'name' => 'US Dollar',
        'code' => 'USD',
        'symbol' => '$',
        'format' => '$1,234.56',
    ]);

    Setting::query()->create([
        'key' => 'default_currency_id',
        'display_name' => 'Currency',
        'value' => $currency->id,
        'locked' => true,
    ]);

    Cache::forget('shopper-setting.default_currency_id');
    Cache::forget('shopper-setting.default_currency');
});

test('news index lists published articles and hides drafts', function (): void {
    $published = NewsArticle::factory()->published()->create([
        'title' => 'Published story',
        'slug' => 'published-story',
    ]);

    NewsArticle::factory()->draft()->create([
        'title' => 'Draft story',
        'slug' => 'draft-story',
    ]);

    NewsArticle::factory()->scheduled()->create([
        'title' => 'Future story',
        'slug' => 'future-story',
    ]);

    $this->get(route('shop.news'))
        ->assertOk()
        ->assertInertia(fn ($page) => $page
            ->component('shop/news')
            ->has('articles.data', 1)
            ->where('articles.data.0.id', $published->id)
            ->where('articles.data.0.title', 'Published story')
            ->where('filters.q', '')
        );
});

test('news index can search by title', function (): void {
    NewsArticle::factory()->published()->create([
        'title' => 'Warehouse opening',
        'slug' => 'warehouse-opening',
    ]);

    NewsArticle::factory()->published()->create([
        'title' => 'New filters',
        'slug' => 'new-filters',
    ]);

    $this->get(route('shop.news', ['q' => 'warehouse']))
        ->assertOk()
        ->assertInertia(fn ($page) => $page
            ->component('shop/news')
            ->has('articles.data', 1)
            ->where('articles.data.0.slug', 'warehouse-opening')
            ->where('filters.q', 'warehouse')
        );
});

test('news article page renders a published article', function (): void {
    $article = NewsArticle::factory()->published()->create([
        'title' => 'Field notes',
        'slug' => 'field-notes',
        'summary' => 'A short lead',
        'description' => '<p>Hello <strong>world</strong></p>',
    ]);

    $this->get(route('shop.news.show', $article))
        ->assertOk()
        ->assertInertia(fn ($page) => $page
            ->component('shop/news-article')
            ->where('article.id', $article->id)
            ->where('article.slug', 'field-notes')
            ->where('article.title', 'Field notes')
            ->where('article.summary', 'A short lead')
            ->where('article.description', '<p>Hello <strong>world</strong></p>')
            ->has('hreflang')
            ->has('latest', 0)
        );
});

test('draft news articles are not found', function (): void {
    $article = NewsArticle::factory()->draft()->create([
        'slug' => 'hidden-draft',
    ]);

    $this->get(route('shop.news.show', $article))->assertNotFound();
});

test('scheduled news articles are not found', function (): void {
    $article = NewsArticle::factory()->scheduled()->create([
        'slug' => 'coming-soon',
    ]);

    $this->get(route('shop.news.show', $article))->assertNotFound();
});

test('english news article overlays translated fields and hreflang', function (): void {
    $article = NewsArticle::factory()->published()->create([
        'title' => 'Літній розпродаж',
        'slug' => 'litnii-rozprodazh',
        'summary' => 'Короткий опис',
        'description' => '<p>Опис українською</p>',
    ]);

    CatalogTranslation::syncFor($article, 'en', [
        'name' => 'Summer sale',
        'summary' => 'Short summary',
        'description' => '<p>English body</p>',
    ]);

    $this->get(route('shop.news.show', $article))
        ->assertOk()
        ->assertInertia(fn ($page) => $page
            ->where('locale', 'uk')
            ->where('article.title', 'Літній розпродаж')
            ->where('article.summary', 'Короткий опис')
        );

    $this->get('/en/news/litnii-rozprodazh')
        ->assertOk()
        ->assertInertia(fn ($page) => $page
            ->component('shop/news-article')
            ->where('locale', 'en')
            ->where('article.title', 'Summer sale')
            ->where('article.summary', 'Short summary')
            ->where('article.description', '<p>English body</p>')
            ->has('hreflang')
            ->where('locale_urls.uk', '/news/litnii-rozprodazh')
            ->where('locale_urls.en', '/en/news/litnii-rozprodazh')
        );
});

test('news article page lists other published articles as latest news', function (): void {
    $current = NewsArticle::factory()->published()->create([
        'title' => 'Current story',
        'slug' => 'current-story',
        'published_at' => now()->subHour(),
    ]);

    $newest = NewsArticle::factory()->published()->create([
        'title' => 'Newest story',
        'slug' => 'newest-story',
        'published_at' => now()->subMinutes(10),
    ]);

    $older = NewsArticle::factory()->published()->create([
        'title' => 'Older story',
        'slug' => 'older-story',
        'published_at' => now()->subDays(2),
    ]);

    NewsArticle::factory()->draft()->create([
        'title' => 'Draft story',
        'slug' => 'draft-story',
    ]);

    $this->get(route('shop.news.show', $current))
        ->assertOk()
        ->assertInertia(fn ($page) => $page
            ->component('shop/news-article')
            ->has('latest', 2)
            ->where('latest.0.id', $newest->id)
            ->where('latest.1.id', $older->id)
        );
});

test('news article latest list is capped at five items and excludes the current article', function (): void {
    $current = NewsArticle::factory()->published()->create([
        'title' => 'Current story',
        'slug' => 'current-story',
        'published_at' => now(),
    ]);

    foreach (range(1, 6) as $index) {
        NewsArticle::factory()->published()->create([
            'title' => "Story {$index}",
            'slug' => "story-{$index}",
            'published_at' => now()->subDays($index),
        ]);
    }

    $this->get(route('shop.news.show', $current))
        ->assertOk()
        ->assertInertia(fn ($page) => $page
            ->has('latest', 5)
            ->where('latest.0.slug', 'story-1')
            ->where('latest.4.slug', 'story-5')
        );
});
