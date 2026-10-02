<?php

declare(strict_types=1);

namespace App\Sidebar;

use App\Models\PendingProduct;
use Shopper\Sidebar\AbstractAdminSidebar;
use Shopper\Sidebar\Contracts\Builder\Group;
use Shopper\Sidebar\Contracts\Builder\Item;
use Shopper\Sidebar\Contracts\Builder\Menu;

final class ProductImportSidebar extends AbstractAdminSidebar
{
    public function extendWith(Menu $menu): Menu
    {
        $canManageImports = (bool) $this->user?->can('products.create');

        $menu->group(__('shopper::layout.sidebar.catalog'), function (Group $group) use ($canManageImports): void {
            $group->item(__('backend.pending_products.menu'), function (Item $item) use ($canManageImports): void {
                $item->weight(5);
                $item->setAuthorized($canManageImports);
                $item->useSpa();
                $item->route('shopper.products.pending.index');
                $item->setIcon('phosphor-queue');

                $count = $canManageImports ? PendingProduct::query()->count() : 0;

                if ($count > 0) {
                    $item->badge($count)->color('warning');
                }
            });

            $group->item(__('backend.product_blacklist.menu'), function (Item $item) use ($canManageImports): void {
                $item->weight(6);
                $item->setAuthorized($canManageImports);
                $item->useSpa();
                $item->route('shopper.products.blacklist.index');
                $item->setIcon('phosphor-prohibit');
            });
        });

        return $menu;
    }
}
