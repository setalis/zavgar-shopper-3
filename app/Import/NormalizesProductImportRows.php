<?php

declare(strict_types=1);

namespace App\Import;

use App\Models\Product;
use Illuminate\Support\LazyCollection;
use Shopper\Core\Import\ProductRow;
use Shopper\Core\Import\VariantRow;
use Shopper\Core\Models\Currency;

final class NormalizesProductImportRows
{
    /**
     * @template TRow of ProductRow|ProductImportRow
     *
     * @param  LazyCollection<int, TRow>  $rows
     * @return LazyCollection<int, TRow>
     */
    public function handle(LazyCollection $rows): LazyCollection
    {
        $enabledCurrencies = $this->enabledCurrencyCodes();

        return $rows->map(fn (ProductRow|ProductImportRow $row): ProductRow|ProductImportRow => $row instanceof ProductImportRow
            ? $row->withProduct($this->product($row->product, $enabledCurrencies))
            : $this->product($row, $enabledCurrencies));
    }

    /**
     * @param  list<string>  $enabledCurrencies
     */
    private function product(ProductRow $row, array $enabledCurrencies): ProductRow
    {
        $handle = $this->slug($row->handle);
        $this->restoreTrashed($handle);

        return new ProductRow(
            handle: $handle,
            name: $row->name,
            description: $row->description,
            brand: $row->brand,
            categories: $row->categories,
            tags: $row->tags,
            published: $row->published,
            seoTitle: $row->seoTitle,
            seoDescription: $row->seoDescription,
            optionNames: $row->optionNames,
            variants: array_map(
                fn (VariantRow $variant): VariantRow => $this->variant($variant, $enabledCurrencies),
                $row->variants,
            ),
            images: $row->images,
        );
    }

    private function restoreTrashed(string $slug): void
    {
        if ($slug === '') {
            return;
        }

        Product::onlyTrashed()->where('slug', $slug)->restore();
    }

    /**
     * @param  list<string>  $enabledCurrencies
     */
    private function variant(VariantRow $variant, array $enabledCurrencies): VariantRow
    {
        $currency = $variant->currency === null
            ? null
            : mb_strtoupper($variant->currency);

        if ($currency !== null && ! in_array($currency, $enabledCurrencies, true)) {
            $currency = null;
        }

        return new VariantRow(
            options: $variant->options,
            sku: $this->cell($variant->sku),
            barcode: $this->cell($variant->barcode),
            ean: $this->cell($variant->ean),
            upc: $this->cell($variant->upc),
            price: $variant->price,
            compareAtPrice: $variant->compareAtPrice,
            costPerItem: $variant->costPerItem,
            currency: $currency,
            quantity: $variant->quantity,
            weightValue: $variant->weightValue,
            weightUnit: $variant->weightUnit,
            requiresShipping: $variant->requiresShipping,
            allowBackorder: $variant->allowBackorder,
            imageUrl: $variant->imageUrl,
        );
    }

    private function slug(string $handle): string
    {
        return str($handle)->slug()->toString() ?: $handle;
    }

    private function cell(?string $value): ?string
    {
        if ($value === null) {
            return null;
        }

        $value = mb_trim($value);

        return $value === '' || str_starts_with($value, '=') ? null : $value;
    }

    /**
     * @return list<string>
     */
    private function enabledCurrencyCodes(): array
    {
        $ids = shopper_setting('currencies') ?? [];

        if ($ids === []) {
            return [];
        }

        return Currency::query()
            ->whereIn('id', $ids)
            ->pluck('code')
            ->map(fn (string $code): string => mb_strtoupper($code))
            ->values()
            ->all();
    }
}
