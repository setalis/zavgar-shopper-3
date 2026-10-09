<?php

declare(strict_types=1);

namespace App\Actions\Product;

use App\Actions\LocalizeCatalog;
use App\Models\Brand;
use App\Models\Category;
use Illuminate\Support\Collection;
use Shopper\Core\Enum\FieldType;
use Shopper\Core\Models\Attribute;
use Shopper\Core\Models\AttributeProduct;
use Shopper\Core\Models\AttributeValue;

final class BuildCategoryAttributeFilters
{
    public const string BRAND_SLUG = 'brand';

    /**
     * @var list<FieldType>
     */
    private const array FILTERABLE_TYPES = [
        FieldType::Checkbox,
        FieldType::ColorPicker,
        FieldType::Number,
        FieldType::Select,
        FieldType::Text,
    ];

    /**
     * @param  list<int>|null  $categoryIds
     * @return list<array{id: int, name: string, slug: string, type: string, values: list<array{key: string, label: string}>}>
     */
    public function handle(Category $category, ?array $categoryIds = null): array
    {
        $categoryIds ??= [$category->id];
        $attributeFilters = $this->attributeFacets($categoryIds);
        $brandFilter = $this->brandFacet($categoryIds);

        if ($brandFilter === null) {
            return $attributeFilters;
        }

        return [$brandFilter, ...$attributeFilters];
    }

    /**
     * @param  list<int>  $categoryIds
     * @param  list<int>|null  $attributeIds
     * @return list<array{id: int, name: string, slug: string, type: string, values: list<array{key: string, label: string}>}>
     */
    public function attributeFacets(array $categoryIds, ?array $attributeIds = null): array
    {
        $rows = AttributeProduct::query()
            ->with(['attribute', 'value'])
            ->whereHas(
                'attribute',
                function ($query) use ($attributeIds): void {
                    $query->enabled();

                    if ($attributeIds === null) {
                        $query
                            ->isFilterable()
                            ->whereIn('type', self::FILTERABLE_TYPES);

                        return;
                    }

                    $query->whereIn('id', $attributeIds);
                },
            )
            ->whereHas(
                'product',
                fn ($query) => $query
                    ->scopes('publish')
                    ->whereHas('categories', fn ($categories) => $categories->whereIn('id', $categoryIds)),
            )
            ->get();

        return $rows
            ->groupBy('attribute_id')
            ->map(fn (Collection $group): ?array => $this->mapAttributeGroup($group))
            ->filter()
            ->sortBy('name', SORT_NATURAL | SORT_FLAG_CASE)
            ->values()
            ->all();
    }

    /**
     * @param  list<int>  $categoryIds
     * @return array{id: int, name: string, slug: string, type: string, values: list<array{key: string, label: string}>}|null
     */
    public function brandFacet(array $categoryIds): ?array
    {
        $values = Brand::query()
            ->enabled()
            ->whereHas(
                'products',
                fn ($query) => $query
                    ->scopes('publish')
                    ->whereHas('categories', fn ($categories) => $categories->whereIn('id', $categoryIds)),
            )
            ->orderBy('name')
            ->get(['id', 'name', 'slug'])
            ->map(fn (Brand $brand): ?array => $this->mapBrandValue($brand))
            ->filter()
            ->values()
            ->all();

        if ($values === []) {
            return null;
        }

        return [
            'id' => 0,
            'name' => 'Brand',
            'slug' => self::BRAND_SLUG,
            'type' => 'select',
            'values' => $values,
        ];
    }

    /**
     * @return array{key: string, label: string}|null
     */
    private function mapBrandValue(Brand $brand): ?array
    {
        if (! filled($brand->slug) || ! filled($brand->name)) {
            return null;
        }

        return [
            'key' => $brand->slug,
            'label' => $brand->name,
        ];
    }

    /**
     * @param  Collection<int, AttributeProduct>  $group
     * @return array{id: int, name: string, slug: string, type: string, values: list<array{key: string, label: string}>}|null
     */
    private function mapAttributeGroup(Collection $group): ?array
    {
        $first = $group->first();
        $attribute = $first?->attribute;

        if (! $attribute instanceof Attribute) {
            return null;
        }

        $localizer = resolve(LocalizeCatalog::class);
        $localizer->handle($attribute);

        $values = $group
            ->map(fn (AttributeProduct $row): ?array => $this->mapValue($row, $localizer))
            ->filter()
            ->unique('key')
            ->sortBy([
                fn (array $value): int => $value['position'],
                fn (array $value): string => mb_strtolower($value['label']),
            ])
            ->map(fn (array $value): array => [
                'key' => $value['key'],
                'label' => $value['label'],
            ])
            ->values()
            ->all();

        if ($values === []) {
            return null;
        }

        return [
            'id' => $attribute->id,
            'name' => $attribute->name,
            'slug' => $attribute->slug,
            'type' => $attribute->type->value,
            'values' => $values,
        ];
    }

    /**
     * @return array{key: string, label: string, position: int}|null
     */
    private function mapValue(AttributeProduct $row, LocalizeCatalog $localizer): ?array
    {
        $attributeValue = $row->value;

        if ($attributeValue instanceof AttributeValue && filled($attributeValue->key)) {
            $localizer->handle($attributeValue);

            return [
                'key' => $attributeValue->key,
                'label' => filled($attributeValue->value) ? $attributeValue->value : $attributeValue->key,
                'position' => $attributeValue->position,
            ];
        }

        $localizer->handle($row);
        $customValue = $row->attribute_custom_value;

        if (! filled($customValue)) {
            return null;
        }

        return [
            'key' => $customValue,
            'label' => $customValue,
            'position' => PHP_INT_MAX,
        ];
    }
}
