<?php

declare(strict_types=1);

namespace App\Models;

use Database\Factories\CategoryFilterGroupFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

final class CategoryFilterGroup extends Model
{
    /** @use HasFactory<CategoryFilterGroupFactory> */
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'position',
    ];

    /**
     * @var array<string, mixed>
     */
    protected $attributes = [
        'position' => 0,
    ];

    /**
     * @return BelongsTo<Category, $this>
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * @return HasMany<CategoryFilterParameter, $this>
     */
    public function parameters(): HasMany
    {
        return $this->hasMany(CategoryFilterParameter::class, 'group_id')->orderBy('position');
    }

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'position' => 'integer',
        ];
    }
}
