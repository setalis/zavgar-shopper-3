<?php

declare(strict_types=1);

namespace App\Actions\Catalog;

use App\Enums\CategoryFilterParameterType;
use App\Models\Category;
use App\Models\CategoryFilterGroup;
use App\Models\CategoryFilterParameter;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Shopper\Core\Models\Attribute;

final class SaveCategoryFilterSchema
{
    /**
     * @param  list<array{name?: mixed, parameters?: mixed}>  $groups
     */
    public function handle(Category $category, array $groups): void
    {
        $normalized = $this->normalized($groups);

        $this->assertUniqueParameters($normalized);

        DB::transaction(function () use ($category, $normalized): void {
            $category->filterGroups()->delete();

            foreach ($normalized as $groupPosition => $group) {
                $created = CategoryFilterGroup::create([
                    'category_id' => $category->id,
                    'name' => $group['name'],
                    'position' => $groupPosition,
                ]);

                foreach ($group['parameters'] as $parameterPosition => $parameter) {
                    CategoryFilterParameter::create([
                        'group_id' => $created->id,
                        'type' => $parameter['type'],
                        'attribute_id' => $parameter['attribute_id'],
                        'is_expanded' => $parameter['is_expanded'],
                        'position' => $parameterPosition,
                    ]);
                }
            }
        });
    }

    /**
     * @param  list<array{name?: mixed, parameters?: mixed}>  $groups
     * @return list<array{name: string, parameters: list<array{type: CategoryFilterParameterType, attribute_id: int|null, is_expanded: bool}>}>
     */
    private function normalized(array $groups): array
    {
        $normalized = [];

        foreach (array_values($groups) as $group) {
            if (! is_array($group)) {
                continue;
            }

            $name = trim((string) ($group['name'] ?? ''));
            $parameters = is_array($group['parameters'] ?? null) ? array_values($group['parameters']) : [];
            $normalizedParameters = [];

            foreach ($parameters as $parameter) {
                if (! is_array($parameter)) {
                    continue;
                }

                $rawType = $parameter['type'] ?? '';
                $type = $rawType instanceof CategoryFilterParameterType
                    ? $rawType
                    : CategoryFilterParameterType::tryFrom((string) $rawType);

                if (! $type instanceof CategoryFilterParameterType) {
                    continue;
                }

                $attributeId = null;

                if ($type === CategoryFilterParameterType::Attribute) {
                    $attributeId = isset($parameter['attribute_id']) ? (int) $parameter['attribute_id'] : 0;

                    if ($attributeId < 1 || ! Attribute::query()->where('id', $attributeId)->exists()) {
                        throw ValidationException::withMessages([
                            'groups' => __('backend.category_filters.invalid_attribute'),
                        ]);
                    }
                }

                $normalizedParameters[] = [
                    'type' => $type,
                    'attribute_id' => $attributeId,
                    'is_expanded' => array_key_exists('is_expanded', $parameter)
                        ? filter_var($parameter['is_expanded'], FILTER_VALIDATE_BOOLEAN)
                        : true,
                ];
            }

            $normalized[] = [
                'name' => $name === '' ? __('backend.category_filters.untitled_group') : $name,
                'parameters' => $normalizedParameters,
            ];
        }

        return $normalized;
    }

    /**
     * @param  list<array{name: string, parameters: list<array{type: CategoryFilterParameterType, attribute_id: int|null, is_expanded: bool}>}>  $groups
     */
    private function assertUniqueParameters(array $groups): void
    {
        $seen = [];

        foreach ($groups as $group) {
            foreach ($group['parameters'] as $parameter) {
                $key = $parameter['type'] === CategoryFilterParameterType::Attribute
                    ? 'attribute:'.$parameter['attribute_id']
                    : $parameter['type']->value;

                if (isset($seen[$key])) {
                    throw ValidationException::withMessages([
                        'groups' => __('backend.category_filters.duplicate_parameter'),
                    ]);
                }

                $seen[$key] = true;
            }
        }
    }
}
