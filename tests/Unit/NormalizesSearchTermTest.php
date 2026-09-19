<?php

declare(strict_types=1);

use App\Support\NormalizesSearchTerm;

test('it keeps only letters and digits from a search term', function (string $value, string $expected): void {
    expect(NormalizesSearchTerm::alphanumeric($value))->toBe($expected);
})->with([
    'spaces' => ['oc 205', 'oc205'],
    'hyphen' => ['oc-205', 'oc205'],
    'mixed punctuation' => ['oc-205 / A', 'oc205A'],
    'already compact' => ['oc205', 'oc205'],
]);
