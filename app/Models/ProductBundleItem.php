<?php

declare(strict_types=1);

namespace App\Models;

use Database\Factories\ProductBundleItemFactory;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Shopper\Core\Models\StockLevel;

/**
 * @property-read int $id
 * @property-read int $bundle_id
 * @property-read int $product_id
 * @property-read ?int $product_variant_id
 * @property-read int $quantity
 * @property-read int $position
 * @property-read ?Product $bundle
 * @property-read ?Product $product
 * @property-read ?ProductVariant $variant
 */
final class ProductBundleItem extends Model
{
    /** @use HasFactory<ProductBundleItemFactory> */
    use HasFactory;

    protected $fillable = [
        'bundle_id',
        'product_id',
        'product_variant_id',
        'quantity',
        'position',
    ];

    /**
     * @return BelongsTo<Product, $this>
     */
    public function bundle(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'bundle_id');
    }

    /**
     * @return BelongsTo<Product, $this>
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    /**
     * @return BelongsTo<ProductVariant, $this>
     */
    public function variant(): BelongsTo
    {
        return $this->belongsTo(ProductVariant::class, 'product_variant_id');
    }

    /**
     * The component that actually carries the stock: the variant when one is pinned, the product otherwise.
     */
    public function component(): Product|ProductVariant|null
    {
        if ($this->product_variant_id !== null) {
            return $this->variant;
        }

        return $this->product;
    }

    public function isAvailable(): bool
    {
        if (! $this->product instanceof Product || ! $this->product->isPublished()) {
            return false;
        }

        return $this->product_variant_id === null || $this->variant instanceof ProductVariant;
    }

    public function componentStock(): int
    {
        if (array_key_exists('component_stock', $this->attributes)) {
            return (int) $this->attributes['component_stock'];
        }

        return (int) $this->component()?->stock;
    }

    public function allowsBackorder(): bool
    {
        return (bool) $this->component()?->allow_backorder;
    }

    /**
     * @param  Builder<self>  $query
     * @return Builder<self>
     */
    #[Scope]
    protected function withComponentStock(Builder $query): Builder
    {
        $itemsTable = $query->getModel()->getTable();

        if ($query->getQuery()->columns === null) {
            $query->select("{$itemsTable}.*");
        }

        return $query->addSelect([
            'component_stock' => fn (QueryBuilder $stock): QueryBuilder => $stock
                ->selectRaw('coalesce(sum(quantity), 0)')
                ->from((new StockLevel)->getTable())
                ->where(fn (QueryBuilder $stock): QueryBuilder => $stock
                    ->where(fn (QueryBuilder $variant): QueryBuilder => $variant
                        ->whereNotNull("{$itemsTable}.product_variant_id")
                        ->where('stockable_type', (new ProductVariant)->getMorphClass())
                        ->whereColumn('stockable_id', "{$itemsTable}.product_variant_id"))
                    ->orWhere(fn (QueryBuilder $product): QueryBuilder => $product
                        ->whereNull("{$itemsTable}.product_variant_id")
                        ->where('stockable_type', (new Product)->getMorphClass())
                        ->whereColumn('stockable_id', "{$itemsTable}.product_id"))),
        ]);
    }

    protected function casts(): array
    {
        return [
            'quantity' => 'integer',
            'position' => 'integer',
        ];
    }
}
