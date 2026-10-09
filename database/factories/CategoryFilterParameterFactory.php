<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\CategoryFilterParameterType;
use App\Models\CategoryFilterGroup;
use App\Models\CategoryFilterParameter;
use Illuminate\Database\Eloquent\Factories\Factory;
use Shopper\Core\Models\Attribute;

/**
 * @extends Factory<CategoryFilterParameter>
 */
final class CategoryFilterParameterFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'group_id' => CategoryFilterGroup::factory(),
            'type' => CategoryFilterParameterType::Brand,
            'attribute_id' => null,
            'is_expanded' => true,
            'position' => 0,
        ];
    }

    public function attribute(?Attribute $attribute = null): static
    {
        return $this->state(fn (array $attributes): array => [
            'type' => CategoryFilterParameterType::Attribute,
            'attribute_id' => $attribute?->id ?? Attribute::factory(),
        ]);
    }

    public function ofType(CategoryFilterParameterType $type): static
    {
        return $this->state(fn (array $attributes): array => [
            'type' => $type,
            'attribute_id' => null,
        ]);
    }

    public function collapsed(): static
    {
        return $this->state(fn (array $attributes): array => [
            'is_expanded' => false,
        ]);
    }
}
