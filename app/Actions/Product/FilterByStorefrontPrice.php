<?php

declare(strict_types=1);

namespace App\Actions\Product;

use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Query\Builder as QueryBuilder;

final class FilterByStorefrontPrice
{
    /**
     * @param  Builder<Product>|Relation<*, Product, *>  $query
     * @return array{min: int, max: int}|null
     */
    public function bounds(Builder|Relation $query): ?array
    {
        $query = $this->toBuilder($query);
        $pricesTable = shopper_table('prices');

        $minimum = $this->pricesQuery($query)->selectRaw("MIN({$pricesTable}.amount)");
        $maximum = $this->pricesQuery($query)->selectRaw("MAX({$pricesTable}.amount)");

        $clone = $query->clone()->reorder();
        $clone->getQuery()->columns = [];

        $row = $clone
            ->toBase()
            ->selectRaw(
                "MIN(({$minimum->toSql()})) as min_amount, MAX(({$maximum->toSql()})) as max_amount",
                [...$minimum->getBindings(), ...$maximum->getBindings()],
            )
            ->first();

        if ($row === null || $row->min_amount === null || $row->max_amount === null) {
            return null;
        }

        return [
            'min' => (int) $row->min_amount,
            'max' => (int) $row->max_amount,
        ];
    }

    /**
     * @param  Builder<Product>|Relation<*, Product, *>  $query
     * @return Builder<Product>
     */
    public function apply(Builder|Relation $query, ?int $min, ?int $max): Builder
    {
        $query = $this->toBuilder($query);

        if ($min === null && $max === null) {
            return $query;
        }

        if ($min !== null && $max !== null && $min > $max) {
            [$min, $max] = [$max, $min];
        }

        $pricesTable = shopper_table('prices');

        return $query->whereExists(
            $this->pricesQuery($query)
                ->selectRaw('1')
                ->when($min !== null, fn (QueryBuilder $prices): QueryBuilder => $prices->where("{$pricesTable}.amount", '>=', $min))
                ->when($max !== null, fn (QueryBuilder $prices): QueryBuilder => $prices->where("{$pricesTable}.amount", '<=', $max)),
        );
    }

    /**
     * @param  Builder<Product>  $query
     */
    private function pricesQuery(Builder $query): QueryBuilder
    {
        return $query->getModel()->storefrontPricesQuery($query->getModel()->getTable());
    }

    /**
     * @param  Builder<Product>|Relation<*, Product, *>  $query
     * @return Builder<Product>
     */
    private function toBuilder(Builder|Relation $query): Builder
    {
        return $query instanceof Relation ? $query->getQuery() : $query;
    }
}
