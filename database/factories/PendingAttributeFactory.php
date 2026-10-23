<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\PendingAttributeStatus;
use App\Import\AttributeImportRow;
use App\Models\PendingAttribute;
use Illuminate\Database\Eloquent\Factories\Factory;
use Shopper\Core\Enum\FieldType;

/**
 * @extends Factory<PendingAttribute>
 */
final class PendingAttributeFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->words(2, true);
        $slug = str($name)->slug()->toString() ?: fake()->unique()->slug();

        return [
            ...PendingAttribute::attributesFromImportRow(new AttributeImportRow(
                line: 2,
                name: $name,
                slug: $slug,
                description: null,
                type: FieldType::Select,
                isEnabled: true,
                isSearchable: false,
                isFilterable: false,
                icon: null,
                values: [['key' => 'm', 'value' => 'M']],
            )),
            'status' => PendingAttributeStatus::Pending,
        ];
    }
}
