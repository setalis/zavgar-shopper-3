<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Enums\PendingProductStatus;
use App\Import\ImportsProductRow;
use App\Import\RoutesProductImportRow;
use App\Models\PendingProduct;
use App\Models\Product;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Throwable;

final class CreatePendingProductsJob implements ShouldQueue
{
    use Queueable;

    /**
     * @param  list<int>  $pendingProductIds
     */
    public function __construct(
        public array $pendingProductIds,
    ) {}

    public function handle(RoutesProductImportRow $router, ImportsProductRow $importer): void
    {
        $pendingProducts = PendingProduct::query()
            ->whereIn('id', $this->pendingProductIds)
            ->where('status', PendingProductStatus::Processing)
            ->get();

        foreach ($pendingProducts as $pendingProduct) {
            try {
                $row = $pendingProduct->importRow();

                if (! $router->updateExisting($row)) {
                    $importer->import($row->withHandle($this->uniqueSlug($row->product->handle)));
                }

                $pendingProduct->delete();
            } catch (Throwable $e) {
                $pendingProduct->update([
                    'status' => PendingProductStatus::Failed,
                    'error' => $e->getMessage(),
                ]);
            }
        }
    }

    public function failed(?Throwable $exception): void
    {
        PendingProduct::query()
            ->whereIn('id', $this->pendingProductIds)
            ->where('status', PendingProductStatus::Processing)
            ->update([
                'status' => PendingProductStatus::Failed,
                'error' => $exception?->getMessage(),
            ]);
    }

    private function uniqueSlug(string $handle): string
    {
        $slug = $handle;
        $suffix = 2;

        while (Product::withTrashed()->where('slug', $slug)->exists()) {
            $slug = "{$handle}-{$suffix}";
            $suffix++;
        }

        return $slug;
    }
}
