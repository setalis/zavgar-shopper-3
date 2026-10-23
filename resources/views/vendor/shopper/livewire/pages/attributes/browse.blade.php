<x-shopper::container class="py-5">
    <x-shopper::heading :title="__('shopper::pages/attributes.menu')">
        <x-slot name="action">
            <div class="flex items-center gap-2">
                @can('attributes.browse')
                    <x-filament::button
                        tag="a"
                        :href="route('shopper.attributes.export-xlsx')"
                        :spa-mode="false"
                        download
                        color="gray"
                    >
                        {{ __('backend.attribute_imports.export_action') }}
                    </x-filament::button>
                @endcan
                @can('attributes.create')
                    <x-filament::button
                        wire:click="$dispatch('openPanel', { component: 'shopper-slide-overs.import-attributes-xlsx' })"
                        type="button"
                        color="gray"
                    >
                        {{ __('backend.attribute_imports.import_action') }}
                    </x-filament::button>
                    <x-filament::button
                        wire:click="$dispatch('openPanel', { component: 'shopper-slide-overs.attribute-form' })"
                        type="button"
                    >
                        {{ __('shopper::forms.actions.create') }}
                    </x-filament::button>
                @endcan
            </div>
        </x-slot>
    </x-shopper::heading>

    {{ shopper()->getRenderHook(\Shopper\View\CatalogRenderHook::ATTRIBUTES_TABLE_BEFORE) }}

    <div class="mt-8">
        {{ $this->table }}
    </div>

    {{ shopper()->getRenderHook(\Shopper\View\CatalogRenderHook::ATTRIBUTES_TABLE_AFTER) }}

    <x-shopper::learn-more :name="__('shopper::pages/attributes.menu')" link="attributes" />
</x-shopper::container>
