<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Models\Product;
use App\Models\ProductBundleItem;
use Shopper\Cart\Events\CartCompleted;
use Shopper\Core\Models\OrderItem;

/**
 * Freezes what a bundle contained at purchase time, so later edits of the bundle
 * neither rewrite order history nor misdirect a cancellation restock.
 */
final class SnapshotBundleComposition
{
    public function handle(CartCompleted $event): void
    {
        $productMorph = (new Product)->getMorphClass();

        $event->order->loadMissing('items');

        $event->order->items
            ->filter(fn (OrderItem $item): bool => in_array($item->product_type, [$productMorph, Product::class], true))
            ->each(function (OrderItem $item): void {
                $bundle = Product::query()
                    ->with(['bundleItems.product', 'bundleItems.variant'])
                    ->find($item->product_id);

                if (! $bundle instanceof Product || ! $bundle->isBundle()) {
                    return;
                }

                $item->update([
                    'metadata' => [
                        ...($item->metadata ?? []),
                        'bundle' => $bundle->bundleItems
                            ->map(fn (ProductBundleItem $bundleItem): array => self::componentSnapshot($bundleItem))
                            ->values()
                            ->all(),
                    ],
                ]);
            });
    }

    /**
     * @return array{name: string, sku: string, quantity: int, stockable_type: string, stockable_id: int}
     */
    public static function componentSnapshot(ProductBundleItem $item): array
    {
        $component = $item->component();
        $name = $item->product->name ?? '';

        if ($item->variant !== null) {
            $name = trim($name.' / '.$item->variant->name, ' /');
        }

        return [
            'name' => $name,
            'sku' => (string) ($component->sku ?? $item->product?->sku ?? ''),
            'quantity' => $item->quantity,
            'stockable_type' => $component?->getMorphClass() ?? (new Product)->getMorphClass(),
            'stockable_id' => (int) ($item->product_variant_id ?? $item->product_id),
        ];
    }
}
