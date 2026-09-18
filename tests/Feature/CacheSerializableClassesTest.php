<?php

use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Shopper\Core\Models\Country;

uses(LazilyRefreshDatabase::class);

test('cached shopper countries can be restored as a collection', function () {
    Country::factory()->create([
        'name' => 'Ukraine',
        'cca2' => 'UA',
        'region' => 'Europe',
    ]);

    $payload = Country::query()->get(['id', 'name', 'cca2', 'region']);

    $restored = unserialize(
        serialize($payload),
        ['allowed_classes' => config('cache.serializable_classes')],
    );

    expect($restored)
        ->toBeInstanceOf(EloquentCollection::class)
        ->and($restored->first())
        ->toBeInstanceOf(Country::class)
        ->and($restored->first()->cca2)
        ->toBe('UA');
});
