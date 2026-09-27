<script setup>
import { ref, onMounted, onUnmounted, computed } from 'vue';
import { usePage } from '@inertiajs/vue3';
import { site } from '@/Data/site';
import AppIcon from '@/Components/UI/AppIcon.vue';

// Fixed desktop sidebar: compact (icons only) and expands on hover.
// Collapses automatically when the pointer leaves; main content is offset
// by the collapsed width so nothing is permanently covered.
defineProps({
    activeSection: { type: String, default: 'home' },
});

// Anchor links work in-page on the home route; elsewhere they point back
// to the matching section on the homepage so nav is never a dead end.
const page = usePage();
const isHome = computed(() => page.url === '/' || page.url === '/home');
const sectionHref = (id) => (isHome.value ? `#${id}` : `/#${id}`);
</script>

<template>
    <aside
        class="group fixed inset-y-0 left-0 z-40 hidden w-20 flex-col overflow-hidden border-r border-ink-border bg-ink-soft/95 backdrop-blur transition-[width] duration-300 ease-in-out hover:w-64 lg:flex"
        aria-label="Primary navigation"
    >
        <!-- Brand -->
        <a :href="sectionHref('home')" class="flex h-20 shrink-0 items-center gap-4 border-b border-ink-border px-5">
            <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-orange-500 font-mono text-sm font-bold text-black">
                JLC
            </span>
            <span class="whitespace-nowrap opacity-0 transition-opacity duration-200 group-hover:opacity-100">
                <span class="block text-sm font-semibold text-white">{{ site.name }}</span>
                <span class="block text-xs text-neutral-400">{{ site.role }}</span>
            </span>
        </a>

        <!-- Sections -->
        <nav class="flex-1 overflow-y-auto py-6" aria-label="Sections">
            <ul class="space-y-1 px-3">
                <li v-for="item in site.navigation" :key="item.id">
                    <a
                        :href="sectionHref(item.id)"
                        :aria-current="activeSection === item.id ? 'true' : undefined"
                        class="flex items-center gap-4 rounded-xl px-3 py-3 text-sm transition-colors duration-200"
                        :class="
                            activeSection === item.id
                                ? 'bg-orange-500/10 text-orange-400'
                                : 'text-neutral-400 hover:bg-white/5 hover:text-white'
                        "
                    >
                        <AppIcon :name="item.icon" class="h-5 w-5 shrink-0" />
                        <span class="whitespace-nowrap opacity-0 transition-opacity duration-200 group-hover:opacity-100">
                            {{ item.label }}
                        </span>
                    </a>
                </li>
            </ul>
        </nav>

        <!-- Socials -->
        <div class="shrink-0 border-t border-ink-border py-4">
            <ul class="space-y-1 px-3">
                <li v-for="social in site.socials" :key="social.label">
                    <a
                        :href="social.url"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="flex items-center gap-4 rounded-xl px-3 py-2.5 text-sm text-neutral-400 transition-colors duration-200 hover:text-orange-400"
                    >
                        <AppIcon :name="social.icon" class="h-5 w-5 shrink-0" />
                        <span class="whitespace-nowrap opacity-0 transition-opacity duration-200 group-hover:opacity-100">
                            {{ social.label }}
                        </span>
                    </a>
                </li>
            </ul>
        </div>
    </aside>
</template>
