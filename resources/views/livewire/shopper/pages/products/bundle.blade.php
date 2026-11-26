<div class="space-y-8">
    <x-shopper::section-heading
        :title="__('backend.bundles.menu')"
        :description="__('backend.bundles.description')"
    />

    <div class="grid gap-6 lg:grid-cols-3 lg:gap-x-10">
        <form wire:submit="store" class="lg:col-span-2">
            {{ $this->form }}

            <div class="mt-8 flex justify-end">
                <x-filament::button type="submit" wire.loading.attr="disabled">
                    <x-shopper::loader wire:loading wire:target="store" class="text-white" />
                    {{ __('shopper::forms.actions.update') }}
                </x-filament::button>
            </div>
        </form>

        @if ($this->composition)
            @php($currency = current_currency())

            <div class="bg-sh-muted ring-sh-border h-fit space-y-4 rounded-xl p-5 text-sm ring-1">
                <h4 class="text-sh-fg font-semibold">{{ __('backend.bundles.summary') }}</h4>

                <dl class="space-y-2">
                    <div class="flex justify-between gap-4">
                        <dt class="text-sh-fg-muted">{{ __('backend.bundles.computed_stock') }}</dt>
                        <dd class="text-sh-fg font-medium">{{ $this->composition->stock }}</dd>
                    </div>
                    <div class="flex justify-between gap-4">
                        <dt class="text-sh-fg-muted">{{ __('backend.bundles.components_total') }}</dt>
                        <dd class="text-sh-fg font-medium">
                            {{ $this->composition->componentsTotal !== null ? shopper_money_format($this->composition->componentsTotal, $currency) : '—' }}
                        </dd>
                    </div>
                    <div class="flex justify-between gap-4">
                        <dt class="text-sh-fg-muted">{{ __('backend.bundles.bundle_price') }}</dt>
                        <dd class="text-sh-fg font-medium">
                            {{ $this->composition->bundleAmount !== null ? shopper_money_format($this->composition->bundleAmount, $currency) : '—' }}
                        </dd>
                    </div>
                    @if ($this->composition->savings !== null)
                        <div class="flex justify-between gap-4">
                            <dt class="text-sh-fg-muted">{{ __('backend.bundles.savings') }}</dt>
                            <dd class="text-success-600 font-medium">
                                {{ shopper_money_format($this->composition->savings, $currency) }}
                            </dd>
                        </div>
                    @endif
                </dl>

                @if (collect($this->composition->items)->contains(fn ($item) => ! $item->isAvailable))
                    <p class="text-danger-600">{{ __('backend.bundles.unavailable_components') }}</p>
                @endif

                <p class="text-sh-fg-muted">{{ __('backend.bundles.stock_help') }}</p>
            </div>
        @endif
    </div>

    <x-filament-actions::modals />
</div>
