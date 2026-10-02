<x-shopper::container class="py-5">
    <x-shopper::heading :title="__('backend.product_blacklist.menu')" />

    <p class="mt-2 max-w-3xl text-sm text-sh-fg-muted">
        {{ __('backend.product_blacklist.description') }}
    </p>

    <div class="mt-10">
        {{ $this->table }}
    </div>
</x-shopper::container>
