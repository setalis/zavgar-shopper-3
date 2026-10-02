<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Enums\ProductImportRowOutcome;
use App\Import\ProductImportRow;
use App\Import\RoutesProductImportRow;
use Illuminate\Bus\Batchable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\DB;
use Shopper\Core\Models\ProductImport;
use Throwable;

final class ImportProductsChunkJob implements ShouldQueue
{
    use Batchable;
    use Queueable;

    /**
     * @param  list<ProductImportRow>  $rows
     */
    public function __construct(
        public int $importId,
        public array $rows,
    ) {}

    public function handle(RoutesProductImportRow $router): void
    {
        if ($this->batch()?->cancelled()) {
            return;
        }

        $counts = array_fill_keys(array_column(ProductImportRowOutcome::cases(), 'value'), 0);
        $errors = [];

        foreach ($this->rows as $row) {
            try {
                $counts[$router->route($row, $this->importId)->value]++;
            } catch (Throwable $e) {
                $errors[] = ['handle' => $row->sku ?? $row->product->handle, 'message' => $e->getMessage()];
            }
        }

        $increments = array_filter([
            'imported_count' => $counts[ProductImportRowOutcome::Updated->value],
            'queued_count' => $counts[ProductImportRowOutcome::Queued->value],
            'skipped_count' => $counts[ProductImportRowOutcome::Skipped->value],
        ]);

        if ($increments !== []) {
            ProductImport::query()->where('id', $this->importId)->incrementEach($increments);
        }

        if ($errors !== []) {
            DB::transaction(function () use ($errors): void {
                $import = ProductImport::query()->lockForUpdate()->find($this->importId);

                $import?->update([
                    'failed_count' => $import->failed_count + count($errors),
                    'errors' => [...($import->errors ?? []), ...$errors],
                ]);
            });
        }
    }
}
