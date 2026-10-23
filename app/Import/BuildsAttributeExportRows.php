<?php

declare(strict_types=1);

namespace App\Import;

use Generator;
use Shopper\Core\Models\Attribute;
use Shopper\Core\Models\AttributeValue;

final class BuildsAttributeExportRows
{
    private const int CHUNK_SIZE = 100;

    /**
     * @return Generator<int, list<string>>
     */
    public function handle(): Generator
    {
        yield AttributeImportTemplate::COLUMNS;

        $attributes = Attribute::query()
            ->with('values')
            ->lazyById(self::CHUNK_SIZE);

        foreach ($attributes as $attribute) {
            yield $this->row($attribute);
        }
    }

    /**
     * @return list<string>
     */
    private function row(Attribute $attribute): array
    {
        return $this->cells([
            'name' => $attribute->name,
            'slug' => (string) $attribute->slug,
            'description' => (string) $attribute->description,
            'type' => $attribute->type->value,
            'is_enabled' => $this->flag($attribute->is_enabled),
            'is_searchable' => $this->flag($attribute->is_searchable),
            'is_filterable' => $this->flag($attribute->is_filterable),
            'icon' => (string) $attribute->icon,
            'values' => $this->values($attribute),
        ]);
    }

    private function values(Attribute $attribute): string
    {
        if (! in_array($attribute->type, Attribute::fieldsWithValues(), true)) {
            return '';
        }

        return $attribute->values
            ->sortBy([['position', 'asc'], ['id', 'asc']])
            ->map(fn (AttributeValue $value): string => $value->key.': '.$value->value)
            ->implode(' | ');
    }

    /**
     * @param  array<string, string>  $values
     * @return list<string>
     */
    private function cells(array $values): array
    {
        return array_map(
            fn (string $column): string => $values[$column] ?? '',
            AttributeImportTemplate::COLUMNS,
        );
    }

    private function flag(mixed $value): string
    {
        return $value ? '1' : '0';
    }
}
