<?php

declare(strict_types=1);

namespace App\Actions\Product;

use App\Models\Brand;
use App\Models\Collection;
use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Shopper\Core\Enum\CollectionType;
use Shopper\Core\Models\AttributeProduct;
use Shopper\Core\Models\AttributeValue;
use Shopper\Core\Models\Discount;

final class ApplyCategoryFilters
{
    public function __construct(
        private BuildCategoryFilters $buildCategoryFilters,
    ) {}

    /**
     * @param  Builder<Product>  $query
     * @param  array<string, list<string>>  $selected
     * @param  list<array{id: int, name: string, slug: string, type: string, values: list<array{key: string, label: string}>}>  $facets
     * @return Builder<Product>
     */
    public function handle(Builder $query, array $selected, array $facets): Builder
    {
        $facetsBySlug = collect($facets)->keyBy('slug');
        $productsTable = $query->getModel()->getTable();

        foreach ($selected as $slug => $keys) {
            $facet = $facetsBySlug->get($slug);

            if (! is_array($facet)) {
                continue;
            }

            $allowedKeys = collect($facet['values'])->pluck('key')->all();
            $keys = array_values(array_intersect($keys, $allowedKeys));

            if ($keys === []) {
                continue;
            }

            $query = match ($slug) {
                BuildCategoryAttributeFilters::BRAND_SLUG => $this->applyBrand($query, $productsTable, $keys),
                BuildCategoryFilters::CATEGORY_SLUG => $this->applyCategory($query, $keys),
                BuildCategoryFilters::COLLECTION_SLUG => $this->applyCollection($query, $productsTable, $keys),
                BuildCategoryFilters::DISCOUNT_SLUG => $this->applyDiscount($query, $productsTable, $keys),
                default => $this->applyAttribute($query, $productsTable, $facet, $keys),
            };
        }

        return $query;
    }

    /**
     * @param  Builder<Product>  $query
     * @param  list<string>  $keys
     * @return Builder<Product>
     */
    private function applyBrand(Builder $query, string $productsTable, array $keys): Builder
    {
        return $query->whereIn(
            "{$productsTable}.brand_id",
            Brand::query()
                ->enabled()
                ->select('id')
                ->whereIn('slug', $keys),
        );
    }

    /**
     * @param  Builder<Product>  $query
     * @param  list<string>  $keys
     * @return Builder<Product>
     */
    private function applyCategory(Builder $query, array $keys): Builder
    {
        return $query->whereHas(
            'categories',
            fn ($categories) => $categories
                ->scopes('enabled')
                ->whereIn('slug', $keys),
        );
    }

    /**
     * @param  Builder<Product>  $query
     * @param  list<string>  $keys
     * @return Builder<Product>
     */
    private function applyCollection(Builder $query, string $productsTable, array $keys): Builder
    {
        $collections = Collection::query()
            ->published()
            ->whereIn('slug', $keys)
            ->get();

        if ($collections->isEmpty()) {
            return $query->whereRaw('1 = 0');
        }

        return $query->where(function (Builder $constraint) use ($collections, $productsTable): void {
            $manualIds = $collections
                ->filter(fn (Collection $collection): bool => $collection->type === CollectionType::Manual)
                ->pluck('id');

            if ($manualIds->isNotEmpty()) {
                $constraint->orWhereHas(
                    'collections',
                    fn ($collections) => $collections->whereIn('id', $manualIds),
                );
            }

            foreach ($collections as $collection) {
                if ($collection->type !== CollectionType::Auto) {
                    continue;
                }

                $constraint->orWhereIn(
                    "{$productsTable}.id",
                    $collection->productsQuery()->select('id'),
                );
            }
        });
    }

    /**
     * @param  Builder<Product>  $query
     * @param  list<string>  $keys
     * @return Builder<Product>
     */
    private function applyDiscount(Builder $query, string $productsTable, array $keys): Builder
    {
        $pricesTable = shopper_table('prices');

        return $query->where(function (Builder $constraint) use ($keys, $productsTable, $pricesTable): void {
            if (in_array(BuildCategoryFilters::SALE_KEY, $keys, true)) {
                $product = $constraint->getModel();

                $constraint->orWhereExists(
                    $product->storefrontPricesQuery($productsTable)
                        ->selectRaw('1')
                        ->whereNotNull("{$pricesTable}.compare_amount"),
                );
            }

            $discountIds = [];

            foreach ($keys as $key) {
                if (! str_starts_with($key, 'd-')) {
                    continue;
                }

                $discountIds[] = (int) substr($key, 2);
            }

            if ($discountIds === []) {
                return;
            }

            $discounts = Discount::query()
                ->active()
                ->whereIn('id', $discountIds)
                ->get();

            foreach ($discounts as $discount) {
                $productIds = $this->buildCategoryFilters->productIdsForDiscount($discount);

                if ($productIds === null) {
                    $constraint->orWhereRaw('1 = 1');

                    continue;
                }

                if ($productIds === []) {
                    continue;
                }

                $constraint->orWhereIn("{$productsTable}.id", $productIds);
            }
        });
    }

    /**
     * @param  Builder<Product>  $query
     * @param  array{id: int, name: string, slug: string, type: string, values: list<array{key: string, label: string}>}  $facet
     * @param  list<string>  $keys
     * @return Builder<Product>
     */
    private function applyAttribute(Builder $query, string $productsTable, array $facet, array $keys): Builder
    {
        $attributeId = $facet['id'];

        if ($attributeId < 1) {
            return $query;
        }

        return $query->whereIn(
            "{$productsTable}.id",
            AttributeProduct::query()
                ->select('product_id')
                ->where('attribute_id', $attributeId)
                ->where(function ($constraint) use ($attributeId, $keys): void {
                    $constraint
                        ->whereIn('attribute_custom_value', $keys)
                        ->orWhereIn(
                            'attribute_value_id',
                            AttributeValue::query()
                                ->select('id')
                                ->where('attribute_id', $attributeId)
                                ->whereIn('key', $keys),
                        );
                }),
        );
    }
}
