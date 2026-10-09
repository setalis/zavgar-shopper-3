<?php

declare(strict_types=1);

namespace App\Actions\Catalog;

use App\Models\Category;
use App\Models\CategoryFilterGroup;
use Illuminate\Database\Eloquent\Collection;

final class ResolveCategoryFilterSchema
{
    /**
     * @return array{category: Category, groups: Collection<int, CategoryFilterGroup>}|null
     */
    public function handle(Category $category): ?array
    {
        $current = $category;

        while ($current instanceof Category) {
            $groups = $current->filterGroups()
                ->with([
                    'parameters' => fn ($query) => $query->orderBy('position')->with('attribute'),
                ])
                ->orderBy('position')
                ->get();

            if ($groups->isNotEmpty()) {
                return [
                    'category' => $current,
                    'groups' => $groups,
                ];
            }

            if ($current->parent_id === null) {
                break;
            }

            $current = Category::query()->find($current->parent_id);
        }

        return null;
    }

    public function inheritedFrom(Category $category): ?Category
    {
        $resolved = $this->handle($category);

        if ($resolved === null) {
            return null;
        }

        return $resolved['category']->is($category) ? null : $resolved['category'];
    }
}
