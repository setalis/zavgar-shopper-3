<?php

declare(strict_types=1);

namespace App\Actions\Product;

use App\Actions\Catalog\ResolveCategoryFilterSchema;
use App\Actions\LocalizeCatalog;
use App\Enums\CategoryFilterParameterType;
use App\Models\Category;
use App\Models\CategoryFilterGroup;
use App\Models\CategoryFilterParameter;
use App\Models\Collection;
use App\Models\Product;
use Shopper\Core\Enum\CollectionType;
use Shopper\Core\Enum\DiscountApplyTo;
use Shopper\Core\Enum\DiscountCondition;
use Shopper\Core\Models\Category as CoreCategory;
use Shopper\Core\Models\Collection as CoreCollection;
use Shopper\Core\Models\Discount;

final class BuildCategoryFilters
{
    public const string PRICE_SLUG = 'price';

    public const string CATEGORY_SLUG = 'category';

    public const string COLLECTION_SLUG = 'collection';

    public const string DISCOUNT_SLUG = 'discount';

    public const string SALE_KEY = 'sale';

    public function __construct(
        private ResolveCategoryFilterSchema $resolveCategoryFilterSchema,
        private BuildCategoryAttributeFilters $buildCategoryAttributeFilters,
        private LocalizeCatalog $localizeCatalog,
    ) {}

    /**
     * @return list<array{id: int, name: string|null, parameters: list<array{id: int, name: string, slug: string, type: string, values: list<array{key: string, label: string}>, expanded: bool}>}>
     */
    public function handle(Category $category): array
    {
        $schema = $this->resolveCategoryFilterSchema->handle($category);

        if ($schema === null) {
            return $this->autoGroups($category);
        }

        return $this->configuredGroups($category, $schema['groups']);
    }

    /**
     * @param  list<array{id: int, name: string|null, parameters: list<array{id: int, name: string, slug: string, type: string, values: list<array{key: string, label: string}>, expanded: bool}>}>  $groups
     * @return list<array{id: int, name: string, slug: string, type: string, values: list<array{key: string, label: string}>, expanded: bool}>
     */
    public function flatten(array $groups): array
    {
        $facets = [];

        foreach ($groups as $group) {
            foreach ($group['parameters'] as $parameter) {
                if ($parameter['slug'] === self::PRICE_SLUG) {
                    continue;
                }

                $facets[] = $parameter;
            }
        }

        return $facets;
    }

    /**
     * @param  list<array{id: int, name: string|null, parameters: list<array{id: int, name: string, slug: string, type: string, values: list<array{key: string, label: string}>, expanded: bool}>}>  $groups
     */
    public function includesPrice(array $groups): bool
    {
        foreach ($groups as $group) {
            foreach ($group['parameters'] as $parameter) {
                if ($parameter['slug'] === self::PRICE_SLUG) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * @return list<int>
     */
    public function categoryIds(Category $category): array
    {
        $ids = array_map('intval', $category->enabledSubtreeIds()->all());

        return $ids === [] ? [$category->id] : $ids;
    }

    /**
     * @return list<array{id: int, name: string|null, parameters: list<array{id: int, name: string, slug: string, type: string, values: list<array{key: string, label: string}>, expanded: bool}>}>
     */
    private function autoGroups(Category $category): array
    {
        $parameters = array_map(
            fn (array $parameter): array => $this->withExpanded($parameter, true),
            [
                $this->priceParameter(0),
                ...$this->buildCategoryAttributeFilters->handle($category, $this->categoryIds($category)),
            ],
        );

        return [[
            'id' => 0,
            'name' => null,
            'parameters' => $parameters,
        ]];
    }

    /**
     * @param  \Illuminate\Support\Collection<int, CategoryFilterGroup>  $groups
     * @return list<array{id: int, name: string|null, parameters: list<array{id: int, name: string, slug: string, type: string, values: list<array{key: string, label: string}>, expanded: bool}>}>
     */
    private function configuredGroups(Category $category, $groups): array
    {
        $categoryIds = $this->categoryIds($category);
        $built = [];

        foreach ($groups as $group) {
            $parameters = [];

            foreach ($group->parameters as $parameter) {
                $facet = $this->parameterFacet($category, $parameter, $categoryIds);

                if ($facet === null) {
                    continue;
                }

                $parameters[] = $this->withExpanded($facet, $parameter->is_expanded);
            }

            $built[] = [
                'id' => $group->id,
                'name' => $group->name,
                'parameters' => $parameters,
            ];
        }

        return $built;
    }

    /**
     * @param  list<int>  $categoryIds
     * @return array{id: int, name: string, slug: string, type: string, values: list<array{key: string, label: string}>}|null
     */
    private function parameterFacet(Category $category, CategoryFilterParameter $parameter, array $categoryIds): ?array
    {
        return match ($parameter->type) {
            CategoryFilterParameterType::Price => $this->priceParameter($parameter->id),
            CategoryFilterParameterType::Brand => $this->buildCategoryAttributeFilters->brandFacet($categoryIds),
            CategoryFilterParameterType::Attribute => $this->attributeParameter($parameter, $categoryIds),
            CategoryFilterParameterType::Category => $this->categoryFacet($category, $parameter->id),
            CategoryFilterParameterType::Collection => $this->collectionFacet($parameter->id, $categoryIds),
            CategoryFilterParameterType::Discount => $this->discountFacet($parameter->id, $categoryIds),
        };
    }

    /**
     * @param  list<int>  $categoryIds
     * @return array{id: int, name: string, slug: string, type: string, values: list<array{key: string, label: string}>}|null
     */
    private function attributeParameter(CategoryFilterParameter $parameter, array $categoryIds): ?array
    {
        if ($parameter->attribute_id === null) {
            return null;
        }

        $facets = $this->buildCategoryAttributeFilters->attributeFacets($categoryIds, [$parameter->attribute_id]);

        return $facets[0] ?? null;
    }

    /**
     * @param  array{id: int, name: string, slug: string, type: string, values: list<array{key: string, label: string}>}  $facet
     * @return array{id: int, name: string, slug: string, type: string, values: list<array{key: string, label: string}>, expanded: bool}
     */
    private function withExpanded(array $facet, bool $expanded): array
    {
        $facet['expanded'] = $expanded;

        return $facet;
    }

    /**
     * @return array{id: int, name: string, slug: string, type: string, values: list<array{key: string, label: string}>}
     */
    private function priceParameter(int $id): array
    {
        return [
            'id' => $id,
            'name' => 'Price',
            'slug' => self::PRICE_SLUG,
            'type' => 'price',
            'values' => [],
        ];
    }

    /**
     * @return array{id: int, name: string, slug: string, type: string, values: list<array{key: string, label: string}>}|null
     */
    private function categoryFacet(Category $category, int $parameterId): ?array
    {
        $values = $category->children()
            ->scopes('enabled')
            ->whereHas(
                'products',
                fn ($query) => $query->scopes('publish'),
            )
            ->orderBy('position')
            ->get(['id', 'name', 'slug'])
            ->map(function (Category $child): ?array {
                if (! filled($child->slug) || ! filled($child->name)) {
                    return null;
                }

                $this->localizeCatalog->handle($child);

                return [
                    'key' => $child->slug,
                    'label' => $child->name,
                ];
            })
            ->filter()
            ->values()
            ->all();

        if ($values === []) {
            return null;
        }

        return [
            'id' => $parameterId,
            'name' => 'Category',
            'slug' => self::CATEGORY_SLUG,
            'type' => 'select',
            'values' => $values,
        ];
    }

    /**
     * @param  list<int>  $categoryIds
     * @return array{id: int, name: string, slug: string, type: string, values: list<array{key: string, label: string}>}|null
     */
    private function collectionFacet(int $parameterId, array $categoryIds): ?array
    {
        $values = Collection::query()
            ->published()
            ->orderBy('name')
            ->get()
            ->filter(fn (Collection $collection): bool => $this->collectionHasProductsInScope($collection, $categoryIds))
            ->map(function (Collection $collection): ?array {
                if (! filled($collection->slug) || ! filled($collection->name)) {
                    return null;
                }

                $this->localizeCatalog->handle($collection);

                return [
                    'key' => $collection->slug,
                    'label' => $collection->name,
                ];
            })
            ->filter()
            ->values()
            ->all();

        if ($values === []) {
            return null;
        }

        return [
            'id' => $parameterId,
            'name' => 'Collection',
            'slug' => self::COLLECTION_SLUG,
            'type' => 'select',
            'values' => $values,
        ];
    }

    /**
     * @param  list<int>  $categoryIds
     * @return array{id: int, name: string, slug: string, type: string, values: list<array{key: string, label: string}>}|null
     */
    private function discountFacet(int $parameterId, array $categoryIds): ?array
    {
        $values = [];

        if ($this->scopeHasCompareAtPrice($categoryIds)) {
            $values[] = [
                'key' => self::SALE_KEY,
                'label' => 'Sale',
            ];
        }

        foreach (Discount::query()->active()->orderBy('code')->get() as $discount) {
            if (! $this->discountHasProductsInScope($discount, $categoryIds)) {
                continue;
            }

            $values[] = [
                'key' => $this->discountKey($discount),
                'label' => filled($discount->code) ? $discount->code : '#'.$discount->id,
            ];
        }

        if ($values === []) {
            return null;
        }

        return [
            'id' => $parameterId,
            'name' => 'Discount',
            'slug' => self::DISCOUNT_SLUG,
            'type' => 'select',
            'values' => $values,
        ];
    }

    /**
     * @param  list<int>  $categoryIds
     */
    private function collectionHasProductsInScope(CoreCollection $collection, array $categoryIds): bool
    {
        if ($collection->type === CollectionType::Manual) {
            return $collection->products()
                ->scopes('publish')
                ->whereHas('categories', fn ($categories) => $categories->whereIn('id', $categoryIds))
                ->exists();
        }

        return $collection->productsQuery()
            ->whereHas('categories', fn ($categories) => $categories->whereIn('id', $categoryIds))
            ->exists();
    }

    /**
     * @param  list<int>  $categoryIds
     */
    private function scopeHasCompareAtPrice(array $categoryIds): bool
    {
        $product = new Product;
        $pricesTable = shopper_table('prices');

        return Product::query()
            ->scopes('publish')
            ->whereHas('categories', fn ($categories) => $categories->whereIn('id', $categoryIds))
            ->whereExists(
                $product->storefrontPricesQuery($product->getTable())
                    ->selectRaw('1')
                    ->whereNotNull("{$pricesTable}.compare_amount"),
            )
            ->exists();
    }

    /**
     * @param  list<int>  $categoryIds
     */
    private function discountHasProductsInScope(Discount $discount, array $categoryIds): bool
    {
        $productIds = $this->productIdsForDiscount($discount);

        $query = Product::query()
            ->scopes('publish')
            ->whereHas('categories', fn ($categories) => $categories->whereIn('id', $categoryIds));

        if ($productIds !== null) {
            $query->whereIn('id', $productIds === [] ? [0] : $productIds);
        }

        return $query->exists();
    }

    /**
     * @return list<int>|null
     */
    public function productIdsForDiscount(Discount $discount): ?array
    {
        if ($discount->apply_to !== DiscountApplyTo::Products->value) {
            return null;
        }

        $discount->loadMissing('items.discountable');

        $items = $discount->items->where('condition', DiscountCondition::ApplyTo);

        if ($items->isEmpty()) {
            return null;
        }

        $productIds = [];

        foreach ($items as $item) {
            $discountable = $item->discountable;

            if ($discountable instanceof Product) {
                $productIds[] = $discountable->id;

                continue;
            }

            if ($discountable instanceof CoreCollection) {
                $productIds = [
                    ...$productIds,
                    ...$discountable->productsQuery()->pluck('id')->all(),
                ];

                continue;
            }

            if ($discountable instanceof CoreCategory) {
                $productIds = [
                    ...$productIds,
                    ...Product::query()
                        ->whereHas('categories', fn ($categories) => $categories->where('id', $discountable->id))
                        ->pluck('id')
                        ->all(),
                ];
            }
        }

        return array_values(array_unique(array_map('intval', $productIds)));
    }

    public function discountKey(Discount $discount): string
    {
        return 'd-'.$discount->id;
    }
}
