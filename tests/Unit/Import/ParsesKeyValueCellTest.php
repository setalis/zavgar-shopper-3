<?php

declare(strict_types=1);

use App\Import\ParsesKeyValueCell;

test('it parses key value pairs separated by semicolons', function (): void {
    expect((new ParsesKeyValueCell)->handle(' Розмір : M ;Колір: Синій '))
        ->toBe(['Розмір' => ['M'], 'Колір' => ['Синій']]);
});

test('it splits multiple values with a pipe and keeps decimal commas', function (): void {
    expect((new ParsesKeyValueCell)->handle('Матеріал: Бавовна | Еластан; Об\'єм: 1,5 л'))
        ->toBe(['Матеріал' => ['Бавовна', 'Еластан'], 'Об\'єм' => ['1,5 л']]);
});

test('it splits the key on the first colon only', function (): void {
    expect((new ParsesKeyValueCell)->handle('Час роботи: 10:00-18:00'))
        ->toBe(['Час роботи' => ['10:00-18:00']]);
});

test('it skips empty pairs, keys without values and merges duplicate keys', function (): void {
    expect((new ParsesKeyValueCell)->handle(';; Колір: ; : Синій; Тег: A; Тег: B | A;'))
        ->toBe(['Тег' => ['A', 'B']]);
});

test('it returns an empty array for an empty cell', function (): void {
    expect((new ParsesKeyValueCell)->handle(null))->toBe([])
        ->and((new ParsesKeyValueCell)->handle(''))->toBe([]);
});
