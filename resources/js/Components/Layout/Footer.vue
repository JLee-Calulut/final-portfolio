<script setup>
import { useTheme } from '@/Composables/useTheme';
import AppIcon from '@/Components/UI/AppIcon.vue';

const { site, currentYear } = useTheme();
</script>

<template>
    <footer class="border-t border-ink-border bg-ink-soft">
        <div class="mx-auto flex max-w-6xl flex-col items-center gap-6 px-6 py-12 sm:flex-row sm:justify-between">
            <div class="text-center sm:text-left">
                <p class="font-semibold text-white">{{ site.name }}</p>
                <p class="mt-1 text-sm text-neutral-500">{{ site.role }}</p>
            </div>

            <ul class="flex gap-3" aria-label="Social links">
                <li v-for="social in site.socials" :key="social.label">
                    <a
                        :href="social.url"
                        target="_blank"
                        rel="noopener noreferrer"
                        :aria-label="social.label"
                        class="flex h-11 w-11 items-center justify-center rounded-xl border border-ink-border text-neutral-400 transition duration-300 hover:border-orange-500 hover:text-orange-400"
                    >
                        <AppIcon :name="social.icon" class="h-5 w-5" />
                    </a>
                </li>
            </ul>
        </div>

        <div class="border-t border-ink-border py-6 text-center text-xs text-neutral-600">
            <p>
                © {{ currentYear }} {{ site.fullName }} · Built with
                <span class="text-orange-500/80">Laravel</span>,
                <span class="text-orange-500/80">Vue</span> &amp;
                <span class="text-orange-500/80">Tailwind CSS</span>
            </p>
        </div>
    </footer>
</template>
