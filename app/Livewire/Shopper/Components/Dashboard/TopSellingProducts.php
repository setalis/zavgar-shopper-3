<?php

declare(strict_types=1);

namespace App\Livewire\Shopper\Components\Dashboard;

use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Shopper\Core\Enum\PaymentStatus;
use Shopper\Core\Models\Contracts\Product as ProductContract;
use Shopper\Core\Models\Contracts\ProductVariant;

/**
 * @property-read Collection<int, array{product: ?Model, sales: int, reviews_count: int, average_rating: float|null}> $products
 */
final class TopSellingProducts extends Component
{
    #[Computed]
    public function products(): Collection
    {
        /** @var list<array{product_id: int, sales: int, reviews_count: int, average_rating: float|null}> $cached */
        $cached = Cache::flexible(
            'dashboard:top-selling-products:summary',
            [300, 1800],
            fn (): array => $this->buildTopProductSummaries(),
        );

        $productIds = array_column($cached, 'product_id');

        if ($productIds === []) {
            return collect();
        }

        /** @var \Illuminate\Database\Eloquent\Collection<int, Model> $products */
        $products = resolve(ProductContract::class)::query()
            ->whereIn('id', $productIds)
            ->with('media')
            ->get()
            ->keyBy('id');

        return collect($cached)->map(fn (array $row): array => [
            'product' => $products->get($row['product_id']),
            'sales' => $row['sales'],
            'reviews_count' => $row['reviews_count'],
            'average_rating' => $row['average_rating'],
        ]);
    }

    public function placeholder(): View
    {
        return view('shopper::livewire.components.dashboard.placeholders.top-selling-products');
    }

    public function render(): View
    {
        return view('shopper::livewire.components.dashboard.top-selling-products');
    }

    /**
     * @return list<array{product_id: int, sales: int, reviews_count: int, average_rating: float|null}>
     */
    private function buildTopProductSummaries(): array
    {
        $variantClass = resolve(ProductVariant::class)::class;

        $topProducts = DB::table(shopper_table('order_items').' as oi')
            ->join(shopper_table('orders').' as o', 'o.id', '=', 'oi.order_id')
            ->leftJoin(shopper_table('product_variants').' as pv', function (JoinClause $join) use ($variantClass): void {
                $join->on('pv.id', '=', 'oi.product_id')
                    ->where('oi.product_type', '=', $variantClass);
            })
            ->whereIn('o.payment_status', array_map(
                fn (PaymentStatus $status): string => $status->value,
                PaymentStatus::revenueBearing(),
            ))
            ->where('o.created_at', '>=', now()->subDays(90))
            ->selectRaw('COALESCE(pv.product_id, oi.product_id) as parent_product_id, SUM(oi.quantity) as total_sales')
            ->groupBy('parent_product_id')
            ->orderByDesc('total_sales')
            ->limit(6)
            ->get();

        $productIds = $topProducts->pluck('parent_product_id')->filter()->all();

        /** @var \Illuminate\Database\Eloquent\Collection<int, Model> $products */
        $products = resolve(ProductContract::class)::query()
            ->whereIn('id', $productIds)
            ->with([
                'ratings' => fn ($query) => $query->where('approved', true),
            ])
            ->get()
            ->keyBy('id');

        return $topProducts
            ->map(function (object $row) use ($products): ?array {
                $product = $products->get((int) $row->parent_product_id);

                if ($product === null) {
                    return null;
                }

                $approvedRatings = $product->getRelation('ratings');

                return [
                    'product_id' => (int) $product->getKey(),
                    'sales' => (int) $row->total_sales,
                    'reviews_count' => $approvedRatings->count(),
                    'average_rating' => $approvedRatings->isNotEmpty()
                        ? round((float) $approvedRatings->avg('rating'), 1)
                        : null,
                ];
            })
            ->filter()
            ->values()
            ->all();
    }
}
