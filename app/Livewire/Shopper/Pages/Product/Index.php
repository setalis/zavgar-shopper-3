<?php

declare(strict_types=1);

namespace App\Livewire\Shopper\Pages\Product;

use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
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

        return $this->withCopyAction(parent::table($table))
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

    private function withCopyAction(Table $table): Table
    {
        $recordActions = $table->getRecordActions();
        $group = $recordActions[0] ?? null;

        if (! $group instanceof ActionGroup) {
            return $table->pushRecordActions([$this->copyProductAction()]);
        }

        $actions = $group->getActions();
        $delete = array_pop($actions);
        $actions[] = $this->copyProductAction();

        if ($delete instanceof Action) {
            $actions[] = $delete;
        }

        $group->actions($actions);

        // Re-register the group so the table caches the new action.
        return $table->recordActions([$group]);
    }

    private function copyProductAction(): Action
    {
        $canCreate = shopper()->auth()->user()?->can('products.create') ?? false;

        return Action::make('copy')
            ->label(__('backend.products.copy_to_draft'))
            ->icon(Untitledui::Copy)
            ->authorize('products.create')
            ->visible($canCreate)
            ->action(function (Product $record): void {
                $this->dispatch('openPanel', 'shopper-slide-overs.add-product', [
                    'productId' => $record->id,
                ]);
            });
    }
}
