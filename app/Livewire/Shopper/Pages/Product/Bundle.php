<?php

declare(strict_types=1);

namespace App\Livewire\Shopper\Pages\Product;

use App\Actions\Bundle\BuildBundleComposition;
use App\Actions\Bundle\SyncBundleItems;
use App\DTO\BundleCompositionData;
use App\Models\Product;
use App\Models\ProductBundleItem;
use App\Models\ProductVariant;
use App\Support\NormalizesSearchTerm;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Notifications\Notification;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Schemas\Schema;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Locked;
use Livewire\Component;
use Shopper\Core\Enum\ProductType;
use Shopper\Traits\HandlesAuthorizationExceptions;

/**
 * @property-read Schema $form
 * @property-read BundleCompositionData|null $composition
 */
#[Layout('shopper::components.layouts.product')]
final class Bundle extends Component implements HasActions, HasSchemas
{
    use HandlesAuthorizationExceptions;
    use InteractsWithActions;
    use InteractsWithSchemas;

    #[Locked]
    public Product $product;

    /** @var array<string, mixed>|null */
    public ?array $data = [];

    public function mount(): void
    {
        $this->authorize('products.edit');

        abort_unless($this->product->isStandard(), 404);

        $this->form->fill([
            'is_bundle' => (bool) $this->product->is_bundle,
            'items' => $this->product->bundleItems()
                ->get()
                ->map(fn (ProductBundleItem $item): array => [
                    'product_id' => $item->product_id,
                    'product_variant_id' => $item->product_variant_id,
                    'quantity' => $item->quantity,
                ])
                ->all(),
        ]);
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Toggle::make('is_bundle')
                    ->label(__('backend.bundles.is_bundle'))
                    ->helperText(__('backend.bundles.is_bundle_help'))
                    ->live(),
                Repeater::make('items')
                    ->label(__('backend.bundles.items'))
                    ->visible(fn (Get $get): bool => (bool) $get('is_bundle'))
                    ->addActionLabel(__('backend.bundles.add_item'))
                    ->reorderable()
                    ->columns(6)
                    ->defaultItems(1)
                    ->schema([
                        Select::make('product_id')
                            ->label(__('backend.bundles.product'))
                            ->required()
                            ->searchable()
                            ->live()
                            ->getSearchResultsUsing(fn (string $search): array => $this->searchComponents($search))
                            ->getOptionLabelUsing(fn (mixed $value): ?string => Product::query()->find($value)?->name)
                            ->afterStateUpdated(fn (Set $set) => $set('product_variant_id', null))
                            ->columnSpan(3),
                        Select::make('product_variant_id')
                            ->label(__('backend.bundles.variant'))
                            ->options(fn (Get $get): array => ProductVariant::query()
                                ->where('product_id', $get('product_id'))
                                ->orderBy('position')
                                ->pluck('name', 'id')
                                ->all())
                            ->visible(fn (Get $get): bool => Product::query()
                                ->where('id', $get('product_id'))
                                ->where('type', ProductType::Variant)
                                ->exists())
                            ->required()
                            ->columnSpan(2),
                        TextInput::make('quantity')
                            ->label(__('backend.bundles.quantity'))
                            ->integer()
                            ->minValue(1)
                            ->default(1)
                            ->required()
                            ->columnSpan(1),
                    ]),
            ])
            ->statePath('data');
    }

    public function store(SyncBundleItems $syncBundleItems): void
    {
        $this->authorize('products.edit');

        $state = $this->form->getState();

        $syncBundleItems->handle(
            $this->product,
            (bool) ($state['is_bundle'] ?? false),
            array_values($state['items'] ?? []),
            errorKey: 'data.items',
        );

        $this->product->refresh();
        unset($this->composition);

        $this->dispatch('product.updated');

        Notification::make()
            ->body(__('backend.bundles.saved'))
            ->success()
            ->send();
    }

    #[Computed]
    public function composition(): ?BundleCompositionData
    {
        return resolve(BuildBundleComposition::class)->handle($this->product);
    }

    public function render(): View
    {
        return view('livewire.shopper.pages.products.bundle')
            ->title($this->product->name.' ~ '.__('backend.bundles.menu'));
    }

    /**
     * @return array<int, string>
     */
    private function searchComponents(string $search): array
    {
        $like = NormalizesSearchTerm::likePattern($search);

        return Product::query()
            ->whereIn('type', [ProductType::Standard, ProductType::Variant])
            ->where('is_bundle', false)
            ->where('id', '!=', $this->product->id)
            ->where(fn (Builder $query): Builder => $query
                ->where('name', 'like', $like)
                ->orWhere('sku', 'like', $like))
            ->orderBy('name')
            ->limit(50)
            ->pluck('name', 'id')
            ->all();
    }
}
