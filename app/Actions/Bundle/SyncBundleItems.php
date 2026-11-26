<?php

declare(strict_types=1);

namespace App\Actions\Bundle;

use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Shopper\Core\Enum\ProductType;

final readonly class SyncBundleItems
{
    /**
     * @param  list<array{product_id: int|string|null, product_variant_id?: int|string|null, quantity?: int|string|null}>  $items
     *
     * @throws ValidationException
     */
    public function handle(Product $bundle, bool $isBundle, array $items, string $errorKey = 'items'): void
    {
        if (! $isBundle) {
            DB::transaction(function () use ($bundle): void {
                $bundle->bundleItems()->delete();
                $bundle->update(['is_bundle' => false]);
            });

            return;
        }

        if (! $bundle->isStandard()) {
            throw ValidationException::withMessages([
                'is_bundle' => __('backend.bundles.errors.standard_only'),
            ]);
        }

        $rows = $this->validate($bundle, $items, $errorKey);

        DB::transaction(function () use ($bundle, $rows): void {
            $bundle->update(['is_bundle' => true]);
            $bundle->bundleItems()->delete();
            $bundle->bundleItems()->createMany($rows);
        });

        $bundle->unsetRelation('bundleItems');
    }

    /**
     * @param  list<array{product_id: int|string|null, product_variant_id?: int|string|null, quantity?: int|string|null}>  $items
     * @return list<array{product_id: int, product_variant_id: ?int, quantity: int, position: int}>
     *
     * @throws ValidationException
     */
    private function validate(Product $bundle, array $items, string $errorKey): array
    {
        if ($items === []) {
            throw ValidationException::withMessages([
                $errorKey => __('backend.bundles.errors.empty'),
            ]);
        }

        $products = Product::query()
            ->whereIn('id', array_filter(array_map(fn (array $item): int => (int) $item['product_id'], $items)))
            ->get()
            ->keyBy('id');

        $variants = ProductVariant::query()
            ->whereIn('id', array_filter(array_map(fn (array $item): int => (int) ($item['product_variant_id'] ?? 0), $items)))
            ->get()
            ->keyBy('id');

        $rows = [];
        $seen = [];

        foreach (array_values($items) as $position => $item) {
            $key = "{$errorKey}.{$position}";
            $product = $products->get((int) $item['product_id']);
            $variantId = filled($item['product_variant_id'] ?? null) ? (int) $item['product_variant_id'] : null;
            $quantity = (int) ($item['quantity'] ?? 1);

            $error = match (true) {
                ! $product instanceof Product => __('backend.bundles.errors.product_missing'),
                $product->id === $bundle->id => __('backend.bundles.errors.self'),
                $product->isBundle() => __('backend.bundles.errors.nested'),
                ! in_array($product->type, [ProductType::Standard, ProductType::Variant], true) => __('backend.bundles.errors.type'),
                $product->type === ProductType::Variant && $variantId === null => __('backend.bundles.errors.variant_required'),
                $product->type === ProductType::Standard && $variantId !== null => __('backend.bundles.errors.variant_foreign'),
                $variantId !== null && $variants->get($variantId)?->product_id !== $product->id => __('backend.bundles.errors.variant_foreign'),
                $quantity < 1 => __('backend.bundles.errors.quantity'),
                isset($seen["{$product->id}:{$variantId}"]) => __('backend.bundles.errors.duplicate'),
                default => null,
            };

            if ($error !== null) {
                throw ValidationException::withMessages([$key => $error]);
            }

            $seen["{$product->id}:{$variantId}"] = true;

            $rows[] = [
                'product_id' => $product->id,
                'product_variant_id' => $variantId,
                'quantity' => $quantity,
                'position' => $position,
            ];
        }

        return $rows;
    }
}
