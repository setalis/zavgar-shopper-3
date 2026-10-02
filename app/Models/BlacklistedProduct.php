<?php

declare(strict_types=1);

namespace App\Models;

use Database\Factories\BlacklistedProductFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class BlacklistedProduct extends Model
{
    /** @use HasFactory<BlacklistedProductFactory> */
    use HasFactory;

    protected $fillable = [
        'sku',
        'name',
        'user_id',
    ];

    public static function contains(string $sku): bool
    {
        return self::query()->where('sku', $sku)->exists();
    }

    /**
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
