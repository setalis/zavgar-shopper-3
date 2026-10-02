<?php

declare(strict_types=1);

namespace App\Livewire\Shopper\Pages\PendingProducts;

use App\Enums\PendingProductStatus;
use App\Jobs\CreatePendingProductsJob;
use App\Models\BlacklistedProduct;
use App\Models\PendingProduct;
use Filament\Actions\Action;
use Filament\Actions\BulkAction;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Notifications\Notification;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Mckenziearts\Icons\Untitledui\Enums\Untitledui;
use Shopper\Core\Models\ProductImport;
use Shopper\Livewire\Pages\AbstractPageComponent;
use Shopper\Traits\HandlesAuthorizationExceptions;

final class Index extends AbstractPageComponent implements HasActions, HasSchemas, HasTable
{
    use HandlesAuthorizationExceptions;
    use InteractsWithActions;
    use InteractsWithSchemas;
    use InteractsWithTable;

    public function mount(): void
    {
        $this->authorize('products.create');
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(PendingProduct::query()->with('import'))
            ->defaultSort('updated_at', 'desc')
            ->poll(fn (): ?string => PendingProduct::query()->where('status', PendingProductStatus::Processing)->exists() ? '5s' : null)
            ->columns([
                TextColumn::make('sku')
                    ->label(__('backend.product_imports.fields.sku'))
                    ->searchable()
                    ->sortable()
                    ->copyable(),
                TextColumn::make('name')
                    ->label(__('shopper::forms.label.name'))
                    ->searchable()
                    ->sortable()
                    ->wrap(),
                TextColumn::make('variants_count')
                    ->label(__('shopper::pages/products.import.review.variants'))
                    ->state(function (PendingProduct $record): int {
                        $product = $record->importRow()->product;

                        return $product->isStandard() ? 0 : count($product->variants);
                    })
                    ->alignEnd(),
                TextColumn::make('price')
                    ->label(__('shopper::forms.label.price'))
                    ->state(function (PendingProduct $record): ?string {
                        $price = $record->importRow()->product->variants[0]->price ?? null;

                        return $price === null ? null : shopper_money_format((int) round($price * 100));
                    })
                    ->placeholder('—')
                    ->alignEnd(),
                TextColumn::make('status')
                    ->label(__('backend.pending_products.status_label'))
                    ->badge(),
                TextColumn::make('error')
                    ->label(__('backend.pending_products.error'))
                    ->color('danger')
                    ->limit(80)
                    ->tooltip(fn (PendingProduct $record): ?string => $record->error)
                    ->placeholder('—'),
                TextColumn::make('updated_at')
                    ->label(__('backend.pending_products.imported_at'))
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label(__('backend.pending_products.status_label'))
                    ->options(PendingProductStatus::class),
                SelectFilter::make('product_import_id')
                    ->label(__('backend.pending_products.import'))
                    ->relationship(
                        'import',
                        'created_at',
                        fn (Builder $query): Builder => $query->whereIn('id', PendingProduct::query()->select('product_import_id')),
                    )
                    ->getOptionLabelFromRecordUsing(
                        fn (ProductImport $record): string => $record->created_at?->format('d.m.Y H:i') ?? "#{$record->id}",
                    ),
            ])
            ->recordActions([
                Action::make('create')
                    ->label(__('backend.pending_products.actions.create'))
                    ->icon(Untitledui::Plus)
                    ->iconButton()
                    ->color('success')
                    ->visible(fn (PendingProduct $record): bool => $record->status !== PendingProductStatus::Processing)
                    ->authorize('products.create')
                    ->action(fn (PendingProduct $record) => $this->createProducts(new Collection([$record]))),
                Action::make('blacklist')
                    ->label(__('backend.pending_products.actions.blacklist'))
                    ->icon(Untitledui::SlashCircle01)
                    ->iconButton()
                    ->color('warning')
                    ->requiresConfirmation()
                    ->modalDescription(__('backend.pending_products.blacklist_confirmation'))
                    ->visible(fn (PendingProduct $record): bool => $record->status !== PendingProductStatus::Processing)
                    ->authorize('products.create')
                    ->action(fn (PendingProduct $record) => $this->blacklist(new Collection([$record]))),
                Action::make('delete')
                    ->label(__('shopper::forms.actions.delete'))
                    ->icon(Untitledui::Trash03)
                    ->iconButton()
                    ->color('danger')
                    ->requiresConfirmation()
                    ->visible(fn (PendingProduct $record): bool => $record->status !== PendingProductStatus::Processing)
                    ->authorize('products.create')
                    ->action(fn (PendingProduct $record) => $this->deleteEntries(new Collection([$record]))),
            ])
            ->groupedBulkActions([
                BulkAction::make('create')
                    ->label(__('backend.pending_products.actions.create'))
                    ->icon(Untitledui::Plus)
                    ->color('success')
                    ->authorize('products.create')
                    ->action(fn (Collection $records) => $this->createProducts($records))
                    ->deselectRecordsAfterCompletion(),
                BulkAction::make('blacklist')
                    ->label(__('backend.pending_products.actions.blacklist'))
                    ->icon(Untitledui::SlashCircle01)
                    ->color('warning')
                    ->requiresConfirmation()
                    ->modalDescription(__('backend.pending_products.blacklist_confirmation'))
                    ->authorize('products.create')
                    ->action(fn (Collection $records) => $this->blacklist($records))
                    ->deselectRecordsAfterCompletion(),
                BulkAction::make('delete')
                    ->label(__('shopper::forms.actions.delete'))
                    ->icon(Untitledui::Trash03)
                    ->color('danger')
                    ->requiresConfirmation()
                    ->authorize('products.create')
                    ->action(fn (Collection $records) => $this->deleteEntries($records))
                    ->deselectRecordsAfterCompletion(),
            ])
            ->emptyStateHeading(__('backend.pending_products.empty'))
            ->emptyStateIcon(Untitledui::CheckVerified02);
    }

    public function render(): View
    {
        return view('livewire.shopper.pages.pending-products.index')
            ->title(__('backend.pending_products.menu'));
    }

    /**
     * @param  Collection<int, PendingProduct>  $records
     */
    private function createProducts(Collection $records): void
    {
        $ids = $this->actionable($records)->pluck('id')->all();

        if ($ids === []) {
            return;
        }

        PendingProduct::query()->whereIn('id', $ids)->update([
            'status' => PendingProductStatus::Processing,
            'error' => null,
        ]);

        CreatePendingProductsJob::dispatch($ids);

        Notification::make()
            ->title(__('backend.pending_products.create_started', ['count' => count($ids)]))
            ->success()
            ->send();
    }

    /**
     * @param  Collection<int, PendingProduct>  $records
     */
    private function blacklist(Collection $records): void
    {
        $records = $this->actionable($records);

        foreach ($records as $record) {
            BlacklistedProduct::query()->firstOrCreate(
                ['sku' => $record->sku],
                ['name' => $record->name, 'user_id' => auth()->id()],
            );

            $record->delete();
        }

        Notification::make()
            ->title(__('backend.pending_products.blacklisted', ['count' => $records->count()]))
            ->success()
            ->send();
    }

    /**
     * @param  Collection<int, PendingProduct>  $records
     */
    private function deleteEntries(Collection $records): void
    {
        $records = $this->actionable($records);

        PendingProduct::query()->whereIn('id', $records->pluck('id'))->delete();

        Notification::make()
            ->title(__('backend.pending_products.deleted', ['count' => $records->count()]))
            ->success()
            ->send();
    }

    /**
     * @param  Collection<int, PendingProduct>  $records
     * @return Collection<int, PendingProduct>
     */
    private function actionable(Collection $records): Collection
    {
        return $records->reject(fn (PendingProduct $record): bool => $record->status === PendingProductStatus::Processing);
    }
}
