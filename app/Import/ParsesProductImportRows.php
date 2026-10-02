<?php

declare(strict_types=1);

namespace App\Import;

use Generator;
use Illuminate\Support\LazyCollection;
use League\Csv\Reader;
use Shopper\Core\Enum\Dimension\Length;
use Shopper\Core\Exceptions\ProductImportException;
use Shopper\Core\Import\ImageRow;
use Shopper\Core\Import\ProductRow;
use Shopper\Core\Import\VariantRow;

final class ParsesProductImportRows
{
    private const array REQUIRED_COLUMNS = ['handle', 'name'];

    private const array DIMENSIONS = ['width', 'height', 'depth'];

    private const array TRUE_VALUES = ['1', 'true', 'yes', 'y', 'on', '+', 'так', 'да'];

    /** @var array<string, string> */
    private array $mapping = [];

    public function __construct(
        private ParsesKeyValueCell $keyValues,
    ) {}

    /**
     * @param  array<string, string>  $mapping
     */
    public function withMapping(array $mapping): static
    {
        $clone = clone $this;
        $clone->mapping = array_filter($mapping);

        return $clone;
    }

    /**
     * @return LazyCollection<int, ProductImportRow>
     */
    public function read(string $csvPath): LazyCollection
    {
        return LazyCollection::make(function () use ($csvPath): Generator {
            $reader = Reader::from($csvPath);
            $reader->setHeaderOffset(0);

            $this->validateHeader($reader->getHeader());

            $handle = null;
            $buffer = [];

            foreach ($reader->getRecords() as $record) {
                $rowHandle = $this->value($record, 'handle');

                if ($rowHandle === null) {
                    continue;
                }

                if ($handle !== null && $rowHandle !== $handle && $buffer !== []) {
                    yield $this->makeProduct($buffer);
                    $buffer = [];
                }

                $handle = $rowHandle;
                $buffer[] = $record;
            }

            if ($buffer !== []) {
                yield $this->makeProduct($buffer);
            }
        });
    }

    /**
     * @param  array<int, ?string>  $header
     */
    private function validateHeader(array $header): void
    {
        $missing = array_diff(array_map($this->column(...), self::REQUIRED_COLUMNS), $header);

        if ($missing !== []) {
            throw new ProductImportException(sprintf(
                'The file does not match the product import template: missing the %s column.',
                implode(', ', $missing)
            ));
        }
    }

    /**
     * @param  list<array<string, ?string>>  $rows
     */
    private function makeProduct(array $rows): ProductImportRow
    {
        $first = $rows[0];

        $variationRows = array_values(array_filter(
            $rows,
            fn (array $row): bool => $this->value($row, 'variations') !== null,
        ));

        $optionNames = [];
        $variants = [];
        $variantData = [];

        foreach ($variationRows as $row) {
            $options = array_map(
                fn (array $values): string => $values[0],
                $this->keyValues->handle($this->value($row, 'variations')),
            );

            $optionNames = array_values(array_unique([...$optionNames, ...array_keys($options)]));
            $variants[] = $this->makeVariant($row, $options);

            $sku = $this->value($row, 'sku');
            $dimensions = $this->dimensions($row);

            if ($sku !== null && $dimensions !== []) {
                $variantData[$sku] = $dimensions;
            }
        }

        if ($variants === []) {
            $variants[] = $this->makeVariant($first, []);
        }

        return new ProductImportRow(
            product: new ProductRow(
                handle: (string) $this->value($first, 'handle'),
                name: (string) $this->value($first, 'name'),
                description: $this->value($first, 'description'),
                brand: $this->value($first, 'brand'),
                categories: $this->split($first, 'category', '>'),
                tags: $this->split($first, 'tags', ','),
                published: $this->boolean($first, 'published') ?? true,
                seoTitle: $this->value($first, 'seo_title'),
                seoDescription: $this->value($first, 'seo_description'),
                optionNames: $optionNames,
                variants: $variants,
                images: $this->images($rows),
            ),
            attributes: $this->keyValues->handle($this->value($first, 'attributes')),
            supplier: $this->value($first, 'supplier'),
            productData: $this->productData($first),
            variantData: $variantData,
            sku: $this->value($first, 'variations') === null ? $this->value($first, 'sku') : null,
        );
    }

    /**
     * @param  array<string, ?string>  $row
     * @param  array<string, string>  $options
     */
    private function makeVariant(array $row, array $options): VariantRow
    {
        return new VariantRow(
            options: $options,
            sku: $this->value($row, 'sku'),
            barcode: $this->value($row, 'barcode'),
            ean: $this->value($row, 'ean'),
            upc: $this->value($row, 'upc'),
            price: $this->float($row, 'price'),
            compareAtPrice: $this->float($row, 'compare_at_price'),
            costPerItem: $this->float($row, 'cost_per_item'),
            currency: $this->value($row, 'currency'),
            quantity: (int) ($this->float($row, 'quantity') ?? 0),
            weightValue: $this->float($row, 'weight_value'),
            weightUnit: $this->value($row, 'weight_unit'),
            allowBackorder: $this->boolean($row, 'allow_backorder') ?? false,
            imageUrl: $this->value($row, 'variant_image_url'),
        );
    }

    /**
     * @param  array<string, ?string>  $row
     * @return array<string, mixed>
     */
    private function productData(array $row): array
    {
        $data = array_filter([
            'featured' => $this->boolean($row, 'featured'),
            'allow_backorder' => $this->boolean($row, 'allow_backorder'),
        ], fn (?bool $value): bool => $value !== null);

        return [...$data, ...$this->dimensions($row)];
    }

    /**
     * @param  array<string, ?string>  $row
     * @return array<string, mixed>
     */
    private function dimensions(array $row): array
    {
        $unit = Length::tryFrom(mb_strtolower((string) $this->value($row, 'length_unit'))) ?? Length::CM;
        $data = [];

        foreach (self::DIMENSIONS as $dimension) {
            $value = $this->float($row, "{$dimension}_value");

            if ($value !== null) {
                $data["{$dimension}_value"] = $value;
                $data["{$dimension}_unit"] = $unit;
            }
        }

        return $data;
    }

    /**
     * @param  list<array<string, ?string>>  $rows
     * @return list<ImageRow>
     */
    private function images(array $rows): array
    {
        $images = [];

        foreach ($rows as $row) {
            foreach ($this->split($row, 'image_url', ';') as $url) {
                $images[] = new ImageRow(
                    url: $url,
                    position: count($images) + 1,
                    alt: $this->value($row, 'image_alt'),
                );
            }
        }

        return $images;
    }

    /**
     * @param  array<string, ?string>  $row
     * @return list<string>
     */
    private function split(array $row, string $key, string $separator): array
    {
        return array_values(array_filter(
            array_map(mb_trim(...), explode($separator, (string) $this->value($row, $key))),
            fn (string $value): bool => $value !== '',
        ));
    }

    private function column(string $key): string
    {
        return $this->mapping[$key] ?? $key;
    }

    /**
     * @param  array<string, ?string>  $row
     */
    private function value(array $row, string $key): ?string
    {
        $value = mb_trim((string) ($row[$this->column($key)] ?? ''));

        return $value === '' ? null : $value;
    }

    /**
     * @param  array<string, ?string>  $row
     */
    private function boolean(array $row, string $key): ?bool
    {
        $value = $this->value($row, $key);

        return $value === null ? null : in_array(mb_strtolower($value), self::TRUE_VALUES, true);
    }

    /**
     * @param  array<string, ?string>  $row
     */
    private function float(array $row, string $key): ?float
    {
        $value = $this->value($row, $key);

        if ($value === null) {
            return null;
        }

        $value = str_replace([' ', "\u{00A0}", ','], ['', '', '.'], $value);

        return is_numeric($value) ? (float) $value : null;
    }
}
