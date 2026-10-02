<?php

declare(strict_types=1);

use App\Import\ImportsProductRow;
use App\Import\ProductImportRow;
use App\Livewire\Shopper\Pages\Product\Attributes;
use App\Livewire\Shopper\SlideOvers\AddVariant;
use App\Livewire\Shopper\SlideOvers\ChooseProductAttributes;
use App\Livewire\Shopper\SlideOvers\GenerateVariants;
use App\Models\AttributeProduct;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Livewire\Livewire;
use Shopper\Core\Enum\FieldType;
use Shopper\Core\Import\ProductRow;
use Shopper\Core\Import\VariantRow;
use Shopper\Core\Models\Attribute;
use Shopper\Core\Models\AttributeValue;
use Shopper\Core\Models\Currency;
use Shopper\Core\Models\Setting;
use Shopper\Database\Seeders\AuthTableSeeder;

uses(RefreshDatabase::class);

beforeEach(function (): void {
    $this->seed(AuthTableSeeder::class);

    $this->admin = User::factory()->create();
    $this->admin->assignRole(config('shopper.admin.roles.admin'));

    $this->product = Product::factory()->variant()->create(['slug' => 'tee', 'sku' => 'TEE']);

    $this->size = Attribute::factory()->create(['name' => 'Size', 'type' => FieldType::Select]);
    $this->small = AttributeValue::factory()->create(['attribute_id' => $this->size->id, 'value' => 'S']);
    $this->medium = AttributeValue::factory()->create(['attribute_id' => $this->size->id, 'value' => 'M']);

    $this->material = Attribute::factory()->create(['name' => 'Material', 'type' => FieldType::Select]);
    $this->cotton = AttributeValue::factory()->create(['attribute_id' => $this->material->id, 'value' => 'Cotton']);

    foreach ([$this->small, $this->medium] as $value) {
        AttributeProduct::create([
            'product_id' => $this->product->id,
            'attribute_id' => $this->size->id,
            'attribute_value_id' => $value->id,
            'is_variant_option' => true,
        ]);
    }

    AttributeProduct::create([
        'product_id' => $this->product->id,
        'attribute_id' => $this->material->id,
        'attribute_value_id' => $this->cotton->id,
    ]);
});

test('only attributes marked for variants are offered when adding a variant', function (): void {
    $currency = Currency::query()->create(['name' => 'Hryvnia', 'code' => 'UAH', 'symbol' => '₴', 'format' => '1,234.56 ₴']);
    Setting::query()->create(['key' => 'currencies', 'display_name' => 'Currencies', 'value' => [$currency->id], 'locked' => true]);
    Cache::forget('shopper-setting.currencies');

    $component = Livewire::actingAs($this->admin)
        ->test(AddVariant::class, ['product' => $this->product])
        ->assertSuccessful();

    expect($component->instance()->options->pluck('name')->all())->toBe(['Size']);

    $component
        ->set('data.name', 'Tee S')
        ->set("data.values.{$this->size->id}", $this->small->id)
        ->call('save')
        ->assertHasNoFormErrors();

    $variant = ProductVariant::query()->where('product_id', $this->product->id)->sole();

    expect($variant->values->pluck('id')->all())->toBe([$this->small->id]);
});

test('variants are generated only from attributes marked for variants', function (): void {
    $component = Livewire::actingAs($this->admin)
        ->test(GenerateVariants::class, ['product' => $this->product]);

    $variants = $component->get('variants');

    expect(collect($component->get('availableOptions'))->pluck('name')->all())->toBe(['Size'])
        ->and($variants)->toHaveCount(2)
        ->and(collect($variants)->pluck('name')->all())->toBe(['S', 'M'])
        ->and(collect($variants)->pluck('values')->all())->toBe([[$this->small->id], [$this->medium->id]]);
});

test('nothing is generated when no attribute is marked for variants', function (): void {
    AttributeProduct::query()->update(['is_variant_option' => false]);

    Livewire::actingAs($this->admin)
        ->test(GenerateVariants::class, ['product' => $this->product])
        ->assertSet('variants', []);
});

test('choosing attributes saves the variant flag and defaults to off', function (): void {
    $color = Attribute::factory()->create(['name' => 'Color', 'type' => FieldType::Select]);
    $red = AttributeValue::factory()->create(['attribute_id' => $color->id, 'value' => 'Red']);
    $origin = Attribute::factory()->create(['name' => 'Origin', 'type' => FieldType::Select]);
    $ukraine = AttributeValue::factory()->create(['attribute_id' => $origin->id, 'value' => 'Ukraine']);

    Livewire::actingAs($this->admin)
        ->test(ChooseProductAttributes::class, ['product' => $this->product])
        ->set('data.attributes', [$color->id, $origin->id])
        ->set('data.values', [$color->id => $red->id, $origin->id => $ukraine->id])
        ->set("data.variant_options.{$color->id}", true)
        ->call('store')
        ->assertHasNoFormErrors();

    expect(AttributeProduct::isVariantOption($this->product->id, $color->id))->toBeTrue()
        ->and(AttributeProduct::isVariantOption($this->product->id, $origin->id))->toBeFalse()
        ->and(AttributeProduct::query()->where('product_id', $this->product->id)->where('attribute_id', $origin->id)->exists())->toBeTrue();
});

test('the attributes table toggle updates every row of the attribute', function (): void {
    $row = AttributeProduct::query()->where('attribute_id', $this->material->id)->sole();

    Livewire::withoutLazyLoading()
        ->actingAs($this->admin)
        ->test(Attributes::class, ['product' => $this->product])
        ->call('updateTableColumnState', 'is_variant_option', (string) $row->id, true);

    expect(AttributeProduct::isVariantOption($this->product->id, $this->material->id))->toBeTrue();

    $sizeRow = AttributeProduct::query()->where('attribute_id', $this->size->id)->first();

    Livewire::withoutLazyLoading()
        ->actingAs($this->admin)
        ->test(Attributes::class, ['product' => $this->product])
        ->call('updateTableColumnState', 'is_variant_option', (string) $sizeRow->id, false);

    expect(AttributeProduct::query()->where('attribute_id', $this->size->id)->where('is_variant_option', true)->count())->toBe(0);
});

test('the variant flag cannot be turned off while variants use the attribute', function (): void {
    $variant = ProductVariant::factory()->create(['product_id' => $this->product->id]);
    $variant->values()->attach($this->small->id);

    $sizeRow = AttributeProduct::query()->where('attribute_id', $this->size->id)->first();

    Livewire::withoutLazyLoading()
        ->actingAs($this->admin)
        ->test(Attributes::class, ['product' => $this->product])
        ->call('updateTableColumnState', 'is_variant_option', (string) $sizeRow->id, false)
        ->assertNotified(__('backend.variant_options.locked'));

    expect(AttributeProduct::query()->where('attribute_id', $this->size->id)->where('is_variant_option', true)->count())->toBe(2);
});

test('reimporting product attributes keeps the variant flag', function (): void {
    resolve(ImportsProductRow::class)->import(new ProductImportRow(
        product: new ProductRow(
            handle: 'tee',
            name: 'Tee',
            published: true,
            optionNames: ['Color'],
            variants: [new VariantRow(options: ['Color' => 'Blue'], sku: 'TEE-BLUE')],
        ),
        attributes: ['Size' => ['M'], 'Material' => ['Linen']],
        sku: 'TEE',
    ));

    expect(AttributeProduct::query()->where('attribute_id', $this->size->id)->pluck('is_variant_option')->all())->toBe([true])
        ->and(AttributeProduct::query()->where('attribute_id', $this->material->id)->pluck('is_variant_option')->all())->toBe([false]);
});
