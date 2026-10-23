<?php

declare(strict_types=1);

namespace App\Import;

final readonly class AttributeImportResult
{
    /**
     * @param  list<array{line: int, message: string}>  $errors
     * @param  list<array{line: int, name: string, slug: string, outcome: ?string, error: ?string}>  $rows
     */
    public function __construct(
        public int $updated,
        public int $queued,
        public array $errors,
        public array $rows,
    ) {}
}
