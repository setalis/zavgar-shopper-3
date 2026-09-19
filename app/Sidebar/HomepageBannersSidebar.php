<?php

declare(strict_types=1);

namespace App\Sidebar;

use App\Enums\HomepageBannerPermission;
use App\Enums\MenuItemPermission;
use App\Enums\NewsPermission;
use Shopper\Sidebar\AbstractAdminSidebar;
use Shopper\Sidebar\Contracts\Builder\Group;
use Shopper\Sidebar\Contracts\Builder\Item;
use Shopper\Sidebar\Contracts\Builder\Menu;

final class HomepageBannersSidebar extends AbstractAdminSidebar
{
    public function extendWith(Menu $menu): Menu
    {
        $menu->group(__('backend.banners.menu_group'), function (Group $group): void {
            $group->weight(2);
            $group->setAuthorized();
            $group->collapsible();

            $group->item(__('backend.banners.menu'), function (Item $item): void {
                $item->weight(1);
                $item->setAuthorized($this->canBrowseHomepageBanners());
                $item->useSpa();
                $item->route('shopper.banners.index');
                $item->setIcon('phosphor-squares-four');
            });

            $group->item(__('backend.banners.promo_menu'), function (Item $item): void {
                $item->weight(2);
                $item->setAuthorized($this->canBrowseHomepageBanners());
                $item->useSpa();
                $item->route('shopper.promo-banners.index');
                $item->setIcon('phosphor-rectangle');
            });

            $group->item(__('backend.menu.menu'), function (Item $item): void {
                $item->weight(3);
                $item->setAuthorized($this->canBrowseMenuItems());
                $item->useSpa();
                $item->route('shopper.menu.index');
                $item->setIcon('phosphor-list');
            });

            $group->item(__('backend.news.menu'), function (Item $item): void {
                $item->weight(4);
                $item->setAuthorized($this->canBrowseNews());
                $item->useSpa();
                $item->route('shopper.news.index');
                $item->setIcon('phosphor-newspaper');
            });
        });

        return $menu;
    }

    private function canBrowseHomepageBanners(): bool
    {
        return $this->hasPermissionName(HomepageBannerPermission::Browse->value);
    }

    private function canBrowseMenuItems(): bool
    {
        return $this->hasPermissionName(MenuItemPermission::Browse->value);
    }

    private function canBrowseNews(): bool
    {
        return $this->hasPermissionName(NewsPermission::Browse->value);
    }

    private function hasPermissionName(string $name): bool
    {
        if ($this->user === null || ! method_exists($this->user, 'getAllPermissions')) {
            return false;
        }

        return (bool) $this->user->getAllPermissions()->contains(
            fn (object $permission): bool => $permission->name === $name,
        );
    }
}
