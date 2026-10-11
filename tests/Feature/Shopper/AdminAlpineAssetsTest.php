<?php

declare(strict_types=1);

use Filament\Support\Facades\FilamentAsset;

test('theme switcher keeps each alpine statement separate', function (): void {
    $html = view('shopper::components.theme-switcher.button', [
        'icon' => 'phosphor-sun',
        'theme' => 'light',
    ])->render();

    expect($html)->toContain("theme = 'light';")
        ->and($html)->toContain('dropdownOpen = false');
});

test('admin pages load republished filament scripts with the published file time', function (): void {
    $mtime = filemtime(public_path('js/filament/tables/tables.js'));

    expect(FilamentAsset::getScriptSrc('tables', 'filament/tables'))
        ->toContain('tables.js?v=')
        ->toContain('.'.$mtime);
});
