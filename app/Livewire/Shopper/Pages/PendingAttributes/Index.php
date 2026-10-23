<?php

declare(strict_types=1);

namespace App\Livewire\Shopper\Pages\PendingAttributes;

use App\Enums\PendingAttributeStatus;
use App\Import\AttributeImportException;
use App\Import\RoutesAttributeImportRow;
use App\Models\PendingAttribute;
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
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;
use Mckenziearts\Icons\Untitledui\Enums\Untitledui;
use Shopper\Core\Enum\FieldType;
use Shopper\Traits\HandlesAuthorizationExceptions;
use Throwable;

final class Index extends Component implements HasActions, HasSchemas, HasTable
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
        $canCreate = shopper()->auth()->user()?->can('attributes.create') ?? false;

        return $table
            ->query(PendingAttribute::query())
            ->defaultSort('updated_at', 'desc')
            ->poll(fn (): ?string => PendingAttribute::query()->where('status', PendingAttributeStatus::Processing)->exists() ? '5s' : null)
            ->columns([
                TextColumn::make('name')
                    ->label(__('shopper::forms.label.name'))
                    ->searchable()
                    ->sortable()
                    ->wrap(),
                TextColumn::make('slug')
                    ->label(__('shopper::forms.label.slug'))
                    ->searchable()
                    ->sortable()
                    ->copyable(),
                TextColumn::make('type')
                    ->label(__('shopper::forms.label.type'))
                    ->formatStateUsing(function (FieldType|string|null $state): string {
                        $type = $state instanceof FieldType ? $state : FieldType::tryFrom((string) $state);

                        return $type instanceof FieldType ? (string) $type->getLabel() : (string) $state;
                    }),
                TextColumn::make('values_count')
                    ->label(__('backend.pending_attributes.values'))
                    ->state(function (PendingAttribute $record): int {
                        try {
                            return count($record->importRow()->values);
                        } catch (AttributeImportException) {
                            return 0;
                        }
                    })
                    ->alignEnd(),
                TextColumn::make('status')
                    ->label(__('backend.pending_products.status_label'))
                    ->badge(),
                TextColumn::make('error')
                    ->label(__('backend.pending_products.error'))
                    ->color('danger')
                    ->limit(80)
                    ->tooltip(fn (PendingAttribute $record): ?string => $record->error)
                    ->placeholder('—'),
                TextColumn::make('updated_at')
                    ->label(__('backend.pending_products.imported_at'))
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label(__('backend.pending_products.status_label'))
                    ->options(PendingAttributeStatus::class),
            ])
            ->recordActions([
                Action::make('create')
                    ->label(__('backend.pending_products.actions.create'))
                    ->icon(Untitledui::Plus)
                    ->iconButton()
                    ->color('success')
                    ->visible(fn (PendingAttribute $record): bool => $canCreate && $record->status !== PendingAttributeStatus::Processing)
                    ->authorize('attributes.create')
                    ->action(fn (PendingAttribute $record) => $this->createAttributes(new Collection([$record]))),
                Action::make('delete')
                    ->label(__('shopper::forms.actions.delete'))
                    ->icon(Untitledui::Trash03)
                    ->iconButton()
                    ->color('danger')
                    ->requiresConfirmation()
                    ->visible(fn (PendingAttribute $record): bool => $canCreate && $record->status !== PendingAttributeStatus::Processing)
                    ->authorize('attributes.create')
                    ->action(fn (PendingAttribute $record) => $this->deleteAttributes(new Collection([$record]))),
            ])
            ->groupedBulkActions([
                BulkAction::make('create')
                    ->label(__('backend.pending_products.actions.create'))
                    ->icon(Untitledui::Plus)
                    ->color('success')
                    ->authorize('attributes.create')
                    ->visible($canCreate)
                    ->action(fn (Collection $records) => $this->createAttributes($records))
                    ->deselectRecordsAfterCompletion(),
                BulkAction::make('delete')
                    ->label(__('shopper::forms.actions.delete'))
                    ->icon(Untitledui::Trash03)
                    ->color('danger')
                    ->requiresConfirmation()
                    ->authorize('attributes.create')
                    ->visible($canCreate)
                    ->action(fn (Collection $records) => $this->deleteAttributes($records))
                    ->deselectRecordsAfterCompletion(),
            ])
            ->emptyStateHeading(__('backend.pending_attributes.empty'))
            ->emptyStateIcon(Untitledui::CheckVerified02);
    }

    public function render(): View
    {
        return view('livewire.shopper.pages.pending-attributes.index');
    }

    /**
     * @param  Collection<int, PendingAttribute>  $records
     */
    private function createAttributes(Collection $records): void
    {
        $records = $this->actionable($records);
        $router = resolve(RoutesAttributeImportRow::class);
        $created = 0;
        $failed = 0;

        foreach ($records as $record) {
            $record->update([
                'status' => PendingAttributeStatus::Processing,
                'error' => null,
            ]);

            try {
                $router->create($record);
                $created++;
            } catch (Throwable $exception) {
                $record->update([
                    'status' => PendingAttributeStatus::Failed,
                    'error' => $exception instanceof AttributeImportException
                        ? $exception->getMessage()
                        : __('backend.attribute_imports.invalid_payload'),
                ]);

                if (! $exception instanceof AttributeImportException) {
                    report($exception);
                }

                $failed++;
            }
        }

        if ($created > 0) {
            Notification::make()
                ->title(__('backend.pending_attributes.created', ['count' => $created]))
                ->success()
                ->send();
        }

        if ($failed > 0) {
            Notification::make()
                ->title(__('backend.pending_attributes.create_failed', ['count' => $failed]))
                ->danger()
                ->send();
        }
    }

    /**
     * @param  Collection<int, PendingAttribute>  $records
     */
    private function deleteAttributes(Collection $records): void
    {
        $records = $this->actionable($records);

        PendingAttribute::query()->whereIn('id', $records->pluck('id'))->delete();

        Notification::make()
            ->title(__('backend.pending_attributes.deleted', ['count' => $records->count()]))
            ->success()
            ->send();
    }

    /**
     * @param  Collection<int, PendingAttribute>  $records
     * @return Collection<int, PendingAttribute>
     */
    private function actionable(Collection $records): Collection
    {
        return $records->reject(fn (PendingAttribute $record): bool => $record->status === PendingAttributeStatus::Processing);
    }
}
