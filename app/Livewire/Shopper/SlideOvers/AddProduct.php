<?php

declare(strict_types=1);

namespace App\Livewire\Shopper\SlideOvers;

use App\Actions\Product\CopyProductRelations;
use App\Models\Product;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Locked;
use Shopper\Actions\Store\Product\CreateProductAction;
use Shopper\Core\Enum\ProductType;
use Shopper\Livewire\SlideOvers\AddProduct as ShopperAddProduct;

final class AddProduct extends ShopperAddProduct
{
    #[Locked]
    public ?int $productId = null;

    public function mount(): void
    {
        $this->authorize('products.create');

        if ($this->productId === null) {
            parent::mount();

            return;
        }

        $product = Product::query()
            ->with(['categories', 'channels', 'collections'])
            ->findOrFail($this->productId);

        $this->currentProductType = $product->type instanceof ProductType ? $product->type->value : null;
        $this->startStep = $this->currentProductType ? 2 : 1;

        $this->form->fill([
            'type' => $this->currentProductType,
            'name' => $product->name,
            'slug' => null,
            'summary' => $product->summary,
            'description' => $product->description,
            'is_visible' => $product->is_visible,
            'published_at' => $product->published_at,
            'brand_id' => $product->brand_id,
            'categories' => $product->categories->modelKeys(),
            'channels' => $product->channels->modelKeys(),
            'collections' => $product->collections->modelKeys(),
            'sku' => null,
            'barcode' => $product->barcode,
            'quantity' => $product->stock,
            'security_stock' => $product->security_stock,
        ]);
    }

    public function store(): void
    {
        $this->authorize('products.create');
        $this->validate();

        $values = $this->form->getState();
        $source = $this->productId === null
            ? null
            : Product::query()->findOrFail($this->productId);

        if ($source instanceof Product) {
            if (blank($this->data['sku'] ?? null)) {
                unset($values['sku']);
            }

            if (blank($this->data['slug'] ?? null)) {
                unset($values['slug']);
            }
        }

        $copyProductRelations = new CopyProductRelations;

        $product = DB::transaction(function () use ($copyProductRelations, $source, $values): Product {
            $product = app()->call(CreateProductAction::class, [
                'values' => $values,
            ]);

            $this->form->model($product)->saveRelationships();

            if ($source instanceof Product) {
                $copyProductRelations->execute($source, $product);
            }

            return $product;
        });

        Notification::make()
            ->title(__('shopper::notifications.create', ['item' => $product->name]))
            ->success()
            ->send();

        $this->redirectRoute(
            name: 'shopper.products.edit',
            parameters: ['product' => $product],
            navigate: true
        );
    }
}
