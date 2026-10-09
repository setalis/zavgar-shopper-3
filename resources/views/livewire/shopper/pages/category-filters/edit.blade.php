<x-shopper::container class="py-5">
    <x-shopper::breadcrumb :back="route('shopper.categories.index')">
        <x-untitledui-chevron-left class="size-4 shrink-0 text-gray-300 dark:text-gray-600" aria-hidden="true" />
        <x-shopper::breadcrumb.link
            :link="route('shopper.categories.index')"
            :title="__('shopper::pages/categories.menu')"
        />
    </x-shopper::breadcrumb>

    <x-shopper::heading
        class="mt-6"
        :title="__('backend.category_filters.title', ['name' => $category->name])"
    />

    @if ($inheritedFrom)
        <p class="mt-4 text-sm text-gray-500 dark:text-gray-400">
            {{ __('backend.category_filters.inherited', ['name' => $inheritedFrom->name]) }}
        </p>
    @endif

    <form wire:submit="store" class="mt-8 border-t border-gray-200 pt-10 dark:border-white/20">
        <div class="space-y-10">
            {{ $this->form }}

            <div class="border-t border-gray-200 py-8 dark:border-white/10">
                <div class="flex justify-end">
                    <x-filament::button type="submit" wire.loading.attr="disabled">
                        <x-shopper::loader wire:loading wire:target="store" class="text-white" />
                        {{ __('shopper::forms.actions.update') }}
                    </x-filament::button>
                </div>
            </div>
        </div>
    </form>
</x-shopper::container>
