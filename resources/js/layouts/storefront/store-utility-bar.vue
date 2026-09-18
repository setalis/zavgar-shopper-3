<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import Container from '@/components/shop/container.vue';
import LocaleSwitcher from '@/components/shop/locale-switcher.vue';
import { useLocalizedRoute } from '@/composables/useLocalizedRoute';
import { useTrans } from '@/composables/useTrans';
import { orders as accountOrders } from '@/routes/account';
import * as shop from '@/routes/shop';

const { t } = useTrans();
const { localized } = useLocalizedRoute();
</script>

<template>
    <div class="bg-ink font-mono text-xs tracking-[0.04em] text-paper">
        <Container
            class="flex flex-wrap items-center justify-between gap-3 py-2.5"
        >
            <span class="inline-flex items-center gap-2">
                <span
                    class="rounded-full bg-rose px-2 py-2 text-[11px] font-medium tracking-[0.06em]"
                >
                    <!-- {{ t('shop.utility.tag') }} -->
                    <svg xmlns="http://www.w3.org/2000/svg" width="2em" height="2em" viewBox="0 0 24 24">
                        <path d="M0 0h24v24H0z" fill="none" />
                        <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 4h4l2 5l-2.5 1.5a11 11 0 0 0 5 5L15 13l5 2v4a2 2 0 0 1-2 2A16 16 0 0 1 3 6a2 2 0 0 1 2-2m10 3a2 2 0 0 1 2 2m-2-6a6 6 0 0 1 6 6" />
                    </svg>

                </span>
                <!-- {{ t('shop.utility.promo') }} -->
                <a href="tel:+380955807707" class="text-base font-bold">(095) 580 77 07</a>
            </span>

            <span
                class="hidden items-center gap-5 text-paper/70 md:inline-flex"
            >
                <Link
                    :href="localized(accountOrders.url())"
                    class="transition hover:text-paper"
                >
                    {{ t('shop.utility.track_order') }}
                </Link>
                <Link
                    :href="localized(shop.contact.url())"
                    class="transition hover:text-paper"
                >
                    {{ t('shop.utility.help') }}
                </Link>
                <LocaleSwitcher />
            </span>
        </Container>
    </div>
</template>
