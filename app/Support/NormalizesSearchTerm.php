<?php

declare(strict_types=1);

namespace App\Support;

use Illuminate\Database\Eloquent\Builder;

final class NormalizesSearchTerm
{
    /**
     * @var list<string>
     */
    private const array IGNORED_CHARACTERS = [
        ' ', "\t", "\n", "\r",
        '-', '_', '.', '/', '\\',
        ',', ';', ':',
        '(', ')', '[', ']', '{', '}',
        '#', '*', '+', '=',
        "'", '"', '`',
        '|', '@', '!', '?', '~', '&',
        '%',
    ];

    public static function alphanumeric(string $value): string
    {
        return (string) preg_replace('/[^\p{L}\p{N}]+/u', '', $value);
    }

    public static function likePattern(string $value): string
    {
        $escaped = str_replace(['%', '_'], ['\%', '\_'], $value);

        return "%{$escaped}%";
    }

    /**
     * @param  Builder<*>  $query
     */
    public static function matchColumn(Builder $query, string $column, string $like, ?string $compactedLike): void
    {
        $query->where($column, 'like', $like);

        if ($compactedLike !== null) {
            self::orWhereCompactedLike($query, $column, $compactedLike);
        }
    }

    /**
     * @param  Builder<*>  $query
     * @return Builder<*>
     */
    public static function orWhereCompactedLike(Builder $query, string $column, string $like): Builder
    {
        $expression = $query->getGrammar()->wrap($column);
        $bindings = [];

        foreach (self::IGNORED_CHARACTERS as $character) {
            $expression = "REPLACE({$expression}, ?, '')";
            $bindings[] = $character;
        }

        return $query->orWhereRaw("{$expression} LIKE ?", [...$bindings, $like]);
    }
}
