<?php

declare(strict_types=1);

use App\Support\ConvertsSpreadsheetToCsv;
use App\Support\WritesSpreadsheet;
use OpenSpout\Common\Entity\Cell;
use OpenSpout\Common\Entity\Cell\FormulaCell;
use OpenSpout\Common\Entity\Row;
use OpenSpout\Writer\XLSX\Writer;
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

test('it prefers a formula cell computed value over formula text', function (): void {
    $converter = resolve(ConvertsSpreadsheetToCsv::class);
    $method = new ReflectionMethod($converter, 'cellValue');

    expect($method->invoke($converter, new FormulaCell('=[1]Аркуш1!A3', null, 'SHIRT-1')))
        ->toBe('SHIRT-1');
});

test('it blanks formula cells that have no computed value', function (): void {
    $path = spreadsheetPath('formula-empty.xlsx');
    $writer = new Writer;
    $writer->openToFile($path);
    $writer->addRow(Row::fromValues(['handle', 'name', 'sku']));
    $writer->addRow(new Row([
        Cell::fromValue('linen-shirt'),
        Cell::fromValue('Linen Shirt'),
        new FormulaCell('=[1]Аркуш1!A3', null),
    ]));
    $writer->close();

    $stream = resolve(ConvertsSpreadsheetToCsv::class)->handle($path);
    $csv = stream_get_contents($stream);
    fclose($stream);
    unlink($path);

    expect($csv)
        ->toContain('linen-shirt')
        ->toContain('Linen Shirt')
        ->not->toContain('=[1]Аркуш1!A3');
});

test('it copies the previous handle onto continuation rows', function (): void {
    $path = spreadsheetPath('variant-handles.xlsx');

    resolve(WritesSpreadsheet::class)->handle($path, [
        ['handle', 'name', 'sku'],
        ['wave-oil', 'Wave Oil', '7245/01'],
        ['', '', '7245/200'],
    ]);

    $stream = resolve(ConvertsSpreadsheetToCsv::class)->handle($path);
    $csv = stream_get_contents($stream);
    fclose($stream);
    unlink($path);

    expect($csv)
        ->toContain('wave-oil')
        ->toContain('Wave Oil')
        ->toContain('7245/01')
        ->toContain('7245/200')
        ->toContain('wave-oil,,7245/200');
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
