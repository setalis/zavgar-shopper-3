<x-shopper::container class="py-5">
    <x-shopper::heading :title="__('backend.news.menu')">
        <x-slot name="action">
            @can(\App\Enums\NewsPermission::Create)
                <x-filament::button
                    tag="a"
                    :href="route('shopper.news.create')"
                    wire:navigate
                >
                    {{ __('shopper::forms.actions.add_label', ['label' => __('backend.news.single')]) }}
                </x-filament::button>
            @endcan
        </x-slot>
    </x-shopper::heading>

    <div class="mt-10">
        {{ $this->table }}
    </div>
</x-shopper::container>
