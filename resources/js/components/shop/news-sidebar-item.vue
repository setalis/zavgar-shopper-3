<script setup lang="ts">
import { Link, usePage } from '@inertiajs/vue3';
import { Newspaper } from 'lucide-vue-next';
import { computed } from 'vue';
import { useLocalizedRoute } from '@/composables/useLocalizedRoute';
import { formatLocale } from '@/lib/format';
import * as shop from '@/routes/shop';
import type { NewsArticle } from '@/types/shop';

const props = defineProps<{
    article: NewsArticle;
}>();

const page = usePage();
const { localized } = useLocalizedRoute();

const href = computed<string>(() =>
    localized(shop.news.show.url({ article: props.article.slug })),
);

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
    <Link
        :href="href"
        class="group flex gap-3 rounded-lg p-1.5 transition duration-200 ease-brand hover:bg-brand-soft"
    >
        <div class="size-16 shrink-0 overflow-hidden rounded-md bg-muted">
            <img
                v-if="article.thumbnail"
                :src="article.thumbnail"
                :alt="article.title"
                loading="lazy"
                class="size-full object-cover object-center"
            />
            <div v-else class="grid size-full place-items-center">
                <Newspaper class="size-5 text-ink-faint" aria-hidden="true" />
            </div>
        </div>

        <span class="flex min-w-0 flex-col gap-1">
            <time
                v-if="publishedAt"
                class="font-mono text-[11px] tracking-[0.04em] text-ink-mute uppercase"
                :datetime="article.published_at ?? undefined"
            >
                {{ publishedAt }}
            </time>
            <span
                class="line-clamp-2 font-heading text-sm font-bold text-ink group-hover:text-brand"
            >
                {{ article.title }}
            </span>
        </span>
    </Link>
</template>
