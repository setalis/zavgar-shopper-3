<?php

declare(strict_types=1);

namespace App\Livewire\Shopper\SlideOvers;

use App\Models\AttributeProduct;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Notifications\Notification;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;
use Filament\Support\Enums\Alignment;
use Filament\Support\Enums\IconSize;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\HtmlString;
use JaOcero\RadioDeck\Forms\Components\RadioDeck;
use Mckenziearts\Icons\Untitledui\Enums\Untitledui;
use Shopper\Actions\Store\Product\AttachedAttributesToProductAction;
use Shopper\Components\Separator;
use Shopper\Components\SlideOverWizard;
use Shopper\Components\Wizard\StepColumn;
use Shopper\Core\Enum\FieldType;
use Shopper\Core\Models\Attribute;
use Shopper\Livewire\SlideOvers\ChooseProductAttributes as BaseChooseProductAttributes;

/**
 * Adds a "use for variants" toggle to every attribute with predefined values.
 */
final class ChooseProductAttributes extends BaseChooseProductAttributes
{
    public function form(Schema $schema): Schema
    {
        $attributes = Attribute::query()
            ->scopes('enabled')
            ->select('id', 'name', 'description', 'icon')
            ->get();

        return $schema
            ->components([
                SlideOverWizard::make([
                    StepColumn::make(__('shopper::pages/attributes.menu'))
                        ->icon(Untitledui::PuzzlePiece)
                        ->schema([
                            RadioDeck::make('attributes')
                                ->options($attributes->pluck('name', 'id'))
                                ->descriptions($attributes->pluck('description', 'id')->toArray())
                                ->icons($attributes->pluck('icon', 'id')->toArray())
                                ->alignment(Alignment::Start)
                                ->iconSize(IconSize::Small)
                                ->color('primary')
                                ->columns(3)
                                ->live()
                                ->afterStateUpdated(
                                    fn (RadioDeck $component): Schema => $component->getContainer()
                                        ->getParentComponent()
                                        ->getContainer()
                                        ->getComponent('values')
                                        ->getChildSchema()
                                        ->fill()
                                )
                                ->multiple()
                                ->required(),
                        ]),
                    StepColumn::make(__('shopper::pages/attributes.values.slug'))
                        ->icon(Untitledui::Dotpoints)
                        ->schema([
                            Grid::make()
                                ->schema(fn (Get $get): array => $this->valueFields($get('attributes') ?? []))
                                ->key('values'),
                        ]),
                ])
                    ->submitAction(new HtmlString(Blade::render(<<<'BLADE'
                        <x-filament::button type="submit" wire:loading.attr="disabled">
                            <x-shopper::loader wire:loading wire:target="store" class="text-white" />
                            {{ __('shopper::forms.actions.save') }}
                        </x-filament::button>
                     BLADE)))
                    ->persistStepInQueryString(),
            ])
            ->statePath('data');
    }

    public function store(): void
    {
        $this->authorize('products.edit');

        $state = $this->form->getState();
        $values = data_get($state, 'values') ?? [];
        $selectedValues = Arr::except($values, 'custom_value');

        app()->call(AttachedAttributesToProductAction::class, [
            'product' => $this->product,
            'attributes' => $selectedValues,
            'customValues' => Arr::get($values, 'custom_value', []),
        ]);

        foreach (array_keys($selectedValues) as $attributeId) {
            $attributeId = (int) $attributeId;

            AttributeProduct::markVariantOption(
                productId: $this->product->id,
                attributeId: $attributeId,
                isVariantOption: (bool) data_get($state, "variant_options.{$attributeId}", false)
                    || AttributeProduct::isUsedByVariants($this->product->id, $attributeId),
            );
        }

        Notification::make()
            ->title(__('shopper::pages/products.attributes.session.added_message'))
            ->success()
            ->send();

        $this->redirect(
            route('shopper.products.edit', ['product' => $this->product, 'tab' => 'attributes']),
            navigate: true
        );
    }

    /**
     * @param  array<int, int|string>  $attributeIds
     * @return array<int, mixed>
     */
    private function valueFields(array $attributeIds): array
    {
        $selectSchema = [];
        $textSchema = [];

        $attributes = Attribute::with('values')
            ->select('id', 'name', 'type', 'slug')
            ->whereIn('id', $attributeIds)
            ->get();

        $selectedAttributes = AttributeProduct::query()
            ->where('product_id', $this->product->id)
            ->whereIn('attribute_id', $attributeIds)
            ->get()
            ->mapToGroups(fn (AttributeProduct $attributeProduct): array => [
                $attributeProduct->attribute_id => $attributeProduct->attribute_value_id,
            ]);

        foreach ($attributes as $attribute) {
            /** @var Attribute $attribute */
            if ($attribute->hasMultipleValues() || $attribute->hasSingleValue()) {
                $selectSchema[] = Select::make("values.{$attribute->id}")
                    ->key($attribute->slug)
                    ->label($attribute->name)
                    ->required()
                    ->options($attribute->values->pluck('value', 'id'))
                    ->disableOptionWhen(
                        fn (string $value): bool => in_array(
                            $value,
                            $selectedAttributes->get($attribute->id)?->toArray() ?? []
                        )
                    )
                    ->multiple($attribute->hasMultipleValues())
                    ->preload()
                    ->optionsLimit(10)
                    ->native(false);

                $selectSchema[] = $this->variantOptionToggle($attribute);
            }

            if ($attribute->hasTextValue()) {
                $textSchema[] = match ($attribute->type) {
                    FieldType::RichText => RichEditor::make("values.custom_value.{$attribute->id}")
                        ->label($attribute->name)
                        ->key($attribute->slug)
                        ->disabled($selectedAttributes->get($attribute->id) !== null)
                        ->columnSpanFull(),
                    FieldType::DatePicker => DatePicker::make("values.custom_value.{$attribute->id}")
                        ->label($attribute->name)
                        ->key($attribute->slug)
                        ->disabled($selectedAttributes->get($attribute->id) !== null)
                        ->native(false),
                    default => TextInput::make("values.custom_value.{$attribute->id}")
                        ->key($attribute->slug)
                        ->disabled($selectedAttributes->get($attribute->id) !== null)
                        ->label($attribute->name),
                };
            }
        }

        return array_merge(
            $selectSchema,
            count($textSchema) > 0 ? [Separator::make()->columnSpanFull()] : [],
            $textSchema
        );
    }

    private function variantOptionToggle(Attribute $attribute): Toggle
    {
        $isUsedByVariants = AttributeProduct::isUsedByVariants($this->product->id, $attribute->id);

        return Toggle::make("variant_options.{$attribute->id}")
            ->key("variant-option-{$attribute->slug}")
            ->label(__('backend.variant_options.toggle'))
            ->helperText($isUsedByVariants
                ? __('backend.variant_options.locked_help')
                : __('backend.variant_options.toggle_help'))
            ->default($isUsedByVariants || AttributeProduct::isVariantOption($this->product->id, $attribute->id))
            ->disabled($isUsedByVariants)
            ->visible($this->product->canUseVariants())
            ->inline(false);
    }
}
