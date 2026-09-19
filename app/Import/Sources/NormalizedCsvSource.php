<?php

declare(strict_types=1);

namespace App\Import\Sources;

use App\Import\NormalizesProductImportRows;
use App\Import\PreparesImportRecords;
use Illuminate\Support\LazyCollection;
use League\Csv\Reader;
use League\Csv\Writer;
use RuntimeException;
use Shopper\Core\Import\Contracts\ImportSource;
use Shopper\Core\Import\Contracts\SupportsColumnMapping;
use Shopper\Core\Import\Sources\CsvSource;

final class NormalizedCsvSource implements ImportSource, SupportsColumnMapping
{
    public function __construct(
        private CsvSource $csv,
        private PreparesImportRecords $prepares,
        private NormalizesProductImportRows $normalizes,
    ) {}

    public function code(): string
    {
        return $this->csv->code();
    }

    public function name(): string
    {
        return $this->csv->name();
    }

    public function description(): string
    {
        return $this->csv->description();
    }

    public function icon(): string
    {
        return $this->csv->icon();
    }

    public function isConfigured(): bool
    {
        return $this->csv->isConfigured();
    }

    /**
     * @return array<int, string>
     */
    public function headers(string $path): array
    {
        return $this->csv->headers($path);
    }

    public function withMapping(array $mapping): static
    {
        $clone = clone $this;
        $clone->csv = $this->csv->withMapping($mapping);

        return $clone;
    }

    public function read(string $path): LazyCollection
    {
        $prepared = $this->preparedPath($path);

        return LazyCollection::make(function () use ($prepared) {
            try {
                foreach ($this->normalizes->handle($this->csv->read($prepared)) as $row) {
                    yield $row;
                }
            } finally {
                if (is_file($prepared)) {
                    unlink($prepared);
                }
            }
        });
    }

    private function preparedPath(string $path): string
    {
        $reader = Reader::from($path);
        $rows = [];

        foreach ($reader->getRecords() as $record) {
            $rows[] = array_map(strval(...), array_values($record));
        }

        $tempPath = tempnam(sys_get_temp_dir(), 'product-csv-');

        if ($tempPath === false) {
            throw new RuntimeException('Unable to create a temporary CSV file.');
        }

        $writer = Writer::from($tempPath);

        foreach ($this->prepares->handle($rows) as $row) {
            $writer->insertOne($row);
        }

        return $tempPath;
    }
}
