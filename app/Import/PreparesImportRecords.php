<?php

declare(strict_types=1);

namespace App\Import;

final class PreparesImportRecords
{
    /**
     * @param  list<list<string>>  $rows
     * @return list<list<string>>
     */
    public function handle(array $rows): array
    {
        if ($rows === []) {
            return [];
        }

        $handleIndex = $this->columnIndex($rows[0], 'handle');
        $lastHandle = '';

        foreach ($rows as $index => $row) {
            $row = array_map($this->stripFormula(...), $row);

            if ($index > 0 && $handleIndex !== null) {
                $handle = mb_trim($row[$handleIndex] ?? '');

                if ($handle === '') {
                    $row[$handleIndex] = $lastHandle;
                } else {
                    $lastHandle = $handle;
                }
            }

            $rows[$index] = $row;
        }

        return $rows;
    }

    public function stripFormula(string $value): string
    {
        $value = mb_trim($value);

        return str_starts_with($value, '=') ? '' : $value;
    }

    /**
     * @param  list<string>  $header
     */
    private function columnIndex(array $header, string $name): ?int
    {
        foreach ($header as $index => $column) {
            if (mb_strtolower(mb_trim($column)) === $name) {
                return $index;
            }
        }

        return null;
    }
}
