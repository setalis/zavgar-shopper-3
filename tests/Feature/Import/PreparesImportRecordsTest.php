<?php

declare(strict_types=1);

use App\Import\PreparesImportRecords;

test('it strips leftover formula cells and fills empty handles from the previous row', function (): void {
    $rows = resolve(PreparesImportRecords::class)->handle([
        ['handle', 'name', 'sku'],
        ['wave-oil', 'Wave Oil', '7245/01'],
        ['', '', '=[1]Аркуш1!A3'],
    ]);

    expect($rows[1][0])->toBe('wave-oil')
        ->and($rows[2][0])->toBe('wave-oil')
        ->and($rows[2][2])->toBe('');
});
