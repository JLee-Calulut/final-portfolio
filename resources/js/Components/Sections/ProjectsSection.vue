<script setup>
import { Link } from '@inertiajs/vue3';
import SectionTitle from '@/Components/UI/SectionTitle.vue';
import ProjectCard from '@/Components/Cards/ProjectCard.vue';
import AppIcon from '@/Components/UI/AppIcon.vue';

// Projects come from the database — add a row and a new card appears.
defineProps({
    projects: { type: Array, default: () => [] },
});
</script>

<template>
    <section id="projects" class="scroll-mt-16 border-t border-ink-border bg-ink-soft/40 lg:scroll-mt-0">
        <div class="mx-auto max-w-6xl px-6 py-24">
            <div class="flex flex-wrap items-end justify-between gap-4">
                <SectionTitle
                    title="Selected work"
                    description="A few things I've designed and built. More in the works."
                />
                <div class="flex flex-wrap items-center gap-3">
                    <Link
                        href="/calculator"
                        class="mb-1 inline-flex items-center gap-2 rounded-xl border border-ink-border bg-ink-soft px-5 py-2.5 text-sm font-semibold text-neutral-300 transition duration-500 hover:border-orange-500/60 hover:text-orange-400"
                    >
                        Try the Calculator
                        <AppIcon name="arrow-right" class="h-4 w-4" />
                    </Link>
                    <Link
                        href="/todo"
                        class="mb-1 inline-flex items-center gap-2 rounded-xl border border-ink-border bg-ink-soft px-5 py-2.5 text-sm font-semibold text-neutral-300 transition duration-500 hover:border-orange-500/60 hover:text-orange-400"
                    >
                        Try the Todo App
                        <AppIcon name="arrow-right" class="h-4 w-4" />
                    </Link>
                </div>
            </div>

            <div v-if="projects.length" class="mt-14 grid gap-6 md:grid-cols-2">
                <ProjectCard v-for="project in projects" :key="project.id" :project="project" />
            </div>

            <!-- Friendly empty state instead of a broken section -->
            <p v-else class="reveal mt-14 rounded-2xl border border-dashed border-ink-border p-8 text-center text-sm text-neutral-500">
                Projects are being prepared — check back soon.
            </p>
        </div>
    </section>
</template>
