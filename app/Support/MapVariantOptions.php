<?php

declare(strict_types=1);

namespace App\Support;

use App\Models\AttributeProduct;
use Illuminate\Support\Collection;
use Shopper\Core\Models\AttributeValue;
use Shopper\Core\Models\Contracts\Product;

/**
 * Same output as Shopper's MapProductOptions, limited to attributes marked as variant options.
 */
final class MapVariantOptions
{
    /**
     * @return list<array{id: int, key: string, name: string, values: list<array{id: int, key: string, value: string}>}>
     */
    public static function generate(Product $product): array
    {
        return AttributeProduct::query()
            ->with(['attribute', 'value'])
            ->where('product_id', $product->id)
            ->where('is_variant_option', true)
            ->whereNotNull('attribute_value_id')
            ->orderBy('id')
            ->get()
            ->filter(fn (AttributeProduct $row): bool => $row->value instanceof AttributeValue && ! $row->attribute->hasTextValue())
            ->groupBy('attribute_id')
            ->map(fn (Collection $rows): array => [
                'id' => $rows->first()->attribute->id,
                'key' => 'attribute_'.$rows->first()->attribute->id,
                'name' => $rows->first()->attribute->name,
                'values' => $rows
                    ->map(fn (AttributeProduct $row): array => [
                        'id' => $row->value->id,
                        'key' => 'value_'.$row->value->id,
                        'value' => $row->value->value,
                    ])
                    ->unique('id')
                    ->values()
                    ->all(),
            ])
            ->values()
            ->all();
    }
}
