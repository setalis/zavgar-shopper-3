<?php

declare(strict_types=1);

use App\Support\ConvertsSpreadsheetToCsv;
use App\Support\WritesSpreadsheet;
use Shopper\Core\Exceptions\ProductImportException;

function spreadsheetPath(string $name): string
{
    $path = sys_get_temp_dir().DIRECTORY_SEPARATOR.$name;

    if (is_file($path)) {
        unlink($path);
    }

    return $path;
}

test('it converts an excel workbook into csv rows', function (): void {
    $path = spreadsheetPath('products-import.xlsx');

    resolve(WritesSpreadsheet::class)->handle($path, [
        ['handle', 'name', 'sku'],
        ['linen-shirt', 'Linen Shirt', 'SHIRT-1'],
    ]);

    $stream = resolve(ConvertsSpreadsheetToCsv::class)->handle($path);
    $csv = stream_get_contents($stream);
    fclose($stream);
    unlink($path);

    expect($csv)
        ->toContain('handle,name,sku')
        ->toContain('linen-shirt')
        ->toContain('Linen Shirt')
        ->toContain('SHIRT-1');
});

test('it rejects files that are not excel workbooks', function (): void {
    $path = spreadsheetPath('not-a-workbook.csv');
    file_put_contents($path, "handle,name\nlinen-shirt,Linen Shirt");

    expect(fn () => resolve(ConvertsSpreadsheetToCsv::class)->handle($path))
        ->toThrow(ProductImportException::class, __('backend.product_imports.invalid_spreadsheet'));

    unlink($path);
});

test('it detects spreadsheet filenames and mime types', function (): void {
    $converter = resolve(ConvertsSpreadsheetToCsv::class);

    expect($converter->supports('catalog.xlsx'))->toBeTrue()
        ->and($converter->supports('catalog.csv'))->toBeFalse()
        ->and($converter->supports(
            'catalog.bin',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ))->toBeTrue();
});
