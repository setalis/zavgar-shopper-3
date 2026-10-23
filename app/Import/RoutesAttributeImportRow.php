<?php

declare(strict_types=1);

namespace App\Import;

use App\Enums\AttributeImportRowOutcome;
use App\Enums\PendingAttributeStatus;
use App\Models\PendingAttribute;
use Illuminate\Support\Facades\DB;
use Shopper\Core\Models\Attribute;

final class RoutesAttributeImportRow
{
    public function __construct(
        private ImportsAttributeRows $imports,
    ) {}

    public function route(AttributeImportRow $row): AttributeImportRowOutcome
    {
        $attribute = Attribute::query()->where('slug', $row->slug)->first();

        if ($attribute instanceof Attribute) {
            $this->imports->save($row, $attribute);
            PendingAttribute::query()->where('slug', $row->slug)->delete();

            return AttributeImportRowOutcome::Updated;
        }

        PendingAttribute::updateOrCreate(
            ['slug' => $row->slug],
            [
                ...PendingAttribute::attributesFromImportRow($row),
                'status' => PendingAttributeStatus::Pending,
                'error' => null,
            ],
        );

        return AttributeImportRowOutcome::Queued;
    }

    public function outcome(AttributeImportRow $row): AttributeImportRowOutcome
    {
        $attribute = Attribute::query()->where('slug', $row->slug)->first();

        if (! $attribute instanceof Attribute) {
            return AttributeImportRowOutcome::Queued;
        }

        $this->imports->guardTypeChange($attribute, $row);

        return AttributeImportRowOutcome::Updated;
    }

    public function create(PendingAttribute $pending): void
    {
        DB::transaction(function () use ($pending): void {
            $row = $pending->importRow();
            $attribute = Attribute::query()->where('slug', $row->slug)->first();

            $this->imports->save($row, $attribute instanceof Attribute ? $attribute : null);
            $pending->delete();
        });
    }
}
