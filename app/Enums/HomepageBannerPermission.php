<?php

declare(strict_types=1);

namespace App\Enums;

enum HomepageBannerPermission: string
{
    case Browse = 'homepage_banners.browse';
    case Read = 'homepage_banners.read';
    case Edit = 'homepage_banners.edit';
    case Create = 'homepage_banners.create';
    case Delete = 'homepage_banners.delete';

    /**
     * @return list<string>
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
