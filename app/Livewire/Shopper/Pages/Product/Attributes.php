<?php

declare(strict_types=1);

namespace App\Livewire\Shopper\Pages\Product;

use App\Models\AttributeProduct;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Lazy;
use Shopper\Livewire\Pages\Product\Attributes as BaseAttributes;

#[Lazy]
#[Layout('shopper::components.layouts.product')]
final class Attributes extends BaseAttributes
{
    public function table(Table $table): Table
    {
        return parent::table($table)
            ->pushColumns([
                ToggleColumn::make('is_variant_option')
                    ->label(__('backend.variant_options.column'))
                    ->tooltip(__('backend.variant_options.toggle_help'))
                    ->visible($this->product->canUseVariants())
                    ->disabled(fn (AttributeProduct $record): bool => $record->attribute->hasTextValue()
                        || ! (shopper()->auth()->user()?->can('products.edit') ?? false))
                    ->updateStateUsing(fn (AttributeProduct $record, bool $state): bool => $this->updateVariantOption($record, $state)),
            ]);
    }

    private function updateVariantOption(AttributeProduct $record, bool $state): bool
    {
        $this->authorize('products.edit');

        if (! $state && AttributeProduct::isUsedByVariants($this->product->id, $record->attribute_id)) {
            Notification::make()
                ->title(__('backend.variant_options.locked'))
                ->body(__('backend.variant_options.locked_help'))
                ->warning()
                ->send();

            return true;
        }

        AttributeProduct::markVariantOption($this->product->id, $record->attribute_id, $state);

        return $state;
    }
}
