<script setup>
import { onBeforeUnmount, ref, watch, computed } from 'vue';
import { usePage } from '@inertiajs/vue3';
import { site } from '@/Data/site';
import AppIcon from '@/Components/UI/AppIcon.vue';

// Mobile navigation: fixed top bar + slide-in menu.
// Closes after a section is selected, on Escape, or on backdrop click.
defineProps({
    activeSection: { type: String, default: 'home' },
});

// Anchor links stay in-page on the home route; elsewhere they return to the
// matching homepage section so the nav never leads to a blank jump.
const page = usePage();
const isHome = computed(() => page.url === '/' || page.url === '/home');
const sectionHref = (id) => (isHome.value ? `#${id}` : `/#${id}`);

const open = ref(false);

function toggle() {
    open.value = !open.value;
}

function close() {
    open.value = false;
}

function onKeydown(event) {
    if (event.key === 'Escape') close();
}

// Lock body scroll while the menu is open.
watch(open, (isOpen) => {
    document.body.style.overflow = isOpen ? 'hidden' : '';
    if (isOpen) {
        window.addEventListener('keydown', onKeydown);
    } else {
        window.removeEventListener('keydown', onKeydown);
    }
});

onBeforeUnmount(() => {
    document.body.style.overflow = '';
    window.removeEventListener('keydown', onKeydown);
});
</script>

<template>
    <!-- Top bar -->
    <header class="fixed inset-x-0 top-0 z-40 flex h-16 items-center justify-between border-b border-ink-border bg-ink/85 px-4 backdrop-blur lg:hidden">
        <a :href="sectionHref('home')" class="flex items-center gap-3">
            <span class="flex h-9 w-9 items-center justify-center rounded-lg bg-orange-500 font-mono text-sm font-bold text-black">JLC</span>
            <span class="text-sm font-semibold text-white">{{ site.name }}</span>
        </a>
        <button
            type="button"
            class="flex h-11 w-11 items-center justify-center rounded-xl border border-ink-border text-neutral-300 transition hover:border-orange-500 hover:text-orange-400"
            :aria-expanded="open"
            aria-controls="mobile-menu"
            aria-label="Toggle navigation menu"
            @click="toggle"
        >
            <AppIcon :name="open ? 'x' : 'menu'" class="h-5 w-5" />
        </button>
    </header>

    <!-- Overlay + panel -->
    <Teleport to="body">
        <Transition
            enter-active-class="transition-opacity duration-300"
            enter-from-class="opacity-0"
            leave-active-class="transition-opacity duration-300"
            leave-to-class="opacity-0"
        >
            <div
                v-if="open"
                class="fixed inset-0 z-40 bg-black/60 backdrop-blur-sm lg:hidden"
                aria-hidden="true"
                @click="close"
            />
        </Transition>

        <Transition
            enter-active-class="transition-transform duration-300 ease-out"
            enter-from-class="translate-x-full"
            leave-active-class="transition-transform duration-300 ease-in"
            leave-to-class="translate-x-full"
        >
            <div
                v-if="open"
                id="mobile-menu"
                role="dialog"
                aria-modal="true"
                aria-label="Navigation menu"
                class="fixed inset-y-0 right-0 z-50 flex w-72 max-w-[85vw] flex-col border-l border-ink-border bg-ink-soft lg:hidden"
            >
                <div class="flex h-16 items-center justify-between border-b border-ink-border px-5">
                    <button
                        type="button"
                        class="flex h-11 w-11 items-center justify-center rounded-xl text-neutral-400 transition hover:text-orange-400"
                        aria-label="Close navigation menu"
                        @click="close"
                    >
                        <AppIcon name="x" class="h-5 w-5" />
                    </button>
                </div>

                <nav class="flex-1 overflow-y-auto py-6" aria-label="Sections">
                    <ul class="space-y-1 px-4">
                        <li v-for="item in site.navigation" :key="item.id">
                            <a
                                :href="sectionHref(item.id)"
                                class="flex items-center gap-4 rounded-xl px-4 py-3 text-sm transition-colors duration-200"
                                :class="
                                    activeSection === item.id
                                        ? 'bg-orange-500/10 text-orange-400'
                                        : 'text-neutral-300 hover:bg-white/5 hover:text-white'
                                "
                                @click="close"
                            >
                                <AppIcon :name="item.icon" class="h-5 w-5" />
                                {{ item.label }}
                            </a>
                        </li>
                    </ul>
                </nav>

                <div class="border-t border-ink-border p-5">
                    <ul class="flex gap-3">
                        <li v-for="social in site.socials" :key="social.label">
                            <a
                                :href="social.url"
                                target="_blank"
                                rel="noopener noreferrer"
                                :aria-label="social.label"
                                class="flex h-11 w-11 items-center justify-center rounded-xl border border-ink-border text-neutral-400 transition hover:border-orange-500 hover:text-orange-400"
                            >
                                <AppIcon :name="social.icon" class="h-5 w-5" />
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </Transition>
    </Teleport>
</template>
