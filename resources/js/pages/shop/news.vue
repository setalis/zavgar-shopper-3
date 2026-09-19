<script setup lang="ts">
import { Head, router } from '@inertiajs/vue3';
import { Newspaper, Search } from 'lucide-vue-next';
import { computed, ref, watch } from 'vue';
import Container from '@/components/shop/container.vue';
import NewsCard from '@/components/shop/news-card.vue';
import PageHead from '@/components/shop/page-head.vue';
import ProductPagination from '@/components/shop/product-pagination.vue';
import type { PaginatorLink } from '@/components/shop/product-pagination.vue';
import { useLocalizedRoute } from '@/composables/useLocalizedRoute';
import { useTrans } from '@/composables/useTrans';
import { home } from '@/routes';
import * as shop from '@/routes/shop';
import type { NewsArticle } from '@/types/shop';

type Paginated<T> = {
    data: T[];
    current_page: number;
    last_page: number;
    total: number;
    links: PaginatorLink[];
};

type Filters = {
    q: string;
};

const props = defineProps<{
    articles: Paginated<NewsArticle>;
    filters: Filters;
}>();

const { t } = useTrans();
const { localized } = useLocalizedRoute();

const search = ref<string>(props.filters.q);
let debounceId: number | undefined;

const crumbs = computed(() => [
    { label: t('shop.nav.home'), href: localized(home.url()) },
    { label: t('shop.news.heading') },
]);

function visit(overrides: Partial<Filters> = {}): void {
    const next = { ...props.filters, ...overrides };

    router.get(
        localized(shop.news.url()),
        {
            q: next.q || undefined,
        },
        { preserveState: true, preserveScroll: true, replace: true },
    );
}

watch(search, (value) => {
    window.clearTimeout(debounceId);
    debounceId = window.setTimeout(() => {
        visit({ q: value });
    }, 300);
});
</script>

<template>
    <Head :title="t('shop.news.title')" />

    <PageHead
        :title="t('shop.news.heading')"
        :description="t('shop.news.subtitle')"
        :crumbs="crumbs"
    >
        <div class="relative mt-6 max-w-[560px]">
            <Search
                class="pointer-events-none absolute top-1/2 left-5 size-[18px] -translate-y-1/2 text-ink-faint"
                aria-hidden="true"
            />
            <input
                v-model="search"
                type="search"
                :placeholder="t('shop.news.search_placeholder')"
                :aria-label="t('shop.news.search_aria')"
                class="w-full rounded-full border border-rule-strong bg-paper py-3.5 pr-5 pl-13 text-base transition placeholder:text-ink-faint focus:border-brand focus:ring-4 focus:ring-brand/12 focus:outline-none"
            />
        </div>
    </PageHead>

    <Container class="py-10 md:py-14">
        <div
            v-if="!articles.data.length"
            class="flex flex-col items-center justify-center rounded-lg border border-rule bg-paper py-20 text-center"
        >
            <Newspaper class="size-10 text-ink-faint" aria-hidden="true" />
            <h3 class="mt-4 font-heading text-md font-bold text-ink">
                {{ t('shop.news.empty') }}
            </h3>
        </div>

        <template v-else>
            <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                <NewsCard
                    v-for="article in articles.data"
                    :key="article.id"
                    :article="article"
                />
            </div>

            <ProductPagination
                :links="articles.links"
                :label="t('shop.news.pagination')"
            />
        </template>
    </Container>
</template>
