<?php

declare(strict_types=1);

namespace App\Livewire\Shopper\SlideOvers;

use App\Support\MapVariantOptions;
use Illuminate\Support\Collection;
use Livewire\Attributes\Computed;
use Shopper\Livewire\SlideOvers\AddVariant as BaseAddVariant;

final class AddVariant extends BaseAddVariant
{
    /**
     * @return Collection<int, mixed>
     */
    #[Computed]
    public function options(): Collection
    {
        return collect(MapVariantOptions::generate($this->product));
    }
}
