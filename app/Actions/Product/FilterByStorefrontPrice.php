<?php

declare(strict_types=1);

namespace App\Actions\Product;

use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Support\Facades\DB;
use Shopper\Core\Models\Price;

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
        $variantsTable = shopper_table('product_variants');
        $currenciesTable = shopper_table('currencies');

        $ownPrices = Price::query()
            ->select("{$pricesTable}.amount")
            ->join($currenciesTable, "{$currenciesTable}.id", '=', "{$pricesTable}.currency_id")
            ->joinSub($this->productIds($query), 'filtered_products', function ($join) use ($pricesTable): void {
                $join->on("{$pricesTable}.priceable_id", '=', 'filtered_products.id');
            })
            ->where("{$pricesTable}.priceable_type", 'product')
            ->where("{$currenciesTable}.code", current_currency())
            ->whereNotNull("{$pricesTable}.amount")
            ->toBase();

        $variantPrices = Price::query()
            ->select("{$pricesTable}.amount")
            ->join($currenciesTable, "{$currenciesTable}.id", '=', "{$pricesTable}.currency_id")
            ->join($variantsTable, function ($join) use ($pricesTable, $variantsTable): void {
                $join->on("{$pricesTable}.priceable_id", '=', "{$variantsTable}.id")
                    ->where("{$pricesTable}.priceable_type", 'variant');
            })
            ->joinSub($this->productIds($query), 'filtered_products', function ($join) use ($variantsTable): void {
                $join->on("{$variantsTable}.product_id", '=', 'filtered_products.id');
            })
            ->where("{$currenciesTable}.code", current_currency())
            ->whereNotNull("{$pricesTable}.amount")
            ->toBase();

        $row = DB::query()
            ->fromSub($ownPrices->unionAll($variantPrices), 'storefront_amounts')
            ->selectRaw('MIN(amount) as min_amount, MAX(amount) as max_amount')
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
     * @param  Builder<Product>  $query
     * @return Builder<Product>
     */
    private function productIds(Builder $query): Builder
    {
        $clone = $query->clone()->reorder();
        $clone->getQuery()->columns = [];

        return $clone->select($query->getModel()->qualifyColumn('id'));
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
