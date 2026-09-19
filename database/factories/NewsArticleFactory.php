<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\NewsArticle;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<NewsArticle>
 */
final class NewsArticleFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = fake()->unique()->sentence(4);

        return [
            'title' => $title,
            'slug' => str($title)->slug()->toString(),
            'summary' => fake()->sentence(12),
            'description' => '<p>'.fake()->paragraph().'</p>',
            'seo_title' => null,
            'seo_description' => null,
            'is_enabled' => true,
            'published_at' => now()->subHour(),
        ];
    }

    public function published(): static
    {
        return $this->state(fn (array $attributes): array => [
            'is_enabled' => true,
            'published_at' => now()->subHour(),
        ]);
    }

    public function draft(): static
    {
        return $this->state(fn (array $attributes): array => [
            'is_enabled' => false,
            'published_at' => null,
        ]);
    }

    public function scheduled(): static
    {
        return $this->state(fn (array $attributes): array => [
            'is_enabled' => true,
            'published_at' => now()->addDay(),
        ]);
    }
}
