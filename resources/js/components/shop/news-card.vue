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
        class="group flex flex-col overflow-hidden rounded-lg border border-rule bg-paper transition duration-200 ease-brand hover:-translate-y-[3px] hover:border-brand-line hover:bg-brand-soft"
    >
        <div class="aspect-[16/9] overflow-hidden bg-muted">
            <img
                v-if="article.thumbnail"
                :src="article.thumbnail"
                :alt="article.title"
                loading="lazy"
                class="size-full object-cover object-center transition duration-200 group-hover:scale-[1.03]"
            />
            <div v-else class="grid size-full place-items-center">
                <Newspaper class="size-8 text-ink-faint" aria-hidden="true" />
            </div>
        </div>

        <div class="flex flex-1 flex-col gap-2 p-5">
            <time
                v-if="publishedAt"
                class="font-mono text-[11px] tracking-[0.04em] text-ink-mute uppercase"
                :datetime="article.published_at ?? undefined"
            >
                {{ publishedAt }}
            </time>
            <span class="font-heading text-sm font-bold text-ink">
                {{ article.title }}
            </span>
            <p
                v-if="article.summary"
                class="line-clamp-3 text-sm text-ink-mute"
            >
                {{ article.summary }}
            </p>
        </div>
    </Link>
</template>
