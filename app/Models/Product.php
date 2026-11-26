<?php

declare(strict_types=1);

namespace App\Models;

use App\Actions\Bundle\ResolveBundleStock;
use App\Concerns\HasCatalogTranslations;
use App\Concerns\InteractsWithStorefrontMedia;
use App\Concerns\ResolvesStorefrontPrice;
use App\Concerns\ResolvesStorefrontReviews;
use App\Concerns\ResolvesStorefrontStock;
use App\Support\NormalizesSearchTerm;
use App\Support\StorefrontLocale;
use App\Traits\HasProductPricing;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Shopper\Core\Enum\ProductType;
use Shopper\Core\Models\Price;
use Shopper\Models\Product as Model;

final class Product extends Model
{
    use HasCatalogTranslations;
    use HasProductPricing;
    use InteractsWithStorefrontMedia;
    use ResolvesStorefrontPrice;
    use ResolvesStorefrontReviews;
    use ResolvesStorefrontStock;

    /**
     * @return HasMany<AttributeProduct, $this>
     */
    public function attributeProducts(): HasMany
    {
        return $this->hasMany(AttributeProduct::class, 'product_id');
    }

    /**
     * @return HasMany<ProductBundleItem, $this>
     */
    public function bundleItems(): HasMany
    {
        return $this->hasMany(ProductBundleItem::class, 'bundle_id')->orderBy('position')->orderBy('id');
    }

    public function isBundle(): bool
    {
        return $this->isStandard() && (bool) $this->is_bundle;
    }

    /**
     * A bundle carries no inventory of its own: its stock is how many complete sets the components allow.
     */
    public function getStock(string|DateTimeInterface|null $date = null): int
    {
        if ($this->isBundle()) {
            return resolve(ResolveBundleStock::class)->handle($this);
        }

        return parent::getStock($date);
    }

    public function inStock(int $quantity = 1): bool
    {
        if ($this->isBundle()) {
            return resolve(ResolveBundleStock::class)->canFulfil($this, $quantity);
        }

        return parent::inStock($quantity);
    }

    /** @param  Builder<self>  $query */
    #[Scope]
    protected function bundles(Builder $query): Builder
    {
        return $query
            ->where('type', ProductType::Standard)
            ->where('is_bundle', true);
    }

    protected function casts(): array
    {
        return [
            ...parent::casts(),
            'is_bundle' => 'boolean',
        ];
    }

    /**
     * @param  Builder<self>  $query
     * @return Builder<self>
     */
    #[Scope]
    protected function matchingSearch(Builder $query, string $term): Builder
    {
        $like = NormalizesSearchTerm::likePattern($term);
        $compacted = NormalizesSearchTerm::alphanumeric($term);
        $compactedLike = $compacted === '' ? null : NormalizesSearchTerm::likePattern($compacted);
        $table = $query->getModel()->getTable();

        return $query->where(function (Builder $query) use ($like, $compactedLike, $table): void {
            $query->where("{$table}.name", 'like', $like)
                ->orWhere("{$table}.sku", 'like', $like);

            if ($compactedLike !== null) {
                NormalizesSearchTerm::orWhereCompactedLike($query, "{$table}.name", $compactedLike);
                NormalizesSearchTerm::orWhereCompactedLike($query, "{$table}.sku", $compactedLike);
            }

            $query->when(
                ! StorefrontLocale::isDefault(),
                fn (Builder $query): Builder => $query->orWhereHas(
                    'translations',
                    fn (Builder $translations): Builder => $translations
                        ->where('locale', StorefrontLocale::current())
                        ->where(function (Builder $translations) use ($like, $compactedLike): void {
                            NormalizesSearchTerm::matchColumn($translations, 'name', $like, $compactedLike);
                        }),
                ),
            )
                ->orWhereHas(
                    'variants',
                    fn (Builder $variants): Builder => $variants->where(function (Builder $variants) use ($like, $compactedLike): void {
                        NormalizesSearchTerm::matchColumn($variants, 'sku', $like, $compactedLike);
                    }),
                )
                ->orWhereHas(
                    'categories',
                    fn (Builder $categories): Builder => $categories
                        ->where('is_enabled', true)
                        ->where(function (Builder $categories) use ($like, $compactedLike): void {
                            NormalizesSearchTerm::matchColumn($categories, 'name', $like, $compactedLike);

                            if (! StorefrontLocale::isDefault()) {
                                $categories->orWhereHas(
                                    'translations',
                                    fn (Builder $translations): Builder => $translations
                                        ->where('locale', StorefrontLocale::current())
                                        ->where(function (Builder $translations) use ($like, $compactedLike): void {
                                            NormalizesSearchTerm::matchColumn($translations, 'name', $like, $compactedLike);
                                        }),
                                );
                            }
                        }),
                )
                ->orWhereHas(
                    'tags',
                    fn (Builder $tags): Builder => $tags->where(function (Builder $tags) use ($like, $compactedLike): void {
                        NormalizesSearchTerm::matchColumn($tags, 'name', $like, $compactedLike);
                    }),
                );
        });
    }

    /** @param  Builder<self>  $query */
    #[Scope]
    protected function withCurrentPrices(Builder $query): Builder
    {
        $currencyCode = current_currency();
        $productsTable = $query->getModel()->getTable();

        return $query
            ->with([
                'prices' => fn ($q) => $q->whereRelation('currency', 'code', $currencyCode),
            ])
            ->addSelect([
                'min_variant_amount' => $this->minimumVariantPriceSubquery($productsTable, $currencyCode, 'amount'),
                'min_variant_compare_amount' => $this->minimumVariantPriceSubquery($productsTable, $currencyCode, 'compare_amount'),
            ]);
    }

    /**
     * Correlated query over every price of the product in the current currency:
     * its own price plus the prices of all its variants.
     */
    public function storefrontPricesQuery(string $productsTable): QueryBuilder
    {
        $pricesTable = shopper_table('prices');
        $variantsTable = shopper_table('product_variants');
        $currenciesTable = shopper_table('currencies');

        return Price::query()
            ->join($currenciesTable, "{$currenciesTable}.id", '=', "{$pricesTable}.currency_id")
            ->where("{$currenciesTable}.code", current_currency())
            ->whereNotNull("{$pricesTable}.amount")
            ->where(function (Builder $query) use ($pricesTable, $variantsTable, $productsTable): void {
                $query
                    ->where(fn (Builder $own): Builder => $own
                        ->where("{$pricesTable}.priceable_type", 'product')
                        ->whereColumn("{$pricesTable}.priceable_id", "{$productsTable}.id"))
                    ->orWhere(fn (Builder $variant): Builder => $variant
                        ->where("{$pricesTable}.priceable_type", 'variant')
                        ->whereIn(
                            "{$pricesTable}.priceable_id",
                            fn (QueryBuilder $variants): QueryBuilder => $variants
                                ->select("{$variantsTable}.id")
                                ->from($variantsTable)
                                ->whereColumn("{$variantsTable}.product_id", "{$productsTable}.id"),
                        ));
            })
            ->toBase();
    }

    private function minimumVariantPriceSubquery(string $productsTable, string $currencyCode, string $column): QueryBuilder
    {
        $pricesTable = shopper_table('prices');
        $variantsTable = shopper_table('product_variants');
        $currenciesTable = shopper_table('currencies');

        return Price::query()
            ->select("{$pricesTable}.{$column}")
            ->join($variantsTable, function ($join) use ($pricesTable, $variantsTable): void {
                $join->on("{$pricesTable}.priceable_id", '=', "{$variantsTable}.id")
                    ->where("{$pricesTable}.priceable_type", 'variant');
            })
            ->join($currenciesTable, "{$currenciesTable}.id", '=', "{$pricesTable}.currency_id")
            ->whereColumn("{$variantsTable}.product_id", "{$productsTable}.id")
            ->where("{$currenciesTable}.code", $currencyCode)
            ->whereNotNull("{$pricesTable}.amount")
            ->orderBy("{$pricesTable}.amount")
            ->limit(1)
            ->toBase();
    }
}
