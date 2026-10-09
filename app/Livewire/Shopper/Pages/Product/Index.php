<?php

declare(strict_types=1);

namespace App\Livewire\Shopper\Pages\Product;

use Filament\Actions\DeleteBulkAction;
use Filament\Notifications\Notification;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Collection;
use Mckenziearts\Icons\Untitledui\Enums\Untitledui;
use Shopper\Core\Events\Products\ProductDeleted;
use Shopper\Core\Models\Contracts\Product;
use Shopper\Livewire\Pages\Product\Index as ShopperIndex;

final class Index extends ShopperIndex
{
    public function table(Table $table): Table
    {
        $canDelete = shopper()->auth()->user()?->can('products.delete') ?? false;

        return parent::table($table)
            ->groupedBulkActions([
                DeleteBulkAction::make()
                    ->label(__('shopper::forms.actions.delete'))
                    ->icon(Untitledui::Trash03)
                    ->color('danger')
                    ->requiresConfirmation()
                    ->modalHeading(__('backend.products.delete_bulk_heading'))
                    ->modalDescription(__('backend.products.delete_bulk_description'))
                    ->authorize('products.delete')
                    ->visible($canDelete)
                    ->action(function (Collection $records): void {
                        $records->each(function (Product $record): void {
                            event(new ProductDeleted($record));

                            $record->delete();
                        });

                        Notification::make()
                            ->title(__('backend.products.deleted_bulk', ['count' => $records->count()]))
                            ->success()
                            ->send();
                    })
                    ->deselectRecordsAfterCompletion(),
            ]);
    }
}
