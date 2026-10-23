<?php

declare(strict_types=1);

namespace App\Import;

use App\Support\ConvertsSpreadsheetToCsv;
use League\Csv\Reader;
use Shopper\Core\Enum\FieldType;
use Shopper\Core\Models\Attribute;

final class ParsesAttributeImportFile
{
    private const array TRUE_VALUES = ['1', 'true', 'yes', 'y', 'on', '+', 'так', 'да'];

    private const int NAME_MAX = 75;

    private const int DESCRIPTION_MAX = 100;

    private const int VALUE_MAX = 50;

    private const int KEY_MAX = 255;

    private const int ICON_MAX = 255;

    public function __construct(
        private ConvertsSpreadsheetToCsv $converter,
    ) {}

    /**
     * @return array{rows: list<AttributeImportRow>, errors: list<array{line: int, message: string}>}
     */
    public function parse(string $path): array
    {
        $csvPath = $this->converter->toTempPath($path);

        try {
            return $this->parseCsv($csvPath);
        } finally {
            if (is_file($csvPath)) {
                unlink($csvPath);
            }
        }
    }

    /**
     * @return array{rows: list<AttributeImportRow>, errors: list<array{line: int, message: string}>}
     */
    private function parseCsv(string $csvPath): array
    {
        $reader = Reader::from($csvPath);
        $reader->setHeaderOffset(0);

        $header = array_map(
            fn (mixed $column): string => mb_trim((string) $column),
            $reader->getHeader(),
        );

        if ($header !== AttributeImportTemplate::COLUMNS) {
            throw new AttributeImportException(__('backend.attribute_imports.template_mismatch'));
        }

        $rows = [];
        $errors = [];
        $line = 1;

        foreach ($reader->getRecords() as $record) {
            $line++;

            if ($this->isEmpty($record)) {
                continue;
            }

            try {
                $rows[] = $this->row($record, $line);
            } catch (AttributeImportException $exception) {
                $errors[] = ['line' => $line, 'message' => $exception->getMessage()];
            }
        }

        return [
            'rows' => $this->lastRowPerSlug($rows),
            'errors' => $errors,
        ];
    }

    /**
     * @param  array<string, ?string>  $record
     */
    private function row(array $record, int $line): AttributeImportRow
    {
        $name = mb_trim((string) ($record['name'] ?? ''));

        if ($name === '') {
            throw new AttributeImportException(__('backend.attribute_imports.missing_name', ['line' => $line]));
        }

        if (mb_strlen($name) > self::NAME_MAX) {
            throw new AttributeImportException(__('backend.attribute_imports.name_too_long', [
                'line' => $line,
                'max' => self::NAME_MAX,
            ]));
        }

        $slug = str((string) ($record['slug'] ?? ''))->slug()->toString();

        if ($slug === '') {
            $slug = str($name)->slug()->toString();
        }

        if ($slug === '') {
            throw new AttributeImportException(__('backend.attribute_imports.missing_slug', ['line' => $line]));
        }

        $description = mb_trim((string) ($record['description'] ?? ''));
        $description = $description === '' ? null : $description;

        if ($description !== null && mb_strlen($description) > self::DESCRIPTION_MAX) {
            throw new AttributeImportException(__('backend.attribute_imports.description_too_long', [
                'line' => $line,
                'max' => self::DESCRIPTION_MAX,
            ]));
        }

        $type = FieldType::tryFrom(mb_strtolower(mb_trim((string) ($record['type'] ?? ''))));

        if (! $type instanceof FieldType) {
            throw new AttributeImportException(__('backend.attribute_imports.invalid_type', [
                'line' => $line,
                'type' => mb_trim((string) ($record['type'] ?? '')),
            ]));
        }

        $icon = mb_trim((string) ($record['icon'] ?? ''));
        $icon = $icon === '' ? null : $icon;

        if ($icon !== null && mb_strlen($icon) > self::ICON_MAX) {
            throw new AttributeImportException(__('backend.attribute_imports.icon_too_long', [
                'line' => $line,
                'max' => self::ICON_MAX,
            ]));
        }

        return new AttributeImportRow(
            line: $line,
            name: $name,
            slug: $slug,
            description: $description,
            type: $type,
            isEnabled: $this->boolean((string) ($record['is_enabled'] ?? '')),
            isSearchable: $this->boolean((string) ($record['is_searchable'] ?? '')),
            isFilterable: $this->boolean((string) ($record['is_filterable'] ?? '')),
            icon: $icon,
            values: $this->values((string) ($record['values'] ?? ''), $line, $type),
        );
    }

    /**
     * @return list<array{key: string, value: string}>
     */
    private function values(string $cell, int $line, FieldType $type): array
    {
        $cell = mb_trim($cell);
        $allowsValues = in_array($type, Attribute::fieldsWithValues(), true);

        if ($cell === '') {
            return [];
        }

        if (! $allowsValues) {
            throw new AttributeImportException(__('backend.attribute_imports.values_not_allowed', [
                'line' => $line,
                'type' => $type->value,
            ]));
        }

        $values = [];

        foreach (explode('|', $cell) as $part) {
            $part = mb_trim($part);

            if ($part === '') {
                continue;
            }

            $separator = mb_strpos($part, ':');

            if ($separator === false) {
                throw new AttributeImportException(__('backend.attribute_imports.invalid_value', ['line' => $line]));
            }

            $key = mb_strtolower(mb_trim(mb_substr($part, 0, $separator)));
            $value = mb_trim(mb_substr($part, $separator + 1));

            if ($key === '' || $value === '') {
                throw new AttributeImportException(__('backend.attribute_imports.invalid_value', ['line' => $line]));
            }

            if (mb_strlen($key) > self::KEY_MAX) {
                throw new AttributeImportException(__('backend.attribute_imports.key_too_long', [
                    'line' => $line,
                    'max' => self::KEY_MAX,
                ]));
            }

            if (mb_strlen($value) > self::VALUE_MAX) {
                throw new AttributeImportException(__('backend.attribute_imports.value_too_long', [
                    'line' => $line,
                    'max' => self::VALUE_MAX,
                ]));
            }

            if (array_key_exists($key, $values)) {
                throw new AttributeImportException(__('backend.attribute_imports.duplicate_value_key', [
                    'line' => $line,
                    'key' => $key,
                ]));
            }

            $values[$key] = ['key' => $key, 'value' => $value];
        }

        return array_values($values);
    }

    /**
     * @param  list<AttributeImportRow>  $rows
     * @return list<AttributeImportRow>
     */
    private function lastRowPerSlug(array $rows): array
    {
        $bySlug = [];

        foreach ($rows as $row) {
            $bySlug[$row->slug] = $row;
        }

        return array_values($bySlug);
    }

    /**
     * @param  array<string, ?string>  $record
     */
    private function isEmpty(array $record): bool
    {
        foreach (AttributeImportTemplate::COLUMNS as $column) {
            if (mb_trim((string) ($record[$column] ?? '')) !== '') {
                return false;
            }
        }

        return true;
    }

    private function boolean(string $value): bool
    {
        return in_array(mb_strtolower(mb_trim($value)), self::TRUE_VALUES, true);
    }
}
