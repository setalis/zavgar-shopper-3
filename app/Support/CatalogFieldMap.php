<?php

declare(strict_types=1);

namespace App\Support;

use Illuminate\Database\Eloquent\Model;
use Shopper\Core\Models\Attribute;
use Shopper\Core\Models\AttributeProduct;
use Shopper\Core\Models\AttributeValue;

final class CatalogFieldMap
{
    /**
     * @return array<string, string>
     */
    public static function for(Model $model): array
    {
        if (method_exists($model, 'catalogTranslationMap')) {
            /** @var array<string, string> $map */
            $map = $model->catalogTranslationMap();

            return $map;
        }

        if ($model instanceof Attribute) {
            return ['name' => 'name'];
        }

        if ($model instanceof AttributeValue) {
            return ['value' => 'value'];
        }

        if ($model instanceof AttributeProduct) {
            return ['attribute_custom_value' => 'value'];
        }

        return ['name' => 'name'];
    }
}
