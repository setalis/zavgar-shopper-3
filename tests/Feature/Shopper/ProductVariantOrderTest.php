<?php

declare(strict_types=1);

use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Shopper\Database\Seeders\AuthTableSeeder;

uses(RefreshDatabase::class);

beforeEach(function (): void {
    $this->seed(AuthTableSeeder::class);

    $this->admin = User::factory()->create();
    $this->admin->assignRole(config('shopper.admin.roles.admin'));
});

test('reordering variants saves the new positions and leaves other products unchanged', function (): void {
    $product = Product::factory()->variant()->create();
    $earlier = ProductVariant::factory()->create([
        'product_id' => $product->id,
        'name' => 'Earlier',
        'position' => 1,
    ]);
    $later = ProductVariant::factory()->create([
        'product_id' => $product->id,
        'name' => 'Later',
        'position' => 2,
    ]);

    $otherProduct = Product::factory()->variant()->create();
    $other = ProductVariant::factory()->create([
        'product_id' => $otherProduct->id,
        'name' => 'Other',
        'position' => 5,
    ]);

    Livewire::withoutLazyLoading()
        ->actingAs($this->admin)
        ->test(config('shopper.components.product.pages.product-variants'), ['product' => $product])
        ->call('reorderTable', [$later->id, $earlier->id, $other->id])
        ->assertHasNoErrors();

    expect($later->fresh()->position)->toBe(1)
        ->and($earlier->fresh()->position)->toBe(2);

    expect($other->fresh()->position)->toBe(5);
});
