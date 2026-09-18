<?php

declare(strict_types=1);

namespace App\Enums;

enum MenuItemPermission: string
{
    case Browse = 'menu_items.browse';
    case Read = 'menu_items.read';
    case Edit = 'menu_items.edit';
    case Create = 'menu_items.create';
    case Delete = 'menu_items.delete';

    /**
     * @return list<string>
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
