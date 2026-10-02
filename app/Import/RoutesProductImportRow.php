<?php

declare(strict_types=1);

namespace App\Import;

use App\Enums\PendingProductStatus;
use App\Enums\ProductImportRowOutcome;
use App\Models\BlacklistedProduct;
use App\Models\PendingProduct;
use App\Models\Product;
use Shopper\Core\Exceptions\ProductImportException;

/**
 * Products are identified by SKU: existing ones are updated, new ones wait in the queue
 * for a manager, blacklisted SKUs are never touched.
 */
final class RoutesProductImportRow
{
    public function __construct(
        private ImportsProductRow $importer,
    ) {}

    /**
     * @throws ProductImportException
     */
    public function route(ProductImportRow $row, ?int $importId = null): ProductImportRowOutcome
    {
        if ($row->sku === null) {
            throw new ProductImportException(__('backend.pending_products.missing_sku'));
        }

        if (BlacklistedProduct::contains($row->sku)) {
            return ProductImportRowOutcome::Skipped;
        }

        if ($this->updateExisting($row)) {
            return ProductImportRowOutcome::Updated;
        }

        PendingProduct::query()->updateOrCreate(
            ['sku' => $row->sku],
            [
                ...PendingProduct::attributesFromImportRow($row),
                'product_import_id' => $importId,
                'status' => PendingProductStatus::Pending,
                'error' => null,
            ],
        );

        return ProductImportRowOutcome::Queued;
    }

    /**
     * Predicts the outcome for each SKU without writing anything.
     *
     * @param  list<string>  $skus
     * @return array<string, ProductImportRowOutcome>
     */
    public function outcomesFor(array $skus): array
    {
        $outcomes = [];

        foreach (array_chunk(array_values(array_unique($skus)), 500) as $chunk) {
            // Lowercased because the database compares SKUs case-insensitively.
            $blacklisted = BlacklistedProduct::query()->whereIn('sku', $chunk)->pluck('sku')->map(fn (string $sku): string => mb_strtolower($sku))->flip();
            $existing = Product::withTrashed()->whereIn('sku', $chunk)->pluck('sku')->map(fn (string $sku): string => mb_strtolower($sku))->flip();

            foreach ($chunk as $sku) {
                $outcomes[$sku] = match (true) {
                    $blacklisted->has(mb_strtolower($sku)) => ProductImportRowOutcome::Skipped,
                    $existing->has(mb_strtolower($sku)) => ProductImportRowOutcome::Updated,
                    default => ProductImportRowOutcome::Queued,
                };
            }
        }

        return $outcomes;
    }

    public function updateExisting(ProductImportRow $row): bool
    {
        $product = Product::withTrashed()->where('sku', $row->sku)->first();

        if ($product === null) {
            return false;
        }

        if ($product->trashed()) {
            $product->restore();
        }

        // The core importer looks products up by slug, so the file handle is replaced with the stored one.
        $this->importer->import($row->withHandle((string) $product->slug));

        return true;
    }
}
