@php
    $preview = $schemaComponent->getLivewire()->preview;
@endphp

<div class="space-y-4">
    <ul class="flex flex-wrap items-center gap-x-6 gap-y-2">
        <li class="flex items-center gap-2 text-sm text-sh-fg-muted">
            <x-phosphor-tag-duotone class="size-5 text-sh-fg-muted" aria-hidden="true" />
            <span class="font-semibold text-sh-fg">{{ $preview['total_products'] ?? 0 }}</span>
            {{ __('shopper::pages/products.import.review.products') }}
        </li>
        <li class="flex items-center gap-2 text-sm text-sh-fg-muted">
            <x-phosphor-swatches-duotone class="size-5 text-sh-fg-muted" aria-hidden="true" />
            <span class="font-semibold text-sh-fg">{{ $preview['total_variants'] ?? 0 }}</span>
            {{ __('shopper::pages/products.import.review.variants') }}
        </li>
        <li class="flex items-center gap-2 text-sm text-sh-fg-muted">
            <x-phosphor-list-bullets-duotone class="size-5 text-sh-fg-muted" aria-hidden="true" />
            <span class="font-semibold text-sh-fg">{{ $preview['total_attributes'] ?? 0 }}</span>
            {{ __('backend.product_imports.review_attributes') }}
        </li>
        <li class="flex items-center gap-2 text-sm text-sh-fg-muted">
            <x-phosphor-package-duotone class="size-5 text-sh-fg-muted" aria-hidden="true" />
            <span class="font-semibold text-sh-fg">{{ $preview['total_stock'] ?? 0 }}</span>
            {{ __('shopper::pages/products.import.review.stock') }}
        </li>
    </ul>

    <ul class="flex flex-wrap items-center gap-x-6 gap-y-2">
        <li class="flex items-center gap-2 text-sm text-sh-fg-muted">
            <x-phosphor-arrows-clockwise-duotone class="size-5 text-success-600" aria-hidden="true" />
            <span class="font-semibold text-sh-fg">{{ $preview['outcomes'][\App\Enums\ProductImportRowOutcome::Updated->value] ?? 0 }}</span>
            {{ __('backend.pending_products.preview.updated') }}
        </li>
        <li class="flex items-center gap-2 text-sm text-sh-fg-muted">
            <x-phosphor-queue-duotone class="size-5 text-warning-600" aria-hidden="true" />
            <span class="font-semibold text-sh-fg">{{ $preview['outcomes'][\App\Enums\ProductImportRowOutcome::Queued->value] ?? 0 }}</span>
            {{ __('backend.pending_products.preview.queued') }}
        </li>
        <li class="flex items-center gap-2 text-sm text-sh-fg-muted">
            <x-phosphor-prohibit-duotone class="size-5 text-danger-600" aria-hidden="true" />
            <span class="font-semibold text-sh-fg">{{ $preview['outcomes'][\App\Enums\ProductImportRowOutcome::Skipped->value] ?? 0 }}</span>
            {{ __('backend.pending_products.preview.skipped') }}
        </li>
    </ul>

    @if (($preview['missing_sku'] ?? 0) > 0)
        <div class="flex items-center gap-2 rounded-lg bg-danger-50 p-3 text-sm text-danger-700 dark:bg-danger-400/10 dark:text-danger-400">
            <x-untitledui-alert-triangle class="size-4 shrink-0" aria-hidden="true" />
            {{ trans_choice('backend.pending_products.preview.missing_sku', $preview['missing_sku'], ['count' => $preview['missing_sku']]) }}
        </div>
    @endif

    @if (($preview['unnamed'] ?? 0) > 0)
        <div class="flex items-center gap-2 rounded-lg bg-warning-50 p-3 text-sm text-warning-700 dark:bg-warning-400/10 dark:text-warning-400">
            <x-untitledui-alert-triangle class="size-4 shrink-0" aria-hidden="true" />
            {{ trans_choice('shopper::pages/products.import.review.unnamed', $preview['unnamed'], ['count' => $preview['unnamed']]) }}
        </div>
    @endif

    <div class="max-h-96 overflow-y-auto rounded-xl border border-sh-border">
        <table class="fi-ta-table w-full table-auto divide-y divide-sh-border text-start">
            <thead class="sticky top-0 z-10 bg-sh-surface">
                <tr>
                    <th class="fi-ta-header-cell px-3 py-2 text-start sm:first-of-type:ps-6 sm:last-of-type:pe-6">
                        <span class="fi-ta-header-cell-label text-sm font-semibold text-sh-fg">
                            {{ __('backend.product_imports.fields.sku') }}
                        </span>
                    </th>
                    <th class="fi-ta-header-cell px-3 py-2 text-start sm:first-of-type:ps-6 sm:last-of-type:pe-6">
                        <span class="fi-ta-header-cell-label text-sm font-semibold text-sh-fg">
                            {{ __('shopper::forms.label.name') }}
                        </span>
                    </th>
                    <th class="fi-ta-header-cell px-3 py-2 text-start sm:first-of-type:ps-6 sm:last-of-type:pe-6">
                        <span class="fi-ta-header-cell-label text-sm font-semibold text-sh-fg">
                            {{ __('backend.pending_products.preview.action') }}
                        </span>
                    </th>
                    <th class="fi-ta-header-cell px-3 py-2 text-start sm:first-of-type:ps-6 sm:last-of-type:pe-6">
                        <span class="fi-ta-header-cell-label text-sm font-semibold text-sh-fg">
                            {{ __('shopper::forms.label.brand') }}
                        </span>
                    </th>
                    <th class="fi-ta-header-cell px-3 py-2 text-end sm:first-of-type:ps-6 sm:last-of-type:pe-6">
                        <span class="fi-ta-header-cell-label text-sm font-semibold text-sh-fg">
                            {{ __('shopper::forms.label.price') }}
                        </span>
                    </th>
                    <th class="fi-ta-header-cell px-3 py-2 text-end sm:first-of-type:ps-6 sm:last-of-type:pe-6">
                        <span class="fi-ta-header-cell-label text-sm font-semibold text-sh-fg">
                            {{ __('shopper::pages/products.import.review.variants') }}
                        </span>
                    </th>
                    <th class="fi-ta-header-cell px-3 py-2 text-end sm:first-of-type:ps-6 sm:last-of-type:pe-6">
                        <span class="fi-ta-header-cell-label text-sm font-semibold text-sh-fg">
                            {{ __('backend.product_imports.review_attributes') }}
                        </span>
                    </th>
                </tr>
            </thead>
            <tbody class="divide-y divide-sh-border whitespace-nowrap">
                @foreach ($preview['products'] ?? [] as $product)
                    <tr>
                        <td class="fi-ta-cell p-0 first-of-type:ps-1 last-of-type:pe-1 sm:first-of-type:ps-3 sm:last-of-type:pe-3">
                            <div class="px-3 py-2">
                                <span class="text-sm tabular-nums text-sh-fg-muted">
                                    {{ $product['sku'] ?? '—' }}
                                </span>
                            </div>
                        </td>
                        <td class="fi-ta-cell p-0 first-of-type:ps-1 last-of-type:pe-1 sm:first-of-type:ps-3 sm:last-of-type:pe-3">
                            <div class="px-3 py-2">
                                <span class="text-sm font-medium text-sh-fg">
                                    {{ $product['name'] }}
                                </span>
                            </div>
                        </td>
                        <td class="fi-ta-cell p-0 first-of-type:ps-1 last-of-type:pe-1 sm:first-of-type:ps-3 sm:last-of-type:pe-3">
                            <div class="px-3 py-2">
                                @php
                                    $outcome = $product['outcome'] ?? null;
                                    $outcomeColor = match ($outcome) {
                                        \App\Enums\ProductImportRowOutcome::Updated->value => 'success',
                                        \App\Enums\ProductImportRowOutcome::Queued->value => 'warning',
                                        default => 'danger',
                                    };
                                @endphp
                                <x-filament::badge :color="$outcomeColor" class="inline-flex">
                                    {{ __('backend.pending_products.preview.outcomes.'.($outcome ?? 'missing_sku')) }}
                                </x-filament::badge>
                            </div>
                        </td>
                        <td class="fi-ta-cell p-0 first-of-type:ps-1 last-of-type:pe-1 sm:first-of-type:ps-3 sm:last-of-type:pe-3">
                            <div class="px-3 py-2">
                                <span class="text-sm text-sh-fg-muted">
                                    {{ $product['brand'] ?? '—' }}
                                </span>
                            </div>
                        </td>
                        <td class="fi-ta-cell p-0 first-of-type:ps-1 last-of-type:pe-1 sm:first-of-type:ps-3 sm:last-of-type:pe-3">
                            <div class="px-3 py-2 text-end">
                                <span class="text-sm font-medium tabular-nums text-sh-fg-secondary">
                                    {{ $product['price'] !== null ? shopper_money_format((int) round($product['price'] * 100)) : '—' }}
                                </span>
                            </div>
                        </td>
                        <td class="fi-ta-cell p-0 first-of-type:ps-1 last-of-type:pe-1 sm:first-of-type:ps-3 sm:last-of-type:pe-3">
                            <div class="px-3 py-2 text-end">
                                <span class="text-sm tabular-nums text-sh-fg-muted">
                                    {{ $product['variants_count'] }}
                                </span>
                            </div>
                        </td>
                        <td class="fi-ta-cell p-0 first-of-type:ps-1 last-of-type:pe-1 sm:first-of-type:ps-3 sm:last-of-type:pe-3">
                            <div class="px-3 py-2 text-end">
                                <span class="text-sm tabular-nums text-sh-fg-muted">
                                    {{ $product['attributes_count'] }}
                                </span>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @if (($preview['total_products'] ?? 0) > count($preview['products'] ?? []))
        <p class="text-sm text-sh-fg-muted">
            {{ __('shopper::pages/products.import.review.more', ['count' => $preview['total_products'] - count($preview['products'] ?? [])]) }}
        </p>
    @endif
</div>
