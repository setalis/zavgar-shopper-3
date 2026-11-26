<?php

declare(strict_types=1);

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\DB;
use Shopper\Core\Events\Orders\OrderCancelled;
use Shopper\Core\Models\Contracts\Stockable;

/**
 * Shopper restocks only the ordered purchasable itself; a bundle line reserved its components instead.
 * Reservations are stamped `released_at` under a row lock, so overlapping with Shopper's own restock
 * (a component also bought as a separate line) never returns stock twice.
 */
final class RestoreBundleComponentStock implements ShouldQueue
{
    public function handle(OrderCancelled $event): void
    {
        $order = $event->order->load('items');

        $components = $order->items
            ->flatMap(fn (Model $item): array => $item->metadata['bundle'] ?? [])
            ->unique(fn (array $component): string => $component['stockable_type'].':'.$component['stockable_id']);

        foreach ($components as $component) {
            $class = Relation::getMorphedModel($component['stockable_type']) ?? $component['stockable_type'];

            if (! class_exists($class)) {
                continue;
            }

            $stockable = $class::query()->find($component['stockable_id']);

            if (! $stockable instanceof Stockable) {
                continue;
            }

            DB::transaction(function () use ($order, $stockable): void {
                $reservations = $stockable->inventoryHistories()
                    ->where('reference_type', $order->getMorphClass())
                    ->where('reference_id', $order->getKey())
                    ->where('quantity', '<', 0)
                    ->whereNull('released_at')
                    ->lockForUpdate()
                    ->get();

                foreach ($reservations as $reservation) {
                    $stockable->mutateStock(
                        inventoryId: $reservation->inventory_id,
                        quantity: abs($reservation->quantity),
                        oldQuantity: $stockable->stockInventory($reservation->inventory_id),
                        event: __('shopper-core::status.stock.cancelled'),
                        reference: $order,
                    );

                    $reservation->updateQuietly(['released_at' => now()]);
                }
            });
        }
    }
}
