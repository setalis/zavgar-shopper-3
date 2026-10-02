<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Import\ImportsProductRow;
use App\Import\ProductImportRow;
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

    public function handle(ImportsProductRow $importer): void
    {
        if ($this->batch()?->cancelled()) {
            return;
        }

        $imported = 0;
        $errors = [];

        foreach ($this->rows as $row) {
            try {
                $importer->import($row);
                $imported++;
            } catch (Throwable $e) {
                $errors[] = ['handle' => $row->product->handle, 'message' => $e->getMessage()];
            }
        }

        if ($imported > 0) {
            ProductImport::query()->where('id', $this->importId)->increment('imported_count', $imported);
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
