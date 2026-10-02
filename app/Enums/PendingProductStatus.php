<?php

declare(strict_types=1);

namespace App\Enums;

use BackedEnum;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;
use Illuminate\Contracts\Support\Htmlable;

enum PendingProductStatus: string implements HasColor, HasIcon, HasLabel
{
    case Pending = 'pending';
    case Processing = 'processing';
    case Failed = 'failed';

    public function getLabel(): string|Htmlable|null
    {
        return __("backend.pending_products.status.{$this->value}");
    }

    /**
     * @return string|array<string>|null
     */
    public function getColor(): string|array|null
    {
        return match ($this) {
            self::Pending => 'warning',
            self::Processing => 'info',
            self::Failed => 'danger',
        };
    }

    public function getIcon(): string|BackedEnum|Htmlable|null
    {
        return match ($this) {
            self::Pending => 'phosphor-clock',
            self::Processing => 'phosphor-spinner',
            self::Failed => 'phosphor-x-circle',
        };
    }
}
