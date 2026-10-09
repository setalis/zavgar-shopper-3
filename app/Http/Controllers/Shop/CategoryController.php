<?php

declare(strict_types=1);

namespace App\Http\Controllers\Shop;

use App\Actions\Product\ApplyCategoryFilters;
use App\Actions\Product\BuildCategoryFilters;
use App\Actions\Product\FilterByStorefrontPrice;
use App\Http\Controllers\Controller;
use App\Http\Requests\Shop\ShowCategoryRequest;
use App\Models\Category;
use App\Models\Product;
use Inertia\Inertia;
use Inertia\Response;

final class CategoryController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('shop/categories', [
            'categories' => localize_storefront(Category::hydrateBranchProductsCount(
                Category::query()
                    ->scopes('enabled')
                    ->whereNull('parent_id')
                    ->withStorefrontTranslations()
                    ->with('media')
                    ->orderBy('position')
                    ->get(),
            )),
        ]);
    }

    public function show(
        ShowCategoryRequest $request,
        Category $category,
        BuildCategoryFilters $buildCategoryFilters,
        ApplyCategoryFilters $applyCategoryFilters,
        FilterByStorefrontPrice $filterByStorefrontPrice,
    ): Response {
        $sort = $request->sort();
        $selectedAttrs = $request->selectedAttrs();
        $price = $request->priceRange();
        $filterGroups = $buildCategoryFilters->handle($category);
        $attributeFilters = $buildCategoryFilters->flatten($filterGroups);
        $includePrice = $buildCategoryFilters->includesPrice($filterGroups);
        $categoryIds = $buildCategoryFilters->categoryIds($category);

        $query = Product::query()
            ->scopes('publish')
            ->whereHas('categories', fn ($q) => $q->whereIn('id', $categoryIds));

        $query = $applyCategoryFilters->handle($query, $selectedAttrs, $attributeFilters);

        $priceRange = $includePrice ? $filterByStorefrontPrice->bounds($query) : null;
        $query = $includePrice
            ? $filterByStorefrontPrice->apply($query, $price['min'], $price['max'])
            : $query;

        $query = $query
            ->with(['media', 'brand.media'])
            ->withStorefrontTranslations()
            ->withCurrentPrices()
            ->withCurrentStock()
            ->withApprovedReviewSummary();

        $query = match ($sort) {
            'name' => $query->orderByLocalizedName(),
            default => $query->latest(),
        };

        $category->load(['media', 'translations']);
        $category->localizeForStorefront();

        return Inertia::render('shop/category', [
            'category' => $category,
            'children' => localize_storefront(Category::hydrateBranchProductsCount(
                $category->children()
                    ->scopes('enabled')
                    ->withStorefrontTranslations()
                    ->with('media')
                    ->orderBy('position')
                    ->get(),
            )),
            'products' => localize_storefront($query->paginate(12)->withQueryString()),
            'filterGroups' => $filterGroups,
            'attributeFilters' => $attributeFilters,
            'priceRange' => $priceRange,
            'filters' => [
                'sort' => $sort,
                'attrs' => (object) $selectedAttrs,
                'price_min' => $includePrice ? $price['min'] : null,
                'price_max' => $includePrice ? $price['max'] : null,
            ],
            'hreflang' => storefront_hreflang('shop.category', ['category' => $category]),
        ]);
    }
}
