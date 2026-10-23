<x-shopper::container class="py-5">
    <x-shopper::heading :title="__('backend.pending_products.menu')" />

    <nav class="mt-6 flex gap-6 border-b border-sh-border">
        <button
            type="button"
            wire:click="$set('tab', 'products')"
            @class([
                '-mb-px border-b-2 px-1 pb-3 text-sm',
                'border-sh-fg font-semibold text-sh-fg' => $tab === 'products',
                'border-transparent text-sh-fg-muted' => $tab !== 'products',
            ])
        >
            {{ __('backend.pending_products.tabs.products') }}
        </button>
        <button
            type="button"
            wire:click="$set('tab', 'attributes')"
            @class([
                '-mb-px border-b-2 px-1 pb-3 text-sm',
                'border-sh-fg font-semibold text-sh-fg' => $tab === 'attributes',
                'border-transparent text-sh-fg-muted' => $tab !== 'attributes',
            ])
        >
            {{ __('backend.pending_products.tabs.attributes') }}
        </button>
    </nav>

    <p class="mt-4 max-w-3xl text-sm text-sh-fg-muted">
        {{ $tab === 'attributes' ? __('backend.pending_attributes.description') : __('backend.pending_products.description') }}
    </p>

    <div class="mt-8">
        @if ($tab === 'attributes')
            @livewire(\App\Livewire\Shopper\Pages\PendingAttributes\Index::class)
        @else
            {{ $this->table }}
        @endif
    </div>
</x-shopper::container>
