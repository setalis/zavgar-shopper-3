<?php

declare(strict_types=1);

use App\Livewire\Shopper\Pages\Product\Index;
use App\Models\Product;
use App\Models\User;
use Filament\Actions\Testing\TestAction;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Livewire\Livewire;
use Shopper\Core\Events\Products\ProductDeleted;
use Shopper\Database\Seeders\AuthTableSeeder;

uses(RefreshDatabase::class);

beforeEach(function (): void {
    $this->seed(AuthTableSeeder::class);

    $this->admin = User::factory()->create();
    $this->admin->assignRole(config('shopper.admin.roles.admin'));
});

test('admins can bulk delete selected products', function (): void {
    $keep = Product::factory()->standard()->create(['name' => 'Keep', 'slug' => 'keep']);
    $first = Product::factory()->standard()->create(['name' => 'Remove first', 'slug' => 'remove-first']);
    $second = Product::factory()->standard()->create(['name' => 'Remove second', 'slug' => 'remove-second']);

    Event::fake([ProductDeleted::class]);

    Livewire::actingAs($this->admin)
        ->test(Index::class)
        ->assertSuccessful()
        ->selectTableRecords([$first->id, $second->id])
        ->callAction(TestAction::make('delete')->table()->bulk())
        ->assertHasNoErrors()
        ->assertNotified(__('backend.products.deleted_bulk', ['count' => 2]));

    $this->assertSoftDeleted($first);
    $this->assertSoftDeleted($second);
    $this->assertNotSoftDeleted($keep);

    Event::assertDispatchedTimes(ProductDeleted::class, 2);
    Event::assertDispatched(
        ProductDeleted::class,
        fn (ProductDeleted $event): bool => $event->product->is($first),
    );
    Event::assertDispatched(
        ProductDeleted::class,
        fn (ProductDeleted $event): bool => $event->product->is($second),
    );
});

test('users without delete permission cannot bulk delete products', function (): void {
    $product = Product::factory()->standard()->create(['slug' => 'protected']);

    $user = User::factory()->create();
    $user->givePermissionTo('products.browse');

    Livewire::actingAs($user)
        ->test(Index::class)
        ->assertSuccessful()
        ->assertActionHidden(TestAction::make('delete')->table()->bulk());

    $this->assertNotSoftDeleted($product);
});
