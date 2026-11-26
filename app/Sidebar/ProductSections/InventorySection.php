<?php

declare(strict_types=1);

namespace App\Sidebar\ProductSections;

use App\Models\Product as AppProduct;
use BackedEnum;
use Mckenziearts\Icons\Untitledui\Enums\Untitledui;
use Shopper\Core\Models\Contracts\Product;
use Shopper\Enum\ProductSectionGroup;
use Shopper\Navigation\Product\AbstractProductSection;

/**
 * Shopper's inventory section, hidden for bundles: their stock is derived from the components.
 */
final class InventorySection extends AbstractProductSection
{
    public function name(): string
    {
        return __('shopper::pages/products.stock_inventory_heading');
    }

    public function icon(): BackedEnum
    {
        return Untitledui::Package;
    }

    public function group(): string
    {
        return ProductSectionGroup::Inventory->value;
    }

    public function order(): int
    {
        return 10;
    }

    public function url(Product $product): string
    {
        return route('shopper.products.edit.inventory', ['product' => $product]);
    }

    public function visible(Product $product): bool
    {
        return ! ($product instanceof AppProduct && $product->isBundle());
    }
}
