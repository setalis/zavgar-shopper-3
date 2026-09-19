<?php

declare(strict_types=1);

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Http\Requests\Shop\IndexNewsRequest;
use App\Models\NewsArticle;
use Inertia\Inertia;
use Inertia\Response;

final class NewsController extends Controller
{
    public function index(IndexNewsRequest $request): Response
    {
        $listing = NewsArticle::query()
            ->scopes('published')
            ->with('media')
            ->withStorefrontTranslations();

        $listing = $request->apply($listing)->orderByDesc('published_at');

        return Inertia::render('shop/news', [
            'articles' => localize_storefront($listing->paginate(12)->withQueryString()),
            'filters' => [
                'q' => $request->search(),
            ],
        ]);
    }

    public function show(NewsArticle $article): Response
    {
        abort_unless($article->isPublished(), 404);

        $article->load(['media', 'translations']);
        $article->localizeForStorefront();

        if (filled($article->description)) {
            $article->setAttribute(
                'description',
                str($article->description)->sanitizeHtml()->toString(),
            );
        }

        $latest = NewsArticle::query()
            ->scopes('published')
            ->where('id', '!=', $article->id)
            ->with('media')
            ->withStorefrontTranslations()
            ->orderByDesc('published_at')
            ->limit(5)
            ->get();

        return Inertia::render('shop/news-article', [
            'article' => $article,
            'latest' => localize_storefront($latest),
            'hreflang' => storefront_hreflang('shop.news.show', ['article' => $article]),
        ]);
    }
}
