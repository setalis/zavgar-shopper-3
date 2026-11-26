<?php

declare(strict_types=1);

namespace App\Actions\Bundle;

use App\Models\Product;
use App\Models\ProductBundleItem;
use Illuminate\Database\Eloquent\Collection;

final readonly class ResolveBundleStock
{
    /**
     * How many complete bundles the components allow. A missing or unpublished component makes the bundle unavailable.
     */
    public function handle(Product $bundle): int
    {
        $items = $this->items($bundle);

        if ($items->isEmpty()) {
            return 0;
        }

        return (int) $items->map(function (ProductBundleItem $item): int {
            if (! $item->isAvailable()) {
                return 0;
            }

            return intdiv(max(0, $item->componentStock()), max(1, $item->quantity));
        })->min();
    }

    /**
     * Back-ordered components never block the bundle, mirroring how the cart treats them on their own.
     */
    public function canFulfil(Product $bundle, int $quantity = 1): bool
    {
        $items = $this->items($bundle);

        if ($items->isEmpty() || $quantity < 1) {
            return false;
        }

        return $items->every(fn (ProductBundleItem $item): bool => $item->isAvailable()
            && ($item->allowsBackorder() || $item->componentStock() >= $item->quantity * $quantity));
    }

    /**
     * @return Collection<int, ProductBundleItem>
     */
    private function items(Product $bundle): Collection
    {
        if (! $bundle->relationLoaded('bundleItems')) {
            $bundle->setRelation(
                'bundleItems',
                $bundle->bundleItems()->withComponentStock()->with(['product', 'variant'])->get(),
            );
        }

        $bundle->bundleItems->loadMissing(['product', 'variant']);

        return $bundle->bundleItems;
    }
}
