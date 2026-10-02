<?php

declare(strict_types=1);

namespace App\Livewire\Shopper\Pages\BlacklistedProducts;

use App\Models\BlacklistedProduct;
use App\Models\PendingProduct;
use Filament\Actions\Action;
use Filament\Actions\BulkAction;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Mckenziearts\Icons\Untitledui\Enums\Untitledui;
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
            ->query(BlacklistedProduct::query()->with('user'))
            ->defaultSort('created_at', 'desc')
            ->columns([
                TextColumn::make('sku')
                    ->label(__('backend.product_imports.fields.sku'))
                    ->searchable()
                    ->sortable()
                    ->copyable(),
                TextColumn::make('name')
                    ->label(__('shopper::forms.label.name'))
                    ->searchable()
                    ->placeholder('—')
                    ->wrap(),
                TextColumn::make('user.email')
                    ->label(__('backend.product_blacklist.added_by'))
                    ->placeholder('—'),
                TextColumn::make('created_at')
                    ->label(__('backend.product_blacklist.added_at'))
                    ->dateTime()
                    ->sortable(),
            ])
            ->headerActions([
                Action::make('add')
                    ->label(__('backend.product_blacklist.add'))
                    ->icon(Untitledui::Plus)
                    ->authorize('products.create')
                    ->schema([
                        TextInput::make('sku')
                            ->label(__('backend.product_imports.fields.sku'))
                            ->required()
                            ->maxLength(255)
                            ->unique(BlacklistedProduct::class, 'sku'),
                        TextInput::make('name')
                            ->label(__('shopper::forms.label.name'))
                            ->maxLength(255),
                    ])
                    ->action(function (array $data): void {
                        $sku = mb_trim($data['sku']);

                        BlacklistedProduct::create([
                            'sku' => $sku,
                            'name' => $data['name'] ?? null,
                            'user_id' => auth()->id(),
                        ]);

                        PendingProduct::query()->where('sku', $sku)->delete();

                        Notification::make()
                            ->title(__('backend.product_blacklist.added'))
                            ->success()
                            ->send();
                    }),
            ])
            ->recordActions([
                Action::make('remove')
                    ->label(__('backend.product_blacklist.remove'))
                    ->icon(Untitledui::Trash03)
                    ->iconButton()
                    ->color('danger')
                    ->requiresConfirmation()
                    ->authorize('products.create')
                    ->action(fn (BlacklistedProduct $record) => $this->remove(new Collection([$record]))),
            ])
            ->groupedBulkActions([
                BulkAction::make('remove')
                    ->label(__('backend.product_blacklist.remove'))
                    ->icon(Untitledui::Trash03)
                    ->color('danger')
                    ->requiresConfirmation()
                    ->authorize('products.create')
                    ->action(fn (Collection $records) => $this->remove($records))
                    ->deselectRecordsAfterCompletion(),
            ])
            ->emptyStateHeading(__('backend.product_blacklist.empty'))
            ->emptyStateIcon(Untitledui::SlashCircle01);
    }

    public function render(): View
    {
        return view('livewire.shopper.pages.blacklisted-products.index')
            ->title(__('backend.product_blacklist.menu'));
    }

    /**
     * @param  Collection<int, BlacklistedProduct>  $records
     */
    private function remove(Collection $records): void
    {
        BlacklistedProduct::query()->whereIn('id', $records->pluck('id'))->delete();

        Notification::make()
            ->title(__('backend.product_blacklist.removed', ['count' => $records->count()]))
            ->success()
            ->send();
    }
}
