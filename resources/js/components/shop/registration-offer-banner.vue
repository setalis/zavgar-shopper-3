<script setup lang="ts">
import { Link, usePage } from '@inertiajs/vue3';
import Container from '@/components/shop/container.vue';
import { Button } from '@/components/ui/button';
import { useTrans } from '@/composables/useTrans';
import { register } from '@/routes';

const page = usePage();
const { t } = useTrans();
</script>

<template>
    <Container v-if="!page.props.auth.user">
        <div
            class="relative my-14 overflow-hidden rounded-2xl bg-linear-to-br from-brand via-brand-deep to-card-purple-2 px-10 py-14 text-paper"
        >
            <div
                class="pointer-events-none absolute inset-0 bg-[radial-gradient(circle_at_80%_20%,rgb(255_255_255/0.18)_0,transparent_40%),radial-gradient(circle_at_10%_80%,rgb(255_255_255/0.1)_0,transparent_50%)]"
                aria-hidden="true"
            />

            <div class="relative grid items-center gap-10 lg:grid-cols-2">
                <div>
                    <h2
                        class="max-w-[18ch] text-display leading-[1.05] tracking-[-0.025em] text-paper"
                    >
                        {{ t('shop.registration_offer.title') }}
                        <strong class="font-extrabold text-amber">
                            {{ t('shop.registration_offer.title_highlight') }}
                        </strong>
                    </h2>
                    <p class="mt-3 max-w-[38ch] text-md text-paper/86">
                        {{ t('shop.registration_offer.description') }}
                    </p>
                </div>

                <div class="flex lg:justify-end">
                    <Button as-child variant="paper" size="lg">
                        <Link :href="register.url()">
                            {{ t('shop.registration_offer.cta') }}
                        </Link>
                    </Button>
                </div>
            </div>
        </div>
    </Container>
</template>
