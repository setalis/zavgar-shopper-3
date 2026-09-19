<script setup lang="ts">
import { Head, Link, usePage } from '@inertiajs/vue3';
import { Newspaper } from 'lucide-vue-next';
import { computed } from 'vue';
import Container from '@/components/shop/container.vue';
import HreflangLinks from '@/components/shop/hreflang-links.vue';
import NewsSidebarItem from '@/components/shop/news-sidebar-item.vue';
import PageHead from '@/components/shop/page-head.vue';
import type { HreflangLink } from '@/composables/useLocalizedRoute';
import { useLocalizedRoute } from '@/composables/useLocalizedRoute';
import { useTrans } from '@/composables/useTrans';
import { formatLocale } from '@/lib/format';
import { home } from '@/routes';
import * as shop from '@/routes/shop';
import type { NewsArticle } from '@/types/shop';

const props = defineProps<{
    article: NewsArticle;
    latest: NewsArticle[];
    hreflang: HreflangLink[];
}>();

const page = usePage();
const { t } = useTrans();
const { localized } = useLocalizedRoute();

const crumbs = computed(() => [
    { label: t('shop.nav.home'), href: localized(home.url()) },
    { label: t('shop.news.heading'), href: localized(shop.news.url()) },
    { label: props.article.title },
]);

const publishedAt = computed<string>(() => {
    if (!props.article.published_at) {
        return '';
    }

    return new Date(props.article.published_at).toLocaleDateString(
        formatLocale(page.props.locale),
        { year: 'numeric', month: 'long', day: 'numeric' },
    );
});
</script>

<template>
    <Head :title="article.seo_title || article.title">
        <HreflangLinks :links="hreflang" />
    </Head>

    <PageHead
        :title="article.title"
        :description="article.summary ?? undefined"
        :crumbs="crumbs"
    />

    <Container class="py-10 md:py-14">
        <div
            :class="
                latest.length
                    ? 'grid items-start gap-10 lg:grid-cols-[minmax(0,1fr)_300px]'
                    : ''
            "
        >
            <article>
                <time
                    v-if="publishedAt"
                    class="font-mono text-xs tracking-[0.08em] text-ink-mute uppercase"
                    :datetime="article.published_at ?? undefined"
                >
                    {{ publishedAt }}
                </time>

                <div
                    v-if="article.thumbnail"
                    class="mt-6 overflow-hidden rounded-lg bg-muted"
                >
                    <img
                        :src="article.thumbnail"
                        :alt="article.title"
                        class="w-full object-cover object-center"
                    />
                </div>
                <div
                    v-else
                    class="mt-6 grid aspect-[16/9] place-items-center rounded-lg bg-muted"
                >
                    <Newspaper
                        class="size-10 text-ink-faint"
                        aria-hidden="true"
                    />
                </div>

                <div
                    v-if="article.description"
                    class="prose prose-sm mt-8 max-w-none prose-zinc"
                    v-html="article.description"
                />
                <p v-else class="mt-8 text-sm text-ink-mute">
                    {{ t('shop.news.no_body') }}
                </p>
            </article>

            <aside
                v-if="latest.length"
                class="border-t border-rule pt-8 lg:sticky lg:top-24 lg:border-t-0 lg:pt-0"
            >
                <div class="mb-4 flex items-end justify-between gap-3">
                    <h2 class="font-heading text-md font-bold text-ink">
                        {{ t('shop.news.latest') }}
                    </h2>
                    <Link
                        :href="localized(shop.news.url())"
                        class="font-mono text-[11px] tracking-[0.04em] text-brand uppercase transition hover:text-brand-deep"
                    >
                        {{ t('shop.news.view_all') }}
                    </Link>
                </div>

                <div class="flex flex-col gap-1">
                    <NewsSidebarItem
                        v-for="item in latest"
                        :key="item.id"
                        :article="item"
                    />
                </div>
            </aside>
        </div>
    </Container>
</template>
