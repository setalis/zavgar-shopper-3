<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\BlacklistedProduct;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<BlacklistedProduct>
 */
final class BlacklistedProductFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'sku' => mb_strtoupper(fake()->unique()->bothify('SKU-####-??')),
            'name' => fake()->words(3, true),
            'user_id' => null,
        ];
    }
}
