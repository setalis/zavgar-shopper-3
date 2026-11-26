<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Product;
use App\Models\ProductBundleItem;
use App\Models\ProductVariant;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ProductBundleItem>
 */
final class ProductBundleItemFactory extends Factory
{
    protected $model = ProductBundleItem::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'bundle_id' => Product::factory()->standard()->state(['is_bundle' => true]),
            'product_id' => Product::factory()->standard(),
            'product_variant_id' => null,
            'quantity' => 1,
            'position' => 0,
        ];
    }

    public function forVariant(ProductVariant $variant): self
    {
        return $this->state([
            'product_id' => $variant->product_id,
            'product_variant_id' => $variant->id,
        ]);
    }
}
