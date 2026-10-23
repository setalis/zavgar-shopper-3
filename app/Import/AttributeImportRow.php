<?php

declare(strict_types=1);

namespace App\Import;

use Shopper\Core\Enum\FieldType;

final readonly class AttributeImportRow
{
    /**
     * @param  list<array{key: string, value: string}>  $values
     */
    public function __construct(
        public int $line,
        public string $name,
        public string $slug,
        public ?string $description,
        public FieldType $type,
        public bool $isEnabled,
        public bool $isSearchable,
        public bool $isFilterable,
        public ?string $icon,
        public array $values,
    ) {}
}
