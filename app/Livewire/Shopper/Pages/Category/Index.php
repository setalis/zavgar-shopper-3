<?php

declare(strict_types=1);

namespace App\Livewire\Shopper\Pages\Category;

use Filament\Actions\Action;
use Filament\Tables\Table;
use Mckenziearts\Icons\Untitledui\Enums\Untitledui;
use Shopper\Core\Models\Contracts\Category;
use Shopper\Livewire\Pages\Category\Index as ShopperIndex;

final class Index extends ShopperIndex
{
    public function table(Table $table): Table
    {
        return parent::table($table)
            ->pushRecordActions([
                Action::make('filters')
                    ->label(__('backend.category_filters.action'))
                    ->icon(Untitledui::FilterLines)
                    ->iconButton()
                    ->url(fn (Category $record): string => route('shopper.categories.filters', $record))
                    ->extraAttributes(['wire:navigate' => true])
                    ->authorize('categories.edit')
                    ->visible($this->getUser()->can('categories.edit')),
            ]);
    }
}
