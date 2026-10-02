<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\PendingProductStatus;
use App\Import\ProductImportRow;
use App\Models\PendingProduct;
use Illuminate\Database\Eloquent\Factories\Factory;
use Shopper\Core\Import\ProductRow;
use Shopper\Core\Import\VariantRow;

/**
 * @extends Factory<PendingProduct>
 */
final class PendingProductFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $sku = mb_strtoupper(fake()->unique()->bothify('SKU-####-??'));
        $name = fake()->words(3, true);

        return [
            ...PendingProduct::attributesFromImportRow(new ProductImportRow(
                product: new ProductRow(
                    handle: str($name)->slug()->toString(),
                    name: $name,
                    published: true,
                    variants: [new VariantRow(sku: $sku, price: 100, quantity: 5)],
                ),
                sku: $sku,
            )),
            'status' => PendingProductStatus::Pending,
        ];
    }

    public function failed(string $error = 'Import failed.'): static
    {
        return $this->state(fn (array $attributes): array => [
            'status' => PendingProductStatus::Failed,
            'error' => $error,
        ]);
    }
}
