@php
    $preview = $schemaComponent->getLivewire()->preview;
@endphp

<div class="space-y-4">
    <ul class="flex flex-wrap items-center gap-x-6 gap-y-2">
        <li class="flex items-center gap-2 text-sm text-sh-fg-muted">
            <x-phosphor-arrows-clockwise-duotone class="size-5 text-success-600" aria-hidden="true" />
            <span class="font-semibold text-sh-fg">{{ $preview['updated'] ?? 0 }}</span>
            {{ __('backend.pending_products.preview.updated') }}
        </li>
        <li class="flex items-center gap-2 text-sm text-sh-fg-muted">
            <x-phosphor-queue-duotone class="size-5 text-warning-600" aria-hidden="true" />
            <span class="font-semibold text-sh-fg">{{ $preview['queued'] ?? 0 }}</span>
            {{ __('backend.pending_products.preview.queued') }}
        </li>
        <li class="flex items-center gap-2 text-sm text-sh-fg-muted">
            <x-phosphor-warning-duotone class="size-5 text-danger-600" aria-hidden="true" />
            <span class="font-semibold text-sh-fg">{{ $preview['failed'] ?? 0 }}</span>
            {{ __('backend.attribute_imports.errors') }}
        </li>
    </ul>

    @if (($preview['rows'] ?? []) !== [])
        <div class="overflow-x-auto rounded-lg border border-sh-border">
            <table class="fi-ta-table w-full table-auto divide-y divide-sh-border text-start">
                <thead>
                    <tr class="text-xs font-medium text-sh-fg-muted">
                        <th class="px-3 py-2 text-start">{{ __('shopper::forms.label.name') }}</th>
                        <th class="px-3 py-2 text-start">{{ __('shopper::forms.label.slug') }}</th>
                        <th class="px-3 py-2 text-start">{{ __('backend.pending_products.preview.action') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-sh-border">
                    @foreach ($preview['rows'] as $row)
                        <tr class="text-sm text-sh-fg">
                            <td class="px-3 py-2">{{ $row['name'] }}</td>
                            <td class="px-3 py-2">{{ $row['slug'] }}</td>
                            <td class="px-3 py-2">{{ __('backend.pending_products.preview.outcomes.'.$row['outcome']) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

    @if (($preview['errors'] ?? []) !== [])
        <ul class="space-y-1 text-sm text-danger-600">
            @foreach ($preview['errors'] as $error)
                <li>{{ $error['message'] }}</li>
            @endforeach
        </ul>
    @endif
</div>
