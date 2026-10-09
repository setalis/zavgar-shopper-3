<?php

declare(strict_types=1);

namespace App\Livewire\Shopper\Pages\CategoryFilters;

use App\Actions\Catalog\ResolveCategoryFilterSchema;
use App\Actions\Catalog\SaveCategoryFilterSchema;
use App\Enums\CategoryFilterParameterType;
use App\Models\Category;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Schemas\Schema;
use Illuminate\Contracts\View\View;
use Shopper\Components\Section;
use Shopper\Core\Models\Attribute;
use Shopper\Livewire\Pages\AbstractPageComponent;
use Shopper\Traits\HandlesAuthorizationExceptions;

/**
 * @property-read Schema $form
 */
final class Edit extends AbstractPageComponent implements HasActions, HasSchemas
{
    use HandlesAuthorizationExceptions;
    use InteractsWithActions;
    use InteractsWithSchemas;

    public Category $category;

    public ?Category $inheritedFrom = null;

    /** @var array<string, mixed>|null */
    public ?array $data = [];

    public function mount(Category $category, ResolveCategoryFilterSchema $resolveCategoryFilterSchema): void
    {
        $this->authorize('categories.edit');

        $this->category = $category;
        $this->inheritedFrom = $resolveCategoryFilterSchema->inheritedFrom($category);

        $this->fillGroups();
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(__('backend.category_filters.heading'))
                    ->compact()
                    ->description(__('backend.category_filters.hint'))
                    ->schema([
                        Repeater::make('groups')
                            ->hiddenLabel()
                            ->addActionLabel(__('backend.category_filters.add_group'))
                            ->defaultItems(0)
                            ->reorderable()
                            ->collapsible()
                            ->itemLabel(fn (array $state): ?string => filled($state['name'] ?? null)
                                ? (string) $state['name']
                                : __('backend.category_filters.untitled_group'))
                            ->schema([
                                TextInput::make('name')
                                    ->label(__('backend.category_filters.group_name'))
                                    ->required()
                                    ->maxLength(255),
                                Repeater::make('parameters')
                                    ->label(__('backend.category_filters.parameters'))
                                    ->addActionLabel(__('backend.category_filters.add_parameter'))
                                    ->defaultItems(0)
                                    ->reorderable()
                                    ->schema([
                                        Select::make('type')
                                            ->label(__('backend.category_filters.parameter'))
                                            ->options(CategoryFilterParameterType::options())
                                            ->required()
                                            ->live()
                                            ->afterStateUpdated(function (mixed $state, callable $set): void {
                                                if ($state !== CategoryFilterParameterType::Attribute->value) {
                                                    $set('attribute_id', null);
                                                }
                                            }),
                                        Select::make('attribute_id')
                                            ->label(__('backend.category_filters.attribute'))
                                            ->options(
                                                fn (): array => Attribute::query()
                                                    ->enabled()
                                                    ->orderBy('name')
                                                    ->pluck('name', 'id')
                                                    ->all(),
                                            )
                                            ->searchable()
                                            ->native(false)
                                            ->required(
                                                fn (Get $get): bool => $get('type') === CategoryFilterParameterType::Attribute->value,
                                            )
                                            ->visible(
                                                fn (Get $get): bool => $get('type') === CategoryFilterParameterType::Attribute->value,
                                            )
                                            ->dehydratedWhenHidden(),
                                        Checkbox::make('is_expanded')
                                            ->label(__('backend.category_filters.is_expanded'))
                                            ->default(true),
                                    ]),
                            ]),
                    ]),
            ])
            ->statePath('data');
    }

    public function store(
        SaveCategoryFilterSchema $saveCategoryFilterSchema,
        ResolveCategoryFilterSchema $resolveCategoryFilterSchema,
    ): void {
        $this->authorize('categories.edit');

        $state = $this->form->getState();
        $groups = is_array($state['groups'] ?? null) ? array_values($state['groups']) : [];

        $saveCategoryFilterSchema->handle($this->category, $groups);
        $this->category->refresh();
        $this->inheritedFrom = $resolveCategoryFilterSchema->inheritedFrom($this->category);
        $this->fillGroups();

        Notification::make()
            ->title(__('backend.category_filters.updated'))
            ->success()
            ->send();
    }

    public function render(): View
    {
        return view('livewire.shopper.pages.category-filters.edit')
            ->title(__('backend.category_filters.title', ['name' => $this->category->name]));
    }

    private function fillGroups(): void
    {
        $this->form->fill([
            'groups' => $this->category->filterGroups()
                ->with(['parameters' => fn ($query) => $query->orderBy('position')])
                ->orderBy('position')
                ->get()
                ->map(fn ($group): array => [
                    'name' => $group->name,
                    'parameters' => $group->parameters
                        ->map(fn ($parameter): array => [
                            'type' => $parameter->type->value,
                            'attribute_id' => $parameter->attribute_id,
                            'is_expanded' => $parameter->is_expanded,
                        ])
                        ->values()
                        ->all(),
                ])
                ->all(),
        ]);
    }
}
