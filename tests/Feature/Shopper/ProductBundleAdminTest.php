<?php

declare(strict_types=1);

use App\Livewire\Shopper\Pages\Product\Bundle;
use App\Models\Product;
use App\Models\ProductBundleItem;
use App\Models\User;
use App\Sidebar\ProductSections\BundleSection;
use App\Sidebar\ProductSections\InventorySection;
use Filament\Actions\Testing\TestAction;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Livewire\Livewire;
use Shopper\Core\Models\Setting;
use Shopper\Database\Seeders\AuthTableSeeder;
use Shopper\Navigation\Product\ProductSectionManager;

uses(RefreshDatabase::class);

beforeEach(function (): void {
    $this->seed(AuthTableSeeder::class);

    $this->admin = User::factory()->create();
    $this->admin->assignRole(config('shopper.admin.roles.admin'));
});

test('admins can open the bundle tab of a standard product', function (): void {
    foreach (['email' => 'shop@example.com', 'street_address' => 'Khreshchatyk 1'] as $key => $value) {
        Setting::query()->create(['key' => $key, 'display_name' => $key, 'value' => $value, 'locked' => true]);
        Cache::forget("shopper-setting.{$key}");
    }

    $product = Product::factory()->standard()->create();

    $this->actingAs($this->admin)
        ->get(route('shopper.products.edit.bundle', $product))
        ->assertOk()
        ->assertSee(__('backend.bundles.is_bundle'));
});

test('users without the edit permission cannot open the bundle tab', function (): void {
    $product = Product::factory()->standard()->create();

    $this->actingAs(User::factory()->create())
        ->get(route('shopper.products.edit.bundle', $product))
        ->assertRedirect();
});

test('the bundle tab is not available for variant products', function (): void {
    $product = Product::factory()->variant()->create();

    Livewire::actingAs($this->admin)
        ->test(Bundle::class, ['product' => $product])
        ->assertNotFound();
});

test('admins can save the bundle composition', function (): void {
    $product = Product::factory()->standard()->create();
    $oil = Product::factory()->standard()->create();

    Livewire::actingAs($this->admin)
        ->test(Bundle::class, ['product' => $product])
        ->set('data.is_bundle', true)
        ->set('data.items', [
            ['product_id' => $oil->id, 'product_variant_id' => null, 'quantity' => 3],
        ])
        ->call('store')
        ->assertHasNoErrors();

    expect($product->fresh()->is_bundle)->toBeTrue()
        ->and(ProductBundleItem::query()->where('bundle_id', $product->id)->sole())
        ->product_id->toBe($oil->id)
        ->quantity->toBe(3);
});

test('admins can add a component row to the composition', function (): void {
    $product = Product::factory()->standard()->create();

    Livewire::actingAs($this->admin)
        ->test(Bundle::class, ['product' => $product])
        ->set('data.is_bundle', true)
        ->set('data.items', [])
        ->callAction(TestAction::make('add')->schemaComponent('items'))
        ->assertHasNoErrors()
        ->assertCount('data.items', 1);
});

test('an invalid composition is reported on the form', function (): void {
    $product = Product::factory()->standard()->create();

    Livewire::actingAs($this->admin)
        ->test(Bundle::class, ['product' => $product])
        ->set('data.is_bundle', true)
        ->set('data.items', [
            ['product_id' => $product->id, 'product_variant_id' => null, 'quantity' => 1],
        ])
        ->call('store')
        ->assertHasErrors(['data.items.0']);

    expect($product->fresh()->is_bundle)->toBeFalse();
});

test('bundles get the bundle section instead of the inventory section', function (): void {
    $bundle = Product::factory()->standard()->create(['is_bundle' => true]);
    $regular = Product::factory()->standard()->create();
    $manager = resolve(ProductSectionManager::class);

    expect($manager->forProduct($bundle)->map(fn ($section): string => $section::class))
        ->toContain(BundleSection::class)
        ->not->toContain(InventorySection::class)
        ->and($manager->forProduct($regular)->map(fn ($section): string => $section::class))
        ->toContain(BundleSection::class, InventorySection::class);
});
