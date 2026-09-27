<script setup>
import { computed, ref } from 'vue';
import { usePage } from '@inertiajs/vue3';
import { site } from '@/Data/site';
import { useScrollSpy } from '@/Composables/useScrollSpy';
import { useScrollReveal } from '@/Composables/useScrollReveal';
import Sidebar from '@/Components/Navigation/Sidebar.vue';
import MobileMenu from '@/Components/Navigation/MobileMenu.vue';
import Footer from '@/Components/Layout/Footer.vue';

const sectionIds = site.navigation.map((item) => item.id);
const activeSection = useScrollSpy(sectionIds);

const main = ref(null);
useScrollReveal(main);

// Skip link follows the same route-aware anchor rule as the nav.
const page = usePage();
const isHome = computed(() => page.url === '/' || page.url === '/home');
const homeHref = () => (isHome.value ? '#home' : '/#home');
</script>

<template>
    <div class="min-h-screen bg-ink text-white">
        <!-- Skip link for keyboard users -->
        <a
            :href="homeHref()"
            class="sr-only focus:not-sr-only focus:fixed focus:left-4 focus:top-4 focus:z-[60] focus:rounded-lg focus:bg-orange-500 focus:px-4 focus:py-2 focus:text-sm focus:font-semibold focus:text-black"
        >
            Skip to content
        </a>

        <Sidebar :active-section="activeSection" />
        <MobileMenu :active-section="activeSection" />

        <!-- Offset by the collapsed sidebar width on desktop -->
        <div class="lg:pl-20">
            <main id="content" ref="main" class="pt-16 lg:pt-0">
                <slot />
            </main>
            <Footer />
        </div>
    </div>
</template>
