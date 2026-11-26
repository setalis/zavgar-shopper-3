<?php

declare(strict_types=1);

namespace App\Actions\Bundle;

use App\DTO\BundleComponentData;
use App\DTO\BundleCompositionData;
use App\Models\Product;
use App\Models\ProductBundleItem;
use App\Models\ProductVariant;
use Illuminate\Database\Eloquent\Model;
use Shopper\Core\Models\Price;

final readonly class BuildBundleComposition
{
    public function __construct(
        private ResolveBundleStock $resolveBundleStock,
    ) {}

    public function handle(Product $bundle): ?BundleCompositionData
    {
        if (! $bundle->isBundle()) {
            return null;
        }

        $currencyCode = current_currency();
        $prices = fn ($query) => $query->whereRelation('currency', 'code', $currencyCode);

        $bundle->setRelation('bundleItems', $bundle->bundleItems()
            ->withComponentStock()
            ->with([
                'product' => fn ($query) => $query->withStorefrontTranslations(),
                'product.media',
                'product.prices' => $prices,
                'variant.translations',
                'variant.values.attribute',
                'variant.media',
                'variant.prices' => $prices,
            ])
            ->get());

        $bundle->loadMissing(['prices' => $prices]);

        $items = $bundle->bundleItems
            ->map(fn (ProductBundleItem $item): BundleComponentData => $this->component($item))
            ->values()
            ->all();

        $componentsTotal = collect($items)->contains(fn (BundleComponentData $item): bool => $item->unitAmount === null)
            ? null
            : (int) collect($items)->sum(fn (BundleComponentData $item): int => $item->unitAmount * $item->quantity);

        $bundleAmount = $this->amount($bundle);
        $savings = $componentsTotal !== null && $bundleAmount !== null && $componentsTotal > $bundleAmount
            ? $componentsTotal - $bundleAmount
            : null;

        return new BundleCompositionData(
            items: $items,
            componentsTotal: $componentsTotal,
            bundleAmount: $bundleAmount,
            savings: $savings,
            stock: $this->resolveBundleStock->handle($bundle),
        );
    }

    /**
     * The lightweight composition shown under a bundle line in the cart.
     *
     * @return list<array{name: string, variant: ?string, quantity: int}>
     */
    public function contents(Product $bundle): array
    {
        if (! $bundle->isBundle()) {
            return [];
        }

        return $bundle->bundleItems()
            ->with([
                'product' => fn ($query) => $query->withStorefrontTranslations(),
                'variant.translations',
                'variant.values.attribute',
            ])
            ->get()
            ->map(fn (ProductBundleItem $item): array => [
                'name' => (string) $item->product?->localizeForStorefront()->name,
                'variant' => $item->variant?->localizeForStorefront()->name,
                'quantity' => $item->quantity,
            ])
            ->values()
            ->all();
    }

    private function component(ProductBundleItem $item): BundleComponentData
    {
        $product = $item->product;
        $variant = $item->variant;

        $product?->localizeForStorefront();
        $variant?->localizeForStorefront();

        return new BundleComponentData(
            productId: $item->product_id,
            variantId: $item->product_variant_id,
            name: (string) $product?->name,
            variantName: $variant?->name,
            slug: $product?->slug,
            sku: $variant->sku ?? $product?->sku,
            thumbnail: $variant?->thumbnail ?? $product?->thumbnail,
            quantity: $item->quantity,
            unitAmount: ($variant instanceof ProductVariant ? $this->amount($variant) : null)
                ?? ($product instanceof Product ? $this->amount($product) : null),
            isAvailable: $item->isAvailable(),
        );
    }

    private function amount(Model $priceable): ?int
    {
        $amount = $priceable->prices
            ->first(fn (Price $price): bool => $price->amount !== null)
            ?->amount;

        return $amount === null ? null : (int) $amount;
    }
}
