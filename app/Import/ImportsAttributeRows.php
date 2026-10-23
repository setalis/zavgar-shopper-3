<?php

declare(strict_types=1);

namespace App\Import;

use Illuminate\Support\Facades\DB;
use Shopper\Core\Models\Attribute;
use Shopper\Core\Models\AttributeValue;

final class ImportsAttributeRows
{
    public function save(AttributeImportRow $row, ?Attribute $attribute = null): Attribute
    {
        return DB::transaction(function () use ($row, $attribute): Attribute {
            if ($attribute instanceof Attribute) {
                $this->guardTypeChange($attribute, $row);

                $attribute->update([
                    'name' => $row->name,
                    'description' => $row->description,
                    'type' => $row->type,
                    'is_enabled' => $row->isEnabled,
                    'is_searchable' => $row->isSearchable,
                    'is_filterable' => $row->isFilterable,
                    'icon' => $row->icon,
                ]);
            } else {
                $attribute = Attribute::create([
                    'name' => $row->name,
                    'slug' => $row->slug,
                    'description' => $row->description,
                    'type' => $row->type,
                    'is_enabled' => $row->isEnabled,
                    'is_searchable' => $row->isSearchable,
                    'is_filterable' => $row->isFilterable,
                    'icon' => $row->icon,
                ]);
            }

            $this->syncValues($attribute, $row);

            return $attribute;
        });
    }

    public function guardTypeChange(Attribute $attribute, AttributeImportRow $row): void
    {
        if ($attribute->type === $row->type) {
            return;
        }

        if ($attribute->values()->exists() || $attribute->products()->exists()) {
            throw new AttributeImportException(__('backend.attribute_imports.type_locked', [
                'name' => $attribute->name,
            ]));
        }
    }

    private function syncValues(Attribute $attribute, AttributeImportRow $row): void
    {
        if (! in_array($attribute->type, Attribute::fieldsWithValues(), true)) {
            return;
        }

        foreach ($row->values as $position => $value) {
            AttributeValue::updateOrCreate(
                [
                    'attribute_id' => $attribute->id,
                    'key' => $value['key'],
                ],
                [
                    'value' => $value['value'],
                    'position' => $position + 1,
                ],
            );
        }
    }
}
