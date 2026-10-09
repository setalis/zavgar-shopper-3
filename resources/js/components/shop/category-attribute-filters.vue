<script setup lang="ts">
import { ChevronDown } from 'lucide-vue-next';
import { computed, ref, useAttrs, watch } from 'vue';
import PriceRangeFilter from '@/components/shop/price-range-filter.vue';
import { Checkbox } from '@/components/ui/checkbox';
import { useTrans } from '@/composables/useTrans';
import { cn } from '@/lib/utils';
import type { AttributeFilter, FilterGroup, PriceRange } from '@/types/shop';

defineOptions({ inheritAttrs: false });

const props = withDefaults(
    defineProps<{
        groups: FilterGroup[];
        selected: Record<string, string[]>;
        priceRange?: PriceRange | null;
        priceMin?: number | null;
        priceMax?: number | null;
    }>(),
    {
        priceRange: null,
        priceMin: null,
        priceMax: null,
    },
);

const emit = defineEmits<{
    toggle: [slug: string, key: string];
    changePrice: [min: number | null, max: number | null];
    clear: [];
}>();

const { t } = useTrans();

const attrs = useAttrs();
const rootClass = computed<string>(() =>
    cn(
        'self-start rounded-lg border border-rule bg-paper p-5 lg:sticky lg:max-h-[calc(100vh-11rem)] lg:overflow-y-auto',
        attrs.class as string,
    ),
);

const hasSelection = computed<boolean>(
    () =>
        Object.values(props.selected).some((keys) => keys.length > 0) ||
        props.priceMin != null ||
        props.priceMax != null,
);

const visibleGroups = computed<FilterGroup[]>(() =>
    props.groups
        .map((group) => ({
            ...group,
            parameters: group.parameters.filter((parameter) =>
                parameterIsVisible(parameter),
            ),
        }))
        .filter((group) => group.parameters.length > 0),
);

const expandedBySlug = ref<Record<string, boolean>>({});

watch(
    () => props.groups,
    (groups) => {
        const next = { ...expandedBySlug.value };

        for (const group of groups) {
            for (const parameter of group.parameters) {
                if (next[parameter.slug] === undefined) {
                    next[parameter.slug] = parameter.expanded;
                }
            }
        }

        expandedBySlug.value = next;
    },
    { immediate: true },
);

function parameterIsVisible(parameter: AttributeFilter): boolean {
    if (parameter.slug === 'price') {
        return props.priceRange != null;
    }

    return parameter.values.length > 0;
}

function isExpanded(parameter: AttributeFilter): boolean {
    return expandedBySlug.value[parameter.slug] ?? parameter.expanded;
}

function toggleExpanded(parameter: AttributeFilter): void {
    expandedBySlug.value = {
        ...expandedBySlug.value,
        [parameter.slug]: !isExpanded(parameter),
    };
}

function expandLabel(parameter: AttributeFilter): string {
    const name = parameterName(parameter);

    return isExpanded(parameter)
        ? t('shop.filters.collapse', { name })
        : t('shop.filters.expand', { name });
}

function isSelected(slug: string, key: string): boolean {
    return (props.selected[slug] ?? []).includes(key);
}

function parameterName(parameter: AttributeFilter): string {
    return (
        {
            brand: t('shop.filters.brand'),
            category: t('shop.filters.category'),
            collection: t('shop.filters.collection'),
            discount: t('shop.filters.discount'),
            price: t('shop.filters.price_range'),
        }[parameter.slug] ?? parameter.name
    );
}

function valueLabel(parameter: AttributeFilter, key: string, label: string): string {
    if (parameter.slug === 'discount' && key === 'sale') {
        return t('shop.filters.sale');
    }

    return label;
}
</script>

<template>
    <aside
        v-bind="{ ...$attrs, class: undefined }"
        :class="rootClass"
        :style="{ top: 'calc(var(--header-h) + var(--nav-h) + 1rem)' }"
        :aria-label="t('shop.filters.title')"
    >
        <div class="mb-5 flex items-center justify-between gap-3">
            <h2
                class="font-heading text-sm font-bold tracking-[0.06em] text-ink uppercase"
            >
                {{ t('shop.filters.title') }}
            </h2>
            <button
                v-if="hasSelection"
                type="button"
                class="font-mono text-[11px] tracking-[0.04em] text-ink-mute uppercase transition hover:text-brand"
                @click="emit('clear')"
            >
                {{ t('shop.filters.clear') }}
            </button>
        </div>

        <div class="space-y-6">
            <section
                v-for="group in visibleGroups"
                :key="group.id"
                class="space-y-4"
            >
                <h3
                    v-if="group.name"
                    class="font-heading text-xs font-bold tracking-[0.08em] text-ink-mute uppercase"
                >
                    {{ group.name }}
                </h3>

                <div class="divide-y divide-rule">
                    <div
                        v-for="parameter in group.parameters"
                        :key="parameter.slug"
                        class="py-5 first:pt-0 last:pb-0"
                    >
                        <button
                            type="button"
                            class="mb-3 flex w-full items-center justify-between gap-2 text-left"
                            :aria-expanded="isExpanded(parameter)"
                            :aria-controls="`filter-${parameter.slug}`"
                            :aria-label="expandLabel(parameter)"
                            @click="toggleExpanded(parameter)"
                        >
                            <span
                                class="font-heading text-sm font-bold tracking-[0.06em] text-ink uppercase"
                            >
                                {{ parameterName(parameter) }}
                            </span>
                            <ChevronDown
                                :class="
                                    cn(
                                        'size-3.5 shrink-0 text-ink-mute transition duration-200',
                                        isExpanded(parameter) && 'rotate-180',
                                    )
                                "
                                aria-hidden="true"
                            />
                        </button>

                        <div
                            v-show="isExpanded(parameter)"
                            :id="`filter-${parameter.slug}`"
                        >
                            <PriceRangeFilter
                                v-if="parameter.slug === 'price' && priceRange"
                                :bounds="priceRange"
                                :price-min="priceMin"
                                :price-max="priceMax"
                                :show-heading="false"
                                @change="
                                    (min, max) => emit('changePrice', min, max)
                                "
                            />

                            <div v-else class="space-y-0.5">
                                <label
                                    v-for="value in parameter.values"
                                    :key="value.key"
                                    class="flex cursor-pointer items-center gap-2 py-1.5 text-sm text-ink-soft transition hover:text-brand"
                                >
                                    <Checkbox
                                        :model-value="
                                            isSelected(
                                                parameter.slug,
                                                value.key,
                                            )
                                        "
                                        @update:model-value="
                                            emit(
                                                'toggle',
                                                parameter.slug,
                                                value.key,
                                            )
                                        "
                                    />
                                    <span
                                        v-if="parameter.type === 'colorpicker'"
                                        class="size-3.5 shrink-0 rounded-full border border-rule"
                                        :style="{
                                            backgroundColor: value.key,
                                        }"
                                        aria-hidden="true"
                                    />
                                    <span class="flex-1">{{
                                        valueLabel(
                                            parameter,
                                            value.key,
                                            value.label,
                                        )
                                    }}</span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </aside>
</template>
