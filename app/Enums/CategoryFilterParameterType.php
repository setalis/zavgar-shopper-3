<?php

declare(strict_types=1);

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;
use Illuminate\Contracts\Support\Htmlable;

enum CategoryFilterParameterType: string implements HasLabel
{
    case Attribute = 'attribute';
    case Category = 'category';
    case Collection = 'collection';
    case Brand = 'brand';
    case Price = 'price';
    case Discount = 'discount';

    public function getLabel(): string|Htmlable|null
    {
        return match ($this) {
            self::Attribute => __('backend.category_filters.types.attribute'),
            self::Category => __('backend.category_filters.types.category'),
            self::Collection => __('backend.category_filters.types.collection'),
            self::Brand => __('backend.category_filters.types.brand'),
            self::Price => __('backend.category_filters.types.price'),
            self::Discount => __('backend.category_filters.types.discount'),
        };
    }

    public function slug(): string
    {
        return match ($this) {
            self::Attribute => 'attribute',
            self::Category => 'category',
            self::Collection => 'collection',
            self::Brand => 'brand',
            self::Price => 'price',
            self::Discount => 'discount',
        };
    }

    /**
     * @return array<string, string>
     */
    public static function options(): array
    {
        return collect(self::cases())
            ->mapWithKeys(fn (self $type): array => [$type->value => (string) $type->getLabel()])
            ->all();
    }
}
