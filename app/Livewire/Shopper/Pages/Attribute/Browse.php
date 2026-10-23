<?php

declare(strict_types=1);

namespace App\Livewire\Shopper\Pages\Attribute;

use Livewire\Attributes\On;
use Shopper\Livewire\Pages\Attribute\Browse as BaseBrowse;

final class Browse extends BaseBrowse
{
    #[On('attributes.import.finished')]
    public function refreshAfterImport(): void {}
}
