<x-shopper::container class="py-5">
    <x-shopper::heading
        :title="$this->isPromo() ? __('backend.banners.promo_menu') : __('backend.banners.menu')"
    >
        <x-slot name="action">
            @can(\App\Enums\HomepageBannerPermission::Create)
                <x-filament::button
                    tag="a"
                    :href="route($this->placement->createRouteName())"
                    wire:navigate
                >
                    {{ __('shopper::forms.actions.add_label', ['label' => __('backend.banners.single')]) }}
                </x-filament::button>
            @endcan
        </x-slot>
    </x-shopper::heading>

    <div class="mt-10">
        {{ $this->table }}
    </div>
</x-shopper::container>
