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
            PendingProduct::query()->where('sku', $row->sku)->delete();

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
     * @param  array<string, string>  $handlesBySku
     * @return array<string, ProductImportRowOutcome>
     */
    public function outcomesFor(array $skus, array $handlesBySku = []): array
    {
        $outcomes = [];

        foreach (array_chunk(array_values(array_unique($skus)), 500) as $chunk) {
            // Lowercased because the database compares SKUs and slugs case-insensitively.
            $blacklisted = BlacklistedProduct::query()->whereIn('sku', $chunk)->pluck('sku')->map(fn (string $sku): string => mb_strtolower($sku))->flip();
            $existing = Product::withTrashed()->whereIn('sku', $chunk)->pluck('sku')->map(fn (string $sku): string => mb_strtolower($sku))->flip();
            $existingWithoutSku = Product::withTrashed()
                ->whereIn('slug', array_values(array_intersect_key($handlesBySku, array_flip($chunk))))
                ->whereNull('sku')
                ->pluck('slug')
                ->map(fn (string $slug): string => mb_strtolower($slug))
                ->flip();

            foreach ($chunk as $sku) {
                $outcomes[$sku] = match (true) {
                    $blacklisted->has(mb_strtolower($sku)) => ProductImportRowOutcome::Skipped,
                    $existing->has(mb_strtolower($sku)),
                    $existingWithoutSku->has(mb_strtolower($handlesBySku[$sku] ?? '')) => ProductImportRowOutcome::Updated,
                    default => ProductImportRowOutcome::Queued,
                };
            }
        }

        return $outcomes;
    }

    public function updateExisting(ProductImportRow $row): bool
    {
        $product = $this->findExisting($row);

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

    /**
     * Products created before SKU matching have no product SKU, so they are matched by handle once
     * and receive the SKU from the file.
     */
    private function findExisting(ProductImportRow $row): ?Product
    {
        return Product::withTrashed()->where('sku', $row->sku)->first()
            ?? Product::withTrashed()->where('slug', $row->product->handle)->whereNull('sku')->first();
    }
}
