<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\CategoryFilterParameterType;
use Database\Factories\CategoryFilterParameterFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Shopper\Core\Models\Attribute;

final class CategoryFilterParameter extends Model
{
    /** @use HasFactory<CategoryFilterParameterFactory> */
    use HasFactory;

    protected $fillable = [
        'group_id',
        'type',
        'attribute_id',
        'is_expanded',
        'position',
    ];

    /**
     * @var array<string, mixed>
     */
    protected $attributes = [
        'is_expanded' => true,
        'position' => 0,
    ];

    /**
     * @return BelongsTo<CategoryFilterGroup, $this>
     */
    public function group(): BelongsTo
    {
        return $this->belongsTo(CategoryFilterGroup::class, 'group_id');
    }

    /**
     * @return BelongsTo<Attribute, $this>
     */
    public function attribute(): BelongsTo
    {
        return $this->belongsTo(Attribute::class);
    }

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'type' => CategoryFilterParameterType::class,
            'is_expanded' => 'boolean',
            'position' => 'integer',
        ];
    }
}
