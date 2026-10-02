<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\PendingProductStatus;
use App\Import\ProductImportRow;
use Database\Factories\PendingProductFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Shopper\Core\Models\ProductImport;

final class PendingProduct extends Model
{
    /** @use HasFactory<PendingProductFactory> */
    use HasFactory;

    protected $fillable = [
        'sku',
        'name',
        'product_import_id',
        'payload',
        'status',
        'error',
    ];

    /**
     * @var array<string, mixed>
     */
    protected $attributes = [
        'status' => PendingProductStatus::Pending->value,
    ];

    /**
     * @return array{sku: string, name: string, payload: string}
     */
    public static function attributesFromImportRow(ProductImportRow $row): array
    {
        return [
            'sku' => (string) $row->sku,
            'name' => $row->product->name,
            'payload' => serialize($row),
        ];
    }

    public function importRow(): ProductImportRow
    {
        return unserialize($this->payload, ['allowed_classes' => true]);
    }

    /**
     * @return BelongsTo<ProductImport, $this>
     */
    public function import(): BelongsTo
    {
        return $this->belongsTo(ProductImport::class, 'product_import_id');
    }

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'status' => PendingProductStatus::class,
        ];
    }
}
