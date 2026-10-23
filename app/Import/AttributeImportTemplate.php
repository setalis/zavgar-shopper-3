<?php

declare(strict_types=1);

namespace App\Import;

use Shopper\Core\Enum\FieldType;

final class AttributeImportTemplate
{
    public const array COLUMNS = [
        'name',
        'slug',
        'description',
        'type',
        'is_enabled',
        'is_searchable',
        'is_filterable',
        'icon',
        'values',
    ];

    /**
     * @return list<list<string>>
     */
    public function rows(): array
    {
        return [
            self::COLUMNS,
            $this->row([
                'name' => 'Колір',
                'slug' => 'color',
                'description' => 'Колір товару',
                'type' => FieldType::ColorPicker->value,
                'is_enabled' => '1',
                'is_searchable' => '1',
                'is_filterable' => '1',
                'icon' => 'phosphor-palette',
                'values' => '#0000ff: Синій | #ff0000: Червоний',
            ]),
        ];
    }

    /**
     * @param  array<string, string>  $values
     * @return list<string>
     */
    private function row(array $values): array
    {
        return array_map(fn (string $column): string => $values[$column] ?? '', self::COLUMNS);
    }
}
