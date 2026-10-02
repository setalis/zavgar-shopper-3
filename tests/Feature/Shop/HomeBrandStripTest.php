<?php

declare(strict_types=1);

use App\Models\Brand;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('home page lists enabled brands and hides disabled ones', function (): void {
    $acme = Brand::factory()->create([
        'name' => 'Acme',
        'slug' => 'acme',
        'is_enabled' => true,
        'position' => 1,
    ]);

    Brand::factory()->create([
        'name' => 'Hidden',
        'slug' => 'hidden',
        'is_enabled' => false,
        'position' => 0,
    ]);

    $this->get(route('home'))
        ->assertOk()
        ->assertInertia(fn ($page) => $page
            ->component('shop/home')
            ->has('brands', 1)
            ->where('brands.0.id', $acme->id)
            ->where('brands.0.name', 'Acme')
            ->where('brands.0.slug', 'acme')
        );
});

test('home page returns empty brands when catalog has none enabled', function (): void {
    Brand::factory()->create([
        'name' => 'Hidden',
        'slug' => 'hidden',
        'is_enabled' => false,
    ]);

    $this->get(route('home'))
        ->assertOk()
        ->assertInertia(fn ($page) => $page
            ->component('shop/home')
            ->has('brands', 0)
        );
});
