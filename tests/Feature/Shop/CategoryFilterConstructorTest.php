<?php

declare(strict_types=1);

use App\Enums\CategoryFilterParameterType;
use App\Models\Brand;
use App\Models\Category;
use App\Models\CategoryFilterGroup;
use App\Models\Collection;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Shopper\Core\Enum\CollectionType;
use Shopper\Core\Enum\DiscountApplyTo;
use Shopper\Core\Enum\DiscountCondition;
use Shopper\Core\Enum\DiscountEligibility;
use Shopper\Core\Enum\DiscountRequirement;
use Shopper\Core\Enum\DiscountType;
use Shopper\Core\Enum\FieldType;
use Shopper\Core\Models\Attribute;
use Shopper\Core\Models\AttributeValue;
use Shopper\Core\Models\Currency;
use Shopper\Core\Models\Discount;
use Shopper\Core\Models\Price;
use Shopper\Core\Models\Setting;

uses(RefreshDatabase::class);

beforeEach(function (): void {
    $currency = Currency::query()->create([
        'name' => 'US Dollar',
        'code' => 'USD',
        'symbol' => '$',
        'format' => '$1,234.56',
    ]);

    Setting::query()->create([
        'key' => 'default_currency_id',
        'display_name' => 'Currency',
        'value' => $currency->id,
        'locked' => true,
    ]);

    Cache::forget('shopper-setting.default_currency_id');
    Cache::forget('shopper-setting.default_currency');

    $this->currency = $currency;
});

test('empty filter schema keeps automatic attribute facets', function (): void {
    $category = Category::factory()->create([
        'name' => 'Oils',
        'slug' => 'oils',
        'is_enabled' => true,
        'parent_id' => null,
    ]);
    $brand = Brand::factory()->create([
        'name' => 'Castrol',
        'slug' => 'castrol',
        'is_enabled' => true,
    ]);
    $product = Product::factory()->standard()->create([
        'name' => 'Castrol 5W-40',
        'slug' => 'castrol-5w-40',
        'brand_id' => $brand->id,
    ]);
    $product->categories()->attach($category);

    $this->get(route('shop.category', $category))
        ->assertOk()
        ->assertInertia(fn ($page) => $page
            ->component('shop/category')
            ->has('filterGroups', 1)
            ->where('filterGroups.0.name', null)
            ->where('filterGroups.0.parameters.0.slug', 'price')
            ->where('filterGroups.0.parameters.0.expanded', true)
            ->where('attributeFilters.0.slug', 'brand')
        );
});

test('child category inherits parent filter groups', function (): void {
    $parent = Category::factory()->create([
        'name' => 'Oils',
        'slug' => 'oils',
        'is_enabled' => true,
        'parent_id' => null,
    ]);
    $child = Category::factory()->create([
        'name' => 'Synthetic',
        'slug' => 'synthetic',
        'is_enabled' => true,
        'parent_id' => $parent->id,
    ]);
    $brand = Brand::factory()->create([
        'name' => 'Castrol',
        'slug' => 'castrol',
        'is_enabled' => true,
    ]);
    $product = Product::factory()->standard()->create([
        'name' => 'Castrol 5W-40',
        'slug' => 'castrol-5w-40',
        'brand_id' => $brand->id,
    ]);
    $product->categories()->attach($child);

    $group = CategoryFilterGroup::factory()->create([
        'category_id' => $parent->id,
        'name' => 'Main',
        'position' => 0,
    ]);
    $group->parameters()->create([
        'type' => CategoryFilterParameterType::Brand,
        'position' => 0,
    ]);

    $this->get(route('shop.category', $child))
        ->assertOk()
        ->assertInertia(fn ($page) => $page
            ->has('filterGroups', 1)
            ->where('filterGroups.0.name', 'Main')
            ->where('filterGroups.0.parameters.0.slug', 'brand')
            ->missing('filterGroups.0.parameters.1')
        );
});

test('child category filter groups override the parent schema', function (): void {
    $parent = Category::factory()->create([
        'name' => 'Oils',
        'slug' => 'oils',
        'is_enabled' => true,
        'parent_id' => null,
    ]);
    $child = Category::factory()->create([
        'name' => 'Synthetic',
        'slug' => 'synthetic',
        'is_enabled' => true,
        'parent_id' => $parent->id,
    ]);
    $brand = Brand::factory()->create([
        'name' => 'Castrol',
        'slug' => 'castrol',
        'is_enabled' => true,
    ]);
    $product = Product::factory()->standard()->create([
        'name' => 'Castrol 5W-40',
        'slug' => 'castrol-5w-40',
        'brand_id' => $brand->id,
    ]);
    $product->categories()->attach($child);

    $parentGroup = CategoryFilterGroup::factory()->create([
        'category_id' => $parent->id,
        'name' => 'Parent',
        'position' => 0,
    ]);
    $parentGroup->parameters()->create([
        'type' => CategoryFilterParameterType::Brand,
        'position' => 0,
    ]);

    $childGroup = CategoryFilterGroup::factory()->create([
        'category_id' => $child->id,
        'name' => 'Child',
        'position' => 0,
    ]);
    $childGroup->parameters()->create([
        'type' => CategoryFilterParameterType::Price,
        'position' => 0,
    ]);

    $this->get(route('shop.category', $child))
        ->assertOk()
        ->assertInertia(fn ($page) => $page
            ->has('filterGroups', 1)
            ->where('filterGroups.0.name', 'Child')
            ->where('filterGroups.0.parameters.0.slug', 'price')
            ->has('attributeFilters', 0)
        );
});

test('configured groups keep their parameter order and hide price when it is omitted', function (): void {
    $category = Category::factory()->create([
        'name' => 'Oils',
        'slug' => 'oils',
        'is_enabled' => true,
        'parent_id' => null,
    ]);
    $brand = Brand::factory()->create([
        'name' => 'Castrol',
        'slug' => 'castrol',
        'is_enabled' => true,
    ]);
    $viscosity = Attribute::factory()->create([
        'name' => 'Viscosity',
        'slug' => 'viscosity',
        'type' => FieldType::Text,
        'is_enabled' => true,
        'is_filterable' => true,
    ]);
    $product = Product::factory()->standard()->create([
        'name' => 'Castrol 5W-40',
        'slug' => 'castrol-5w-40',
        'brand_id' => $brand->id,
    ]);
    $product->categories()->attach($category);
    $product->options()->attach($viscosity->id, [
        'attribute_custom_value' => '5W-40',
    ]);
    Price::query()->create([
        'priceable_type' => 'product',
        'priceable_id' => $product->id,
        'amount' => 1000,
        'compare_amount' => null,
        'cost_amount' => null,
        'currency_id' => $this->currency->id,
    ]);

    $first = CategoryFilterGroup::factory()->create([
        'category_id' => $category->id,
        'name' => 'Specs',
        'position' => 0,
    ]);
    $first->parameters()->create([
        'type' => CategoryFilterParameterType::Attribute,
        'attribute_id' => $viscosity->id,
        'position' => 0,
    ]);
    $first->parameters()->create([
        'type' => CategoryFilterParameterType::Brand,
        'position' => 1,
    ]);

    $second = CategoryFilterGroup::factory()->create([
        'category_id' => $category->id,
        'name' => 'Extra',
        'position' => 1,
    ]);
    $second->parameters()->create([
        'type' => CategoryFilterParameterType::Collection,
        'position' => 0,
    ]);

    $this->get(route('shop.category', $category))
        ->assertOk()
        ->assertInertia(fn ($page) => $page
            ->has('filterGroups', 2)
            ->where('filterGroups.0.name', 'Specs')
            ->where('filterGroups.0.parameters.0.slug', 'viscosity')
            ->where('filterGroups.0.parameters.1.slug', 'brand')
            ->where('filterGroups.1.name', 'Extra')
            ->where('priceRange', null)
            ->has('attributeFilters', 2)
        );
});

test('sale discount filter keeps products with a compare-at price', function (): void {
    $category = Category::factory()->create([
        'name' => 'Oils',
        'slug' => 'oils',
        'is_enabled' => true,
        'parent_id' => null,
    ]);
    $sale = Product::factory()->standard()->create([
        'name' => 'Sale oil',
        'slug' => 'sale-oil',
        'created_at' => now()->subDay(),
    ]);
    $regular = Product::factory()->standard()->create([
        'name' => 'Regular oil',
        'slug' => 'regular-oil',
    ]);
    $sale->categories()->attach($category);
    $regular->categories()->attach($category);

    Price::query()->create([
        'priceable_type' => 'product',
        'priceable_id' => $sale->id,
        'amount' => 800,
        'compare_amount' => 1200,
        'cost_amount' => null,
        'currency_id' => $this->currency->id,
    ]);
    Price::query()->create([
        'priceable_type' => 'product',
        'priceable_id' => $regular->id,
        'amount' => 1000,
        'compare_amount' => null,
        'cost_amount' => null,
        'currency_id' => $this->currency->id,
    ]);

    $group = CategoryFilterGroup::factory()->create([
        'category_id' => $category->id,
        'name' => 'Deals',
        'position' => 0,
    ]);
    $group->parameters()->create([
        'type' => CategoryFilterParameterType::Discount,
        'position' => 0,
    ]);

    $this->get(route('shop.category', [
        'category' => $category,
        'attrs' => ['discount' => ['sale']],
    ]))
        ->assertOk()
        ->assertInertia(fn ($page) => $page
            ->has('products.data', 1)
            ->where('products.data.0.id', $sale->id)
            ->where('filterGroups.0.parameters.0.slug', 'discount')
            ->where('filterGroups.0.parameters.0.values.0.key', 'sale')
        );
});

test('named discount filter keeps products attached to that discount', function (): void {
    $category = Category::factory()->create([
        'name' => 'Oils',
        'slug' => 'oils',
        'is_enabled' => true,
        'parent_id' => null,
    ]);
    $promo = Product::factory()->standard()->create([
        'name' => 'Promo oil',
        'slug' => 'promo-oil',
        'created_at' => now()->subDay(),
    ]);
    $other = Product::factory()->standard()->create([
        'name' => 'Other oil',
        'slug' => 'other-oil',
    ]);
    $promo->categories()->attach($category);
    $other->categories()->attach($category);

    $discount = Discount::factory()->forProduct()->create([
        'code' => 'SUMMER10',
        'is_active' => true,
        'type' => DiscountType::Percentage,
        'value' => 10,
        'min_required' => DiscountRequirement::None->value,
        'eligibility' => DiscountEligibility::Everyone->value,
        'start_at' => now()->subHour(),
        'end_at' => now()->addMonth(),
        'apply_to' => DiscountApplyTo::Products->value,
    ]);
    $discount->items()->create([
        'condition' => DiscountCondition::ApplyTo,
        'discountable_type' => $promo->getMorphClass(),
        'discountable_id' => $promo->id,
    ]);

    $group = CategoryFilterGroup::factory()->create([
        'category_id' => $category->id,
        'name' => 'Deals',
        'position' => 0,
    ]);
    $group->parameters()->create([
        'type' => CategoryFilterParameterType::Discount,
        'position' => 0,
    ]);

    $this->get(route('shop.category', [
        'category' => $category,
        'attrs' => ['discount' => ['d-'.$discount->id]],
    ]))
        ->assertOk()
        ->assertInertia(fn ($page) => $page
            ->has('products.data', 1)
            ->where('products.data.0.id', $promo->id)
            ->where('filterGroups.0.parameters.0.values.0.key', 'd-'.$discount->id)
        );
});

test('collection filter keeps products that belong to the selected collection', function (): void {
    $category = Category::factory()->create([
        'name' => 'Oils',
        'slug' => 'oils',
        'is_enabled' => true,
        'parent_id' => null,
    ]);
    $collection = Collection::factory()->create([
        'name' => 'Summer',
        'slug' => 'summer',
        'type' => CollectionType::Manual,
        'published_at' => now()->subDay(),
    ]);
    $inside = Product::factory()->standard()->create([
        'name' => 'Summer oil',
        'slug' => 'summer-oil',
        'created_at' => now()->subDay(),
    ]);
    $outside = Product::factory()->standard()->create([
        'name' => 'Winter oil',
        'slug' => 'winter-oil',
    ]);
    $inside->categories()->attach($category);
    $outside->categories()->attach($category);
    $collection->products()->attach($inside);

    $group = CategoryFilterGroup::factory()->create([
        'category_id' => $category->id,
        'name' => 'Sets',
        'position' => 0,
    ]);
    $group->parameters()->create([
        'type' => CategoryFilterParameterType::Collection,
        'position' => 0,
    ]);

    $this->get(route('shop.category', [
        'category' => $category,
        'attrs' => ['collection' => ['summer']],
    ]))
        ->assertOk()
        ->assertInertia(fn ($page) => $page
            ->has('products.data', 1)
            ->where('products.data.0.id', $inside->id)
            ->where('filterGroups.0.parameters.0.values.0.key', 'summer')
        );
});

test('category filter lists child categories and narrows products to the selected child', function (): void {
    $parent = Category::factory()->create([
        'name' => 'Oils',
        'slug' => 'oils',
        'is_enabled' => true,
        'parent_id' => null,
    ]);
    $synthetic = Category::factory()->create([
        'name' => 'Synthetic',
        'slug' => 'synthetic',
        'is_enabled' => true,
        'parent_id' => $parent->id,
    ]);
    $mineral = Category::factory()->create([
        'name' => 'Mineral',
        'slug' => 'mineral',
        'is_enabled' => true,
        'parent_id' => $parent->id,
    ]);
    $syntheticProduct = Product::factory()->standard()->create([
        'name' => 'Synthetic oil',
        'slug' => 'synthetic-oil',
        'created_at' => now()->subDay(),
    ]);
    $mineralProduct = Product::factory()->standard()->create([
        'name' => 'Mineral oil',
        'slug' => 'mineral-oil',
    ]);
    $syntheticProduct->categories()->attach($synthetic);
    $mineralProduct->categories()->attach($mineral);

    $group = CategoryFilterGroup::factory()->create([
        'category_id' => $parent->id,
        'name' => 'Type',
        'position' => 0,
    ]);
    $group->parameters()->create([
        'type' => CategoryFilterParameterType::Category,
        'position' => 0,
    ]);

    $this->get(route('shop.category', $parent))
        ->assertOk()
        ->assertInertia(fn ($page) => $page
            ->has('products.data', 2)
            ->where('filterGroups.0.parameters.0.slug', 'category')
            ->has('filterGroups.0.parameters.0.values', 2)
        );

    $this->get(route('shop.category', [
        'category' => $parent,
        'attrs' => ['category' => [$synthetic->slug]],
    ]))
        ->assertOk()
        ->assertInertia(fn ($page) => $page
            ->has('products.data', 1)
            ->where('products.data.0.id', $syntheticProduct->id)
            ->where('filters.attrs.category.0', $synthetic->slug)
        );
});

test('parent category includes child products and their automatic attribute filters', function (): void {
    $parent = Category::factory()->create([
        'name' => 'Oils',
        'slug' => 'oils',
        'is_enabled' => true,
        'parent_id' => null,
    ]);
    $child = Category::factory()->create([
        'name' => 'Synthetic',
        'slug' => 'synthetic',
        'is_enabled' => true,
        'parent_id' => $parent->id,
    ]);
    $viscosity = Attribute::factory()->create([
        'name' => 'Viscosity',
        'slug' => 'viscosity',
        'type' => FieldType::Text,
        'is_enabled' => true,
        'is_filterable' => true,
    ]);
    $product = Product::factory()->standard()->create([
        'name' => 'Castrol 5W-40',
        'slug' => 'castrol-5w-40',
        'created_at' => now()->subDay(),
    ]);
    $product->categories()->attach($child);
    $product->options()->attach($viscosity->id, [
        'attribute_custom_value' => '5W-40',
    ]);

    $this->get(route('shop.category', $parent))
        ->assertOk()
        ->assertInertia(fn ($page) => $page
            ->has('products.data', 1)
            ->where('products.data.0.id', $product->id)
            ->where('filterGroups.0.parameters.1.slug', 'viscosity')
            ->where('filterGroups.0.parameters.1.values.0.key', '5W-40')
        );
});

test('configured parent attributes include values from child category products', function (): void {
    $parent = Category::factory()->create([
        'name' => 'Oils',
        'slug' => 'oils',
        'is_enabled' => true,
        'parent_id' => null,
    ]);
    $child = Category::factory()->create([
        'name' => 'Motor oil',
        'slug' => 'motor-oil',
        'is_enabled' => true,
        'parent_id' => $parent->id,
    ]);
    $sae = Attribute::factory()->create([
        'name' => 'SAE',
        'slug' => 'sae',
        'type' => FieldType::Select,
        'is_enabled' => true,
        'is_filterable' => false,
    ]);
    $fiveWForty = AttributeValue::factory()->create([
        'attribute_id' => $sae->id,
        'key' => '5w-40',
        'value' => '5W-40',
        'position' => 1,
    ]);
    $product = Product::factory()->standard()->create([
        'name' => 'Castrol 5W-40',
        'slug' => 'castrol-5w-40',
    ]);
    $product->categories()->attach($child);
    $product->options()->attach($sae->id, [
        'attribute_value_id' => $fiveWForty->id,
    ]);

    $group = CategoryFilterGroup::factory()->create([
        'category_id' => $parent->id,
        'name' => 'Specs',
        'position' => 0,
    ]);
    $group->parameters()->create([
        'type' => CategoryFilterParameterType::Attribute,
        'attribute_id' => $sae->id,
        'position' => 0,
    ]);

    $this->get(route('shop.category', $parent))
        ->assertOk()
        ->assertInertia(fn ($page) => $page
            ->has('filterGroups', 1)
            ->where('filterGroups.0.name', 'Specs')
            ->where('filterGroups.0.parameters.0.slug', 'sae')
            ->where('filterGroups.0.parameters.0.values.0.key', '5w-40')
            ->where('filterGroups.0.parameters.0.values.0.label', '5W-40')
            ->where('filterGroups.0.parameters.0.expanded', true)
        );
});

test('configured parameters keep their expanded state on the storefront', function (): void {
    $category = Category::factory()->create([
        'name' => 'Oils',
        'slug' => 'oils',
        'is_enabled' => true,
        'parent_id' => null,
    ]);
    $brand = Brand::factory()->create([
        'name' => 'Castrol',
        'slug' => 'castrol',
        'is_enabled' => true,
    ]);
    $product = Product::factory()->standard()->create([
        'name' => 'Castrol 5W-40',
        'slug' => 'castrol-5w-40',
        'brand_id' => $brand->id,
    ]);
    $product->categories()->attach($category);

    $group = CategoryFilterGroup::factory()->create([
        'category_id' => $category->id,
        'name' => 'Main',
        'position' => 0,
    ]);
    $group->parameters()->create([
        'type' => CategoryFilterParameterType::Brand,
        'is_expanded' => false,
        'position' => 0,
    ]);
    $group->parameters()->create([
        'type' => CategoryFilterParameterType::Price,
        'is_expanded' => true,
        'position' => 1,
    ]);

    $this->get(route('shop.category', $category))
        ->assertOk()
        ->assertInertia(fn ($page) => $page
            ->where('filterGroups.0.parameters.0.slug', 'brand')
            ->where('filterGroups.0.parameters.0.expanded', false)
            ->where('filterGroups.0.parameters.1.slug', 'price')
            ->where('filterGroups.0.parameters.1.expanded', true)
        );
});
