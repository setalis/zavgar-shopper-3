<?php

declare(strict_types=1);

namespace App\Enums;

enum NewsPermission: string
{
    case Browse = 'news.browse';
    case Read = 'news.read';
    case Edit = 'news.edit';
    case Create = 'news.create';
    case Delete = 'news.delete';

    /**
     * @return list<string>
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
