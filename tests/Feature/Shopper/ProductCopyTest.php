<?php

declare(strict_types=1);

use App\Livewire\Shopper\Pages\Product\Index;
use App\Livewire\Shopper\SlideOvers\AddProduct;
use App\Models\AttributeProduct;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\User;
use Filament\Actions\Testing\TestAction;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Shopper\Core\Enum\FieldType;
use Shopper\Core\Enum\ProductType;
use Shopper\Core\Models\Attribute;
use Shopper\Core\Models\AttributeValue;
use Shopper\Core\Models\Currency;
use Shopper\Core\Models\Inventory;
use Shopper\Core\Models\Price;
use Shopper\Database\Seeders\AuthTableSeeder;

uses(RefreshDatabase::class);

beforeEach(function (): void {
    $this->seed(AuthTableSeeder::class);

    $this->admin = User::factory()->create();
    $this->admin->assignRole(config('shopper.admin.roles.admin'));
});

test('admins can open a product copy without creating a product', function (): void {
    $product = Product::factory()->standard()->create([
        'name' => 'Camera',
        'slug' => 'camera',
        'sku' => 'CAM-1',
    ]);

    Livewire::actingAs($this->admin)
        ->test(Index::class)
        ->assertSuccessful()
        ->assertActionVisible(TestAction::make('copy')->table($product))
        ->callAction(TestAction::make('copy')->table($product))
        ->assertHasNoErrors()
        ->assertDispatched('openPanel', function (string $event, array $params) use ($product): bool {
            return ($params[0] ?? null) === 'shopper-slide-overs.add-product'
                && ($params[1]['productId'] ?? null) === $product->id;
        });

    expect(Product::query()->count())->toBe(1)
        ->and($product->fresh()->sku)->toBe('CAM-1')
        ->and($product->fresh()->slug)->toBe('camera');
});

test('users without create permission cannot copy a product', function (): void {
    $product = Product::factory()->standard()->create(['slug' => 'protected']);

    $user = User::factory()->create();
    $user->givePermissionTo('products.browse');

    Livewire::actingAs($user)
        ->test(Index::class)
        ->assertSuccessful()
        ->assertActionHidden(TestAction::make('copy')->table($product));

    expect(Product::query()->count())->toBe(1);
});

test('the create form is filled from the product and does not save it', function (): void {
    $inventory = Inventory::factory()->create(['is_default' => true]);
    $product = Product::factory()->standard()->create([
        'name' => 'Camera',
        'slug' => 'camera',
        'sku' => 'CAM-1',
        'barcode' => '123456',
        'summary' => 'Short summary',
        'description' => null,
        'security_stock' => 3,
        'published_at' => now(),
    ]);
    $product->mutateStock($inventory->id, 4);

    $component = Livewire::actingAs($this->admin)
        ->test(AddProduct::class, ['productId' => $product->id])
        ->assertSuccessful()
        ->assertSet('data.name', 'Camera')
        ->assertSet('data.slug', null)
        ->assertSet('data.sku', null)
        ->assertSet('data.barcode', '123456')
        ->assertSet('data.summary', 'Short summary')
        ->assertSet('data.security_stock', 3)
        ->assertSet('data.type', ProductType::Standard->value);

    expect($component->get('data.quantity'))->toEqual(4)
        ->and(Product::query()->count())->toBe(1);
});

test('saving a copy with the same barcode is rejected', function (): void {
    $product = Product::factory()->standard()->create([
        'name' => 'Camera',
        'slug' => 'camera',
        'sku' => 'CAM-1',
        'barcode' => '123456',
        'description' => null,
        'published_at' => now(),
    ]);

    Livewire::actingAs($this->admin)
        ->test(AddProduct::class, ['productId' => $product->id])
        ->call('store')
        ->assertHasFormErrors(['barcode' => 'unique']);

    expect(Product::query()->count())->toBe(1)
        ->and($product->fresh()->slug)->toBe('camera');
});

test('saving the create form copies product data without sku or slug', function (): void {
    $currency = Currency::query()->create([
        'name' => 'Hryvnia',
        'code' => 'UAH',
        'symbol' => '₴',
        'format' => '1,234.56 ₴',
    ]);
    $inventory = Inventory::factory()->create(['is_default' => true]);
    $category = Category::factory()->create(['name' => 'Cameras']);
    $product = Product::factory()->variant()->featured()->create([
        'name' => 'Camera',
        'slug' => 'camera',
        'sku' => 'CAM-1',
        'barcode' => null,
        'summary' => 'Short summary',
        'description' => null,
        'security_stock' => 3,
        'seo_title' => 'Camera SEO',
        'allow_backorder' => true,
        'published_at' => now(),
    ]);
    $product->categories()->attach($category);
    $product->mutateStock($inventory->id, 4);
    $product->translations()->create([
        'locale' => 'en',
        'name' => 'Camera EN',
    ]);

    Price::query()->create([
        'priceable_type' => $product->getMorphClass(),
        'priceable_id' => $product->id,
        'amount' => 2500,
        'compare_amount' => 3000,
        'cost_amount' => 1000,
        'currency_id' => $currency->id,
    ]);

    $color = Attribute::factory()->create(['name' => 'Color', 'type' => FieldType::Select]);
    $red = AttributeValue::factory()->create(['attribute_id' => $color->id, 'value' => 'Red']);

    AttributeProduct::create([
        'product_id' => $product->id,
        'attribute_id' => $color->id,
        'attribute_value_id' => $red->id,
        'is_variant_option' => true,
    ]);

    $variant = ProductVariant::factory()->create([
        'product_id' => $product->id,
        'name' => 'Red',
        'sku' => 'CAM-1-RED',
        'barcode' => '999',
        'allow_backorder' => true,
    ]);
    $variant->values()->attach($red->id);
    $variant->mutateStock($inventory->id, 2);

    Price::query()->create([
        'priceable_type' => $variant->getMorphClass(),
        'priceable_id' => $variant->id,
        'amount' => 2600,
        'compare_amount' => null,
        'cost_amount' => null,
        'currency_id' => $currency->id,
    ]);

    Livewire::actingAs($this->admin)
        ->test(AddProduct::class, ['productId' => $product->id])
        ->call('store')
        ->assertHasNoFormErrors();

    $copy = Product::query()->where('id', '!=', $product->id)->sole();
    $copiedVariant = $copy->variants()->sole();

    expect($copy->name)->toBe('Camera')
        ->and($copy->slug)->toBeNull()
        ->and($copy->sku)->toBeNull()
        ->and($copy->summary)->toBe('Short summary')
        ->and($copy->security_stock)->toBe(3)
        ->and($copy->featured)->toBeTrue()
        ->and($copy->allow_backorder)->toBeTrue()
        ->and($copy->seo_title)->toBe('Camera SEO')
        ->and($copy->stock)->toBe(4)
        ->and($copy->categories()->pluck('id')->all())->toBe([$category->id])
        ->and($copy->translations()->where('locale', 'en')->value('name'))->toBe('Camera EN')
        ->and($copy->prices()->value('amount'))->toBe(2500);

    expect($copy->attributeProducts()->sole())
        ->attribute_id->toBe($color->id)
        ->attribute_value_id->toBe($red->id)
        ->is_variant_option->toBeTrue();

    expect($copiedVariant->name)->toBe('Red')
        ->and($copiedVariant->sku)->toBeNull()
        ->and($copiedVariant->barcode)->toBeNull()
        ->and($copiedVariant->allow_backorder)->toBeTrue()
        ->and($copiedVariant->stock)->toBe(2)
        ->and($copiedVariant->values->pluck('id')->all())->toBe([$red->id])
        ->and($copiedVariant->prices()->value('amount'))->toBe(2600);

    expect($product->fresh())
        ->sku->toBe('CAM-1')
        ->slug->toBe('camera')
        ->stock->toBe(4);
});
