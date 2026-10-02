<?php

declare(strict_types=1);

namespace App\Livewire\Shopper\SlideOvers;

use App\Support\MapVariantOptions;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Livewire\Attributes\Computed;
use Shopper\Livewire\SlideOvers\UpdateVariant as BaseUpdateVariant;

final class UpdateVariant extends BaseUpdateVariant
{
    public function mount(): void
    {
        parent::mount();

        if (isset($this->data['values'])) {
            $this->data['values'] = Arr::only($this->data['values'], $this->options->pluck('id')->all());
        }
    }

    /**
     * @return Collection<int, mixed>
     */
    #[Computed]
    public function options(): Collection
    {
        return collect(MapVariantOptions::generate($this->product));
    }
}
