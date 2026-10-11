<?php

declare(strict_types=1);

namespace App\Actions\Product;

use App\Models\AttributeProduct;
use App\Models\Product;
use App\Models\ProductVariant;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

final class CopyProductRelations
{
    /**
     * @var list<string>
     */
    private const array PRODUCT_COLUMNS = [
        'featured',
        'external_id',
        'supplier_id',
        'allow_backorder',
        'seo_title',
        'seo_description',
        'metadata',
        'weight_unit',
        'weight_value',
        'height_unit',
        'height_value',
        'width_unit',
        'width_value',
        'depth_unit',
        'depth_value',
        'volume_unit',
        'volume_value',
    ];

    public function execute(Product $source, Product $target): void
    {
        $source->load([
            'prices',
            'attributeProducts',
            'variants.prices',
            'variants.stockLevels',
            'variants.values',
            'variants.translations',
            'tags',
            'relatedProducts',
            'discounts',
            'translations',
        ]);

        $target->update($source->only(self::PRODUCT_COLUMNS));
        $target->tags()->sync($source->tags->modelKeys());
        $target->relatedProducts()->sync($source->relatedProducts->modelKeys());
        $target->discounts()->sync($source->discounts->modelKeys());

        $this->copyPrices($source, $target);
        $this->copyTranslations($source, $target);
        $this->copyProductMedia($source, $target);

        foreach ($source->attributeProducts as $attributeProduct) {
            $this->copyAttributeProduct($attributeProduct, $target);
        }

        foreach ($source->variants as $variant) {
            $this->copyVariant($variant, $target);
        }
    }

    private function copyAttributeProduct(AttributeProduct $attributeProduct, Product $target): void
    {
        $copy = $attributeProduct->replicate();
        $copy->product_id = $target->id;
        $copy->save();

        $this->copyAllMedia($attributeProduct, $copy);
    }

    private function copyVariant(ProductVariant $variant, Product $target): void
    {
        $copy = $variant->replicate(['sku', 'barcode', 'ean', 'upc']);
        $copy->product_id = $target->id;
        $copy->sku = null;
        $copy->barcode = null;
        $copy->ean = null;
        $copy->upc = null;
        $copy->save();

        $copy->values()->sync($variant->values->modelKeys());
        $this->copyPrices($variant, $copy);
        $this->copyTranslations($variant, $copy);
        $this->copyAllMedia($variant, $copy);

        foreach ($variant->stockLevels as $level) {
            if ($level->quantity === 0) {
                continue;
            }

            $copy->mutateStock(
                inventoryId: $level->inventory_id,
                quantity: $level->quantity,
                oldQuantity: $level->quantity,
                event: __('shopper::pages/products.inventory.initial'),
            );
        }
    }

    private function copyPrices(Product|ProductVariant $source, Product|ProductVariant $target): void
    {
        foreach ($source->prices as $price) {
            $copy = $price->replicate();
            $copy->priceable_type = $target->getMorphClass();
            $copy->priceable_id = $target->getKey();
            $copy->save();
        }
    }

    private function copyTranslations(Product|ProductVariant $source, Product|ProductVariant $target): void
    {
        foreach ($source->translations as $translation) {
            $copy = $translation->replicate();
            $copy->translatable_type = $target->getMorphClass();
            $copy->translatable_id = $target->getKey();
            $copy->save();
        }
    }

    private function copyProductMedia(Product $source, Product $target): void
    {
        $thumbnail = (string) config('shopper.media.storage.thumbnail_collection', 'thumbnail');
        $images = (string) config('shopper.media.storage.collection_name', 'uploads');

        if ($target->getMedia($thumbnail)->isEmpty()) {
            $this->copyCollection($source, $target, $thumbnail);
        }

        if ($target->getMedia($images)->isEmpty()) {
            $this->copyCollection($source, $target, $images);
        }

        $this->copyCollection($source, $target, 'files');
    }

    private function copyCollection(Product $source, Product $target, string $collection): void
    {
        foreach ($source->getMedia($collection) as $media) {
            $media->copy($target, $collection);
        }
    }

    private function copyAllMedia(HasMedia $source, HasMedia $target): void
    {
        foreach ($source->getMedia() as $media) {
            if (! $media instanceof Media) {
                continue;
            }

            $media->copy($target, $media->collection_name);
        }
    }
}
