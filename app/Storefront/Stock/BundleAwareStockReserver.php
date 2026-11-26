<?php

declare(strict_types=1);

namespace App\Storefront\Stock;

use App\Models\Product;
use App\Models\ProductBundleItem;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Shopper\Core\Contracts\StockReserver;
use Shopper\Core\Models\Contracts\Stockable;

final readonly class BundleAwareStockReserver implements StockReserver
{
    public function __construct(
        private StockReserver $reserver,
    ) {}

    /**
     * @param  Model&Stockable  $product
     */
    public function reserve(Stockable $product, int $quantity, ?Model $reference = null, ?int $userId = null): int
    {
        if (! $product instanceof Product || ! $product->isBundle()) {
            return $this->reserver->reserve($product, $quantity, $reference, $userId);
        }

        $items = $product->bundleItems()
            ->with(['product', 'variant'])
            ->get()
            ->sortBy(fn (ProductBundleItem $item): string => sprintf(
                '%s:%020d',
                $item->product_variant_id === null ? 'product' : 'variant',
                $item->product_variant_id ?? $item->product_id,
            ))
            ->values();

        if ($items->isEmpty() || $items->contains(fn (ProductBundleItem $item): bool => ! $item->isAvailable())) {
            return 0;
        }

        try {
            DB::transaction(function () use ($items, $quantity, $reference, $userId): void {
                foreach ($items as $item) {
                    $needed = $item->quantity * $quantity;
                    $reserved = $this->reserver->reserve($item->component(), $needed, $reference, $userId);

                    if ($reserved < $needed) {
                        throw new BundleShortfallException(intdiv($reserved, $item->quantity));
                    }
                }
            });
        } catch (BundleShortfallException $shortfall) {
            return $shortfall->fulfillableBundles;
        }

        return $quantity;
    }
}
