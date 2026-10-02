<?php

declare(strict_types=1);

namespace App\Models;

use Shopper\Models\AttributeProduct as Model;

/**
 * @property-read bool $is_variant_option
 */
final class AttributeProduct extends Model
{
    public static function markVariantOption(int $productId, int $attributeId, bool $isVariantOption): void
    {
        self::query()
            ->where('product_id', $productId)
            ->where('attribute_id', $attributeId)
            ->update(['is_variant_option' => $isVariantOption]);
    }

    public static function isVariantOption(int $productId, int $attributeId): bool
    {
        return self::query()
            ->where('product_id', $productId)
            ->where('attribute_id', $attributeId)
            ->where('is_variant_option', true)
            ->exists();
    }

    public static function isUsedByVariants(int $productId, int $attributeId): bool
    {
        return ProductVariant::query()
            ->where('product_id', $productId)
            ->whereHas('values', fn ($query) => $query->where('attribute_id', $attributeId))
            ->exists();
    }

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            ...parent::casts(),
            'is_variant_option' => 'boolean',
        ];
    }
}
