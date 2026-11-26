<?php

declare(strict_types=1);

namespace App\Sidebar\ProductSections;

use BackedEnum;
use Mckenziearts\Icons\Untitledui\Enums\Untitledui;
use Shopper\Core\Models\Contracts\Product;
use Shopper\Enum\ProductSectionGroup;
use Shopper\Navigation\Product\AbstractProductSection;

final class BundleSection extends AbstractProductSection
{
    public function name(): string
    {
        return __('backend.bundles.menu');
    }

    public function icon(): BackedEnum
    {
        return Untitledui::LayersThree;
    }

    public function group(): string
    {
        return ProductSectionGroup::Product->value;
    }

    public function order(): int
    {
        return 45;
    }

    public function permission(): string
    {
        return 'products.edit';
    }

    public function url(Product $product): string
    {
        return route('shopper.products.edit.bundle', ['product' => $product]);
    }

    public function visible(Product $product): bool
    {
        return $product->isStandard();
    }
}
