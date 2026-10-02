<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import Container from '@/components/shop/container.vue';
import { useLocalizedRoute } from '@/composables/useLocalizedRoute';
import { useTrans } from '@/composables/useTrans';
import * as shop from '@/routes/shop';
import type { Brand } from '@/types/shop';

type BrandName = Pick<Brand, 'id' | 'name' | 'slug'>;

defineProps<{
    brands: BrandName[];
}>();

const { t } = useTrans();
const { localized } = useLocalizedRoute();

const brandHref = (brand: BrandName): string =>
    localized(shop.brand.url({ brand: brand.slug }));

const brandLabel = (name: string): string =>
    t('shop.product.brand_products', { name });
</script>

<template>
    <section class="border-y border-rule bg-paper py-10">
        <div class="overflow-hidden motion-reduce:hidden">
            <div
                class="animate-brand-marquee flex w-max hover:[animation-play-state:paused] focus-within:[animation-play-state:paused]"
            >
                <div
                    v-for="copy in 2"
                    :key="copy"
                    class="flex items-center gap-10 px-5 md:gap-14 md:px-7"
                    :aria-hidden="copy === 2 ? true : undefined"
                >
                    <Link
                        v-for="brand in brands"
                        :key="`${copy}-${brand.id}`"
                        :href="brandHref(brand)"
                        :aria-label="brandLabel(brand.name)"
                        class="font-heading shrink-0 text-lg font-extrabold tracking-[-0.02em] text-ink-faint uppercase transition hover:text-ink md:text-xl"
                    >
                        {{ brand.name }}
                    </Link>
                </div>
            </div>
        </div>

        <Container class="hidden motion-reduce:block">
            <div class="flex flex-wrap items-center justify-around gap-10">
                <Link
                    v-for="brand in brands"
                    :key="brand.id"
                    :href="brandHref(brand)"
                    :aria-label="brandLabel(brand.name)"
                    class="font-heading text-lg font-extrabold tracking-[-0.02em] text-ink-faint uppercase transition hover:text-ink md:text-xl"
                >
                    {{ brand.name }}
                </Link>
            </div>
        </Container>
    </section>
</template>
