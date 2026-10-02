<?php

declare(strict_types=1);

namespace App\Listeners;

use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Support\Icons\Heroicon;
use Shopper\Concerns\ResolvesAdministrators;
use Shopper\Core\Events\Products\ProductImportCompleted;

final class NotifyQueuedProductImports
{
    use ResolvesAdministrators;

    public function handle(ProductImportCompleted $event): void
    {
        $import = $event->import->refresh();

        if ((int) $import->queued_count === 0 && (int) $import->skipped_count === 0) {
            return;
        }

        $recipients = $this->administrators();

        if ($recipients->isEmpty()) {
            return;
        }

        Notification::make()
            ->title(__('backend.pending_products.notification.title'))
            ->body(__('backend.pending_products.notification.body', [
                'queued' => $import->queued_count,
                'skipped' => $import->skipped_count,
            ]))
            ->icon(Heroicon::OutlinedQueueList)
            ->info()
            ->actions([
                Action::make('view')
                    ->label(__('backend.pending_products.notification.view'))
                    ->url(route('shopper.products.pending.index'))
                    ->markAsRead(),
            ])
            ->sendToDatabase($recipients, isEventDispatched: true);
    }
}
