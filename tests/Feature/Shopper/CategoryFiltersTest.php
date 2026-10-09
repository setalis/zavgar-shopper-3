<?php

declare(strict_types=1);

use App\Enums\CategoryFilterParameterType;
use App\Livewire\Shopper\Pages\CategoryFilters\Edit;
use App\Models\Category;
use App\Models\CategoryFilterGroup;
use App\Models\CategoryFilterParameter;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Shopper\Core\Enum\FieldType;
use Shopper\Core\Models\Attribute;
use Shopper\Database\Seeders\AuthTableSeeder;

uses(RefreshDatabase::class);

beforeEach(function (): void {
    $this->seed(AuthTableSeeder::class);

    $this->admin = User::factory()->create();
    $this->admin->assignRole(config('shopper.admin.roles.admin'));
});

test('guests cannot open the category filter constructor', function (): void {
    $category = Category::factory()->create([
        'name' => 'Oils',
        'slug' => 'oils',
        'is_enabled' => true,
    ]);

    $this->get(route('shopper.categories.filters', $category))->assertRedirect();
});

test('users without permission cannot open the category filter constructor', function (): void {
    $user = User::factory()->create();
    $category = Category::factory()->create([
        'name' => 'Oils',
        'slug' => 'oils',
        'is_enabled' => true,
    ]);

    $this->actingAs($user)
        ->get(route('shopper.categories.filters', $category))
        ->assertRedirect();
});

test('admins can save ordered filter groups and parameters', function (): void {
    $category = Category::factory()->create([
        'name' => 'Oils',
        'slug' => 'oils',
        'is_enabled' => true,
    ]);
    $viscosity = Attribute::factory()->create([
        'name' => 'Viscosity',
        'slug' => 'viscosity',
        'type' => FieldType::Text,
        'is_enabled' => true,
        'is_filterable' => true,
    ]);

    Livewire::actingAs($this->admin)
        ->test(Edit::class, ['category' => $category])
        ->set('data.groups', [
            [
                'name' => 'Availability',
                'parameters' => [
                    ['type' => CategoryFilterParameterType::Price->value],
                    ['type' => CategoryFilterParameterType::Discount->value],
                ],
            ],
            [
                'name' => 'Specs',
                'parameters' => [
                    ['type' => CategoryFilterParameterType::Brand->value],
                    [
                        'type' => CategoryFilterParameterType::Attribute->value,
                        'attribute_id' => $viscosity->id,
                    ],
                ],
            ],
        ])
        ->call('store')
        ->assertHasNoErrors();

    $groups = CategoryFilterGroup::query()
        ->where('category_id', $category->id)
        ->orderBy('position')
        ->with(['parameters' => fn ($query) => $query->orderBy('position')])
        ->get();

    expect($groups)->toHaveCount(2)
        ->and($groups[0]->name)->toBe('Availability')
        ->and($groups[0]->parameters->pluck('type')->all())->toBe([
            CategoryFilterParameterType::Price,
            CategoryFilterParameterType::Discount,
        ])
        ->and($groups[1]->name)->toBe('Specs')
        ->and($groups[1]->parameters[0]->type)->toBe(CategoryFilterParameterType::Brand)
        ->and($groups[1]->parameters[1]->attribute_id)->toBe($viscosity->id);
});

test('admins can save a collapsed storefront parameter', function (): void {
    $category = Category::factory()->create([
        'name' => 'Oils',
        'slug' => 'oils',
        'is_enabled' => true,
    ]);

    Livewire::actingAs($this->admin)
        ->test(Edit::class, ['category' => $category])
        ->set('data.groups', [
            [
                'name' => 'Main',
                'parameters' => [
                    [
                        'type' => CategoryFilterParameterType::Brand->value,
                        'is_expanded' => false,
                    ],
                    [
                        'type' => CategoryFilterParameterType::Price->value,
                        'is_expanded' => true,
                    ],
                ],
            ],
        ])
        ->call('store')
        ->assertHasNoErrors();

    $parameters = CategoryFilterParameter::query()
        ->orderBy('position')
        ->get();

    expect($parameters)->toHaveCount(2)
        ->and($parameters[0]->type)->toBe(CategoryFilterParameterType::Brand)
        ->and($parameters[0]->is_expanded)->toBeFalse()
        ->and($parameters[1]->type)->toBe(CategoryFilterParameterType::Price)
        ->and($parameters[1]->is_expanded)->toBeTrue();
});

test('admins cannot save the same parameter twice', function (): void {
    $category = Category::factory()->create([
        'name' => 'Oils',
        'slug' => 'oils',
        'is_enabled' => true,
    ]);

    Livewire::actingAs($this->admin)
        ->test(Edit::class, ['category' => $category])
        ->set('data.groups', [
            [
                'name' => 'Main',
                'parameters' => [
                    ['type' => CategoryFilterParameterType::Brand->value],
                    ['type' => CategoryFilterParameterType::Brand->value],
                ],
            ],
        ])
        ->call('store')
        ->assertHasErrors(['groups']);

    expect(CategoryFilterParameter::query()->count())->toBe(0);
});
