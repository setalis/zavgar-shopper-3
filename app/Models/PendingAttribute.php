<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\PendingAttributeStatus;
use App\Import\AttributeImportException;
use App\Import\AttributeImportRow;
use Database\Factories\PendingAttributeFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Shopper\Core\Enum\FieldType;

final class PendingAttribute extends Model
{
    /** @use HasFactory<PendingAttributeFactory> */
    use HasFactory;

    protected $fillable = [
        'slug',
        'name',
        'type',
        'payload',
        'status',
        'error',
    ];

    /**
     * @var array<string, mixed>
     */
    protected $attributes = [
        'status' => PendingAttributeStatus::Pending->value,
    ];

    /**
     * @return array{slug: string, name: string, type: FieldType, payload: string}
     */
    public static function attributesFromImportRow(AttributeImportRow $row): array
    {
        return [
            'slug' => $row->slug,
            'name' => $row->name,
            'type' => $row->type,
            'payload' => serialize($row),
        ];
    }

    public function importRow(): AttributeImportRow
    {
        $row = unserialize($this->payload, ['allowed_classes' => true]);

        if (! $row instanceof AttributeImportRow) {
            throw new AttributeImportException(__('backend.attribute_imports.invalid_payload'));
        }

        return $row;
    }

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'type' => FieldType::class,
            'status' => PendingAttributeStatus::class,
        ];
    }
}
