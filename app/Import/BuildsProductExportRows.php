<?php

declare(strict_types=1);

namespace App\Import;

use App\Models\Product;
use Generator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Shopper\Core\Enum\ProductType;
use Shopper\Core\Models\AttributeProduct;
use Shopper\Core\Models\Contracts\Inventory as InventoryContract;
use Shopper\Core\Models\Contracts\ProductVariant as ProductVariantContract;
use Shopper\Core\Models\Price;

/**
 * Builds rows in the import template format, so an exported file can be edited and imported back.
 * Image columns stay empty because re-importing them would download every image again.
 */
final class BuildsProductExportRows
{
    private const int CHUNK_SIZE = 100;

    private ?int $inventoryId = null;

    private int $currencyId = 0;

    /**
     * @return Generator<int, list<string>>
     */
    public function handle(): Generator
    {
        $this->currencyId = (int) shopper_setting('default_currency_id');
        $this->inventoryId = resolve(InventoryContract::class)::query()->scopes('default')->value('id');

        yield ProductImportTemplate::COLUMNS;

        $products = Product::query()
            ->with([
                'brand',
                'supplier',
                'tags',
                'categories.parent',
                'attributeProducts.attribute',
                'attributeProducts.value',
                'prices.currency',
                'stockLevels',
                'variants' => fn ($query) => $query->orderBy('position'),
                'variants.values.attribute',
                'variants.prices.currency',
                'variants.stockLevels',
            ])
            ->lazyById(self::CHUNK_SIZE);

        foreach ($products as $product) {
            yield from $this->productRows($product);
        }
    }

    /**
     * @return list<list<string>>
     */
    private function productRows(Product $product): array
    {
        $productRow = [
            'handle' => (string) $product->slug,
            'name' => $product->name,
            'description' => (string) $product->description,
            'brand' => (string) $product->brand?->name,
            'category' => $this->categoryPath($product),
            'tags' => $product->tags->pluck('name')->implode(', '),
            'published' => $this->flag($product->is_visible),
            'featured' => $this->flag($product->featured),
            'supplier' => (string) $product->supplier?->name,
            'attributes' => $this->attributes($product->attributeProducts),
            'seo_title' => (string) $product->seo_title,
            'seo_description' => (string) $product->seo_description,
            ...$this->dimensions($product),
        ];

        if ($product->type !== ProductType::Variant) {
            return [$this->row([
                ...$productRow,
                ...$this->sellable($product),
                'barcode' => (string) $product->barcode,
                'allow_backorder' => $this->flag($product->allow_backorder),
            ])];
        }

        return [
            $this->row([
                ...$productRow,
                'sku' => (string) $product->sku,
                'allow_backorder' => $this->flag($product->allow_backorder),
            ]),
            ...$product->variants->map(fn (ProductVariantContract $variant): array => $this->row([
                'handle' => (string) $product->slug,
                'variations' => $variant->values
                    ->map(fn (Model $value): string => "{$value->attribute->name}: {$value->value}")
                    ->implode('; '),
                ...$this->sellable($variant),
                'barcode' => (string) $variant->barcode,
                'ean' => (string) $variant->ean,
                'upc' => (string) $variant->upc,
                'allow_backorder' => $this->flag($variant->allow_backorder),
                ...$this->dimensions($variant),
            ]))->all(),
        ];
    }

    /**
     * @param  Model&(Product|ProductVariantContract)  $model
     * @return array<string, string>
     */
    private function sellable(Model $model): array
    {
        /** @var Collection<int, Price> $prices */
        $prices = $model->prices;
        $price = $prices->firstWhere('currency_id', $this->currencyId) ?? $prices->first();

        return [
            'sku' => (string) $model->sku,
            'price' => $this->money($price?->amount),
            'compare_at_price' => $this->money($price?->compare_amount),
            'cost_per_item' => $this->money($price?->cost_amount),
            'currency' => (string) $price?->currency?->code,
            'quantity' => (string) (int) $model->stockLevels->where('inventory_id', $this->inventoryId)->sum('quantity'),
            'weight_value' => $this->number($model->weight_value),
            'weight_unit' => $model->weight_value === null ? '' : (string) $model->weight_unit?->value,
        ];
    }

    /**
     * @param  Model&(Product|ProductVariantContract)  $model
     * @return array<string, string>
     */
    private function dimensions(Model $model): array
    {
        $hasDimensions = $model->width_value !== null || $model->height_value !== null || $model->depth_value !== null;

        return [
            'width_value' => $this->number($model->width_value),
            'height_value' => $this->number($model->height_value),
            'depth_value' => $this->number($model->depth_value),
            'length_unit' => $hasDimensions ? (string) $model->width_unit?->value : '',
        ];
    }

    /**
     * @param  Collection<int, AttributeProduct>  $attributeProducts
     */
    private function attributes(Collection $attributeProducts): string
    {
        return $attributeProducts
            ->filter(fn (AttributeProduct $row): bool => $row->attribute !== null)
            ->groupBy(fn (AttributeProduct $row): string => $row->attribute->name)
            ->map(fn ($rows, string $name): string => $name.': '.$rows->map(fn (AttributeProduct $row): string => $row->real_value)->implode(' | '))
            ->implode('; ');
    }

    private function categoryPath(Product $product): string
    {
        $category = $product->categories->first();
        $segments = [];

        while ($category !== null) {
            array_unshift($segments, $category->name);
            $category = $category->parent;
        }

        return implode(' > ', $segments);
    }

    /**
     * @param  array<string, string>  $values
     * @return list<string>
     */
    private function row(array $values): array
    {
        return array_map(fn (string $column): string => $values[$column] ?? '', ProductImportTemplate::COLUMNS);
    }

    private function flag(mixed $value): string
    {
        return $value ? '1' : '0';
    }

    private function money(?int $amount): string
    {
        return $amount === null ? '' : $this->number($amount / 100);
    }

    private function number(mixed $value): string
    {
        if ($value === null || $value === '') {
            return '';
        }

        return rtrim(rtrim(number_format((float) $value, 2, '.', ''), '0'), '.');
    }
}
