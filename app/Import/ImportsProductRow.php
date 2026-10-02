<?php

declare(strict_types=1);

namespace App\Import;

use App\Models\AttributeProduct;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Shopper\Core\Enum\FieldType;
use Shopper\Core\Import\ProductRowImporter;
use Shopper\Core\Models\Attribute;
use Shopper\Core\Models\AttributeValue;
use Shopper\Core\Models\Contracts\Product as ProductContract;

final class ImportsProductRow
{
    public function __construct(
        private ProductRowImporter $importer,
    ) {}

    /**
     * @return Model&ProductContract
     */
    public function import(ProductImportRow $row): ProductContract
    {
        // The core importer dispatches image download jobs after its own transaction commits,
        // so it must not be wrapped in an outer transaction.
        $product = $this->importer->import($row->product);

        DB::transaction(function () use ($product, $row): void {
            $this->applyProductData($product, $row);
            $this->applyVariantData($product, $row->variantData);
            $this->syncAttributes($product, $row->attributes);
        });

        return $product;
    }

    /**
     * @param  Model&ProductContract  $product
     */
    private function applyProductData(ProductContract $product, ProductImportRow $row): void
    {
        $data = $row->productData;

        if ($row->supplier !== null) {
            $data['supplier_id'] = $this->resolveSupplierId($row->supplier);
        }

        if ($row->sku !== null && ! $row->product->isStandard()) {
            $data['sku'] = $row->sku;
        }

        if ($data !== []) {
            $product->update($data);
        }
    }

    /**
     * @param  Model&ProductContract  $product
     * @param  array<string, array<string, mixed>>  $variantData
     */
    private function applyVariantData(ProductContract $product, array $variantData): void
    {
        foreach ($variantData as $sku => $data) {
            $product->variants()->where('sku', $sku)->first()?->update($data);
        }
    }

    private function resolveSupplierId(string $name): int
    {
        $supplierModel = config('shopper.models.supplier');

        $supplier = $supplierModel::query()->where('name', $name)->first()
            ?? $supplierModel::query()->create([
                'name' => $name,
                'slug' => $name,
                'is_enabled' => true,
            ]);

        return $supplier->id;
    }

    /**
     * Replaces values only for the attributes listed in the file, other product attributes stay untouched.
     *
     * @param  Model&ProductContract  $product
     * @param  array<string, list<string>>  $attributes
     */
    private function syncAttributes(ProductContract $product, array $attributes): void
    {
        foreach ($attributes as $name => $values) {
            $attribute = Attribute::query()->where('name', $name)->first()
                ?? Attribute::query()->create([
                    'name' => $name,
                    'slug' => $name,
                    'type' => count($values) > 1 ? FieldType::Checkbox : FieldType::Select,
                    'is_enabled' => true,
                ]);

            $isVariantOption = AttributeProduct::isVariantOption($product->id, $attribute->id)
                || AttributeProduct::isUsedByVariants($product->id, $attribute->id);

            AttributeProduct::query()
                ->where('product_id', $product->id)
                ->where('attribute_id', $attribute->id)
                ->delete();

            foreach ($this->attributeProductRows($attribute, $values) as $row) {
                AttributeProduct::create([
                    'product_id' => $product->id,
                    'attribute_id' => $attribute->id,
                    'is_variant_option' => $isVariantOption,
                    ...$row,
                ]);
            }
        }
    }

    /**
     * @param  list<string>  $values
     * @return list<array{attribute_value_id?: int, attribute_custom_value?: string}>
     */
    private function attributeProductRows(Attribute $attribute, array $values): array
    {
        if ($attribute->hasTextValue()) {
            return [['attribute_custom_value' => implode(' | ', $values)]];
        }

        if ($attribute->hasSingleValue()) {
            $values = array_slice($values, 0, 1);
        }

        return array_map(
            fn (string $value): array => ['attribute_value_id' => $this->resolveValueId($attribute, $value)],
            $values,
        );
    }

    private function resolveValueId(Attribute $attribute, string $value): int
    {
        return AttributeValue::query()->firstOrCreate(
            ['attribute_id' => $attribute->id, 'value' => $value],
            [
                'key' => str($value)->slug()->toString() ?: $value,
                'position' => (int) $attribute->values()->max('position') + 1,
            ],
        )->id;
    }
}
