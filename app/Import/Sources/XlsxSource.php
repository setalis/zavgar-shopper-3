<?php

declare(strict_types=1);

namespace App\Import\Sources;

use App\Support\ConvertsSpreadsheetToCsv;
use Illuminate\Support\LazyCollection;
use Shopper\Core\Import\Contracts\ImportSource;
use Shopper\Core\Import\Contracts\SupportsColumnMapping;
use Shopper\Core\Import\Sources\CsvSource;

final class XlsxSource implements ImportSource, SupportsColumnMapping
{
    public function __construct(
        private ConvertsSpreadsheetToCsv $converter,
        private CsvSource $csv,
    ) {}

    public function code(): string
    {
        return 'xlsx';
    }

    public function name(): string
    {
        return __('backend.product_imports.sources.xlsx.name');
    }

    public function description(): string
    {
        return __('backend.product_imports.sources.xlsx.description');
    }

    public function icon(): string
    {
        return 'phosphor-microsoft-excel-logo-duotone';
    }

    public function isConfigured(): bool
    {
        return true;
    }

    /**
     * @return array<int, string>
     */
    public function headers(string $path): array
    {
        $csvPath = $this->converter->toTempPath($path);

        try {
            return $this->csv->headers($csvPath);
        } finally {
            $this->forgetTempFile($csvPath);
        }
    }

    public function withMapping(array $mapping): static
    {
        $clone = clone $this;
        $clone->csv = $this->csv->withMapping($mapping);

        return $clone;
    }

    public function read(string $path): LazyCollection
    {
        $csvPath = $this->converter->toTempPath($path);

        return LazyCollection::make(function () use ($csvPath) {
            try {
                foreach ($this->csv->read($csvPath) as $row) {
                    yield $row;
                }
            } finally {
                $this->forgetTempFile($csvPath);
            }
        });
    }

    private function forgetTempFile(string $path): void
    {
        if (is_file($path)) {
            unlink($path);
        }
    }
}
