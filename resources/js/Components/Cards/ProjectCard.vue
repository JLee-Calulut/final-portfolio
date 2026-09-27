<script setup>
import { Link } from '@inertiajs/vue3';
import Card from '@/Components/Cards/Card.vue';
import AppIcon from '@/Components/UI/AppIcon.vue';

defineProps({
    project: { type: Object, required: true },
});

const placeholderButtonClasses =
    'inline-flex cursor-not-allowed items-center gap-2 rounded-lg border border-ink-border px-4 py-2 text-xs font-semibold text-neutral-600';
const linkButtonClasses =
    'inline-flex items-center gap-2 rounded-lg border border-ink-border bg-ink px-4 py-2 text-xs font-semibold text-neutral-200 transition duration-300 hover:border-orange-500 hover:text-orange-400';
</script>

<template>
    <Card class="reveal flex h-full flex-col overflow-hidden !p-0 transition duration-500 hover:-translate-y-2 hover:border-orange-500/60 hover:shadow-2xl">
        <!-- Thumbnail: real image when provided, otherwise an on-theme placeholder -->
        <div class="relative flex h-44 shrink-0 items-center justify-center overflow-hidden border-b border-ink-border bg-ink-soft">
            <div class="bg-grid absolute inset-0 opacity-60" aria-hidden="true" />
            <img
                v-if="project.thumbnail"
                :src="project.thumbnail"
                :alt="`${project.title} screenshot`"
                loading="lazy"
                class="absolute inset-0 h-full w-full object-cover"
            >
            <AppIcon v-else name="terminal" class="relative h-10 w-10 text-orange-500/80" aria-hidden="true" />
        </div>

        <div class="flex flex-1 flex-col gap-4 p-6">
            <h3 class="text-lg font-semibold text-white">{{ project.title }}</h3>
            <p class="text-sm leading-relaxed text-neutral-400">{{ project.description }}</p>

            <ul v-if="project.tech_stack?.length" class="flex flex-wrap gap-2" aria-label="Technologies used">
                <li
                    v-for="tech in project.tech_stack"
                    :key="tech"
                    class="rounded-md border border-ink-border bg-ink px-2.5 py-1 font-mono text-xs text-orange-400"
                >
                    {{ tech }}
                </li>
            </ul>

            <!-- Actions: real links when URLs exist, clearly marked placeholders otherwise -->
            <div class="mt-auto flex flex-wrap gap-2 pt-2">
                <a
                    v-if="project.github_url"
                    :href="project.github_url"
                    target="_blank"
                    rel="noopener noreferrer"
                    :class="linkButtonClasses"
                >
                    <AppIcon name="github" class="h-4 w-4" /> GitHub
                </a>
                <span v-else :class="placeholderButtonClasses" title="Repository link coming soon" aria-disabled="true">
                    <AppIcon name="github" class="h-4 w-4" /> GitHub — soon
                </span>

                <Link
                    v-if="project.demo_url?.startsWith('/')"
                    :href="project.demo_url"
                    :class="linkButtonClasses"
                >
                    <AppIcon name="external" class="h-4 w-4" /> Live Demo
                </Link>
                <a
                    v-else-if="project.demo_url"
                    :href="project.demo_url"
                    target="_blank"
                    rel="noopener noreferrer"
                    :class="linkButtonClasses"
                >
                    <AppIcon name="external" class="h-4 w-4" /> Live Demo
                </a>
                <span v-else :class="placeholderButtonClasses" title="Live demo coming soon" aria-disabled="true">
                    <AppIcon name="external" class="h-4 w-4" /> Demo — soon
                </span>

                <span :class="placeholderButtonClasses" title="Case study coming soon" aria-disabled="true">
                    Details — soon
                </span>
            </div>
        </div>
    </Card>
</template>
