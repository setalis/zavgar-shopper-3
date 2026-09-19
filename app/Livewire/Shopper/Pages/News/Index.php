<?php

declare(strict_types=1);

namespace App\Livewire\Shopper\Pages\News;

use App\Enums\NewsPermission;
use App\Models\NewsArticle;
use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Actions\DeleteBulkAction;
use Filament\Notifications\Notification;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Mckenziearts\Icons\Untitledui\Enums\Untitledui;
use Shopper\Livewire\Pages\AbstractPageComponent;
use Shopper\Traits\HandlesAuthorizationExceptions;
use Throwable;

final class Index extends AbstractPageComponent implements HasActions, HasSchemas, HasTable
{
    use HandlesAuthorizationExceptions;
    use InteractsWithActions;
    use InteractsWithSchemas;
    use InteractsWithTable;

    public function mount(): void
    {
        $this->authorize(NewsPermission::Browse->value);
    }

    public function exception(Throwable $e, callable $stopPropagation): void
    {
        if (! $e instanceof AuthorizationException) {
            return;
        }

        Notification::make()
            ->title(__('shopper::notifications.unauthorized.title'))
            ->body($e->getMessage() ?: __('shopper::notifications.unauthorized.body'))
            ->warning()
            ->send();

        $stopPropagation();
    }

    public function table(Table $table): Table
    {
        $user = shopper()->auth()->user();
        $canEdit = $user?->can(NewsPermission::Edit) ?? false;
        $canDelete = $user?->can(NewsPermission::Delete) ?? false;

        return $table
            ->query(NewsArticle::query()->orderByDesc('published_at'))
            ->columns([
                SpatieMediaLibraryImageColumn::make('preview')
                    ->collection(NewsArticle::MEDIA_THUMBNAIL)
                    ->circular()
                    ->defaultImageUrl(shopper_fallback_url())
                    ->grow(false),
                TextColumn::make('title')
                    ->label(__('backend.news.title'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('published_at')
                    ->label(__('backend.news.published_at'))
                    ->dateTime()
                    ->sortable()
                    ->placeholder(__('backend.news.unpublished')),
                ToggleColumn::make('is_enabled')
                    ->label(__('shopper::forms.label.visibility'))
                    ->disabled(fn (): bool => ! $canEdit),
            ])
            ->defaultSort('published_at', 'desc')
            ->recordActions([
                Action::make('edit')
                    ->label(__('shopper::forms.actions.edit'))
                    ->icon(Untitledui::Edit03)
                    ->iconButton()
                    ->url(
                        fn (NewsArticle $record): string => route('shopper.news.edit', ['article' => $record]),
                    )
                    ->extraAttributes(['wire:navigate' => true])
                    ->authorize(NewsPermission::Edit)
                    ->visible($canEdit),
                Action::make('delete')
                    ->label(__('shopper::forms.actions.delete'))
                    ->icon(Untitledui::Trash03)
                    ->iconButton()
                    ->modalIcon(Untitledui::Trash03)
                    ->color('danger')
                    ->requiresConfirmation()
                    ->action(function (NewsArticle $record): void {
                        $record->delete();

                        Notification::make()
                            ->title(__('backend.news.deleted'))
                            ->success()
                            ->send();
                    })
                    ->authorize(NewsPermission::Delete)
                    ->visible($canDelete),
            ])
            ->groupedBulkActions([
                DeleteBulkAction::make()
                    ->label(__('shopper::forms.actions.delete'))
                    ->icon(Untitledui::Trash03)
                    ->requiresConfirmation()
                    ->action(function (Collection $records): void {
                        $records->each->delete();

                        Notification::make()
                            ->title(__('backend.news.deleted'))
                            ->success()
                            ->send();
                    })
                    ->authorize(NewsPermission::Delete)
                    ->visible($canDelete)
                    ->deselectRecordsAfterCompletion(),
            ])
            ->emptyStateHeading(__('backend.news.empty'));
    }

    public function render(): View
    {
        return view('livewire.shopper.pages.news.index')
            ->title(__('backend.news.menu'));
    }
}
