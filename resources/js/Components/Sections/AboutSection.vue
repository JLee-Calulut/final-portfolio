<script setup>
import SectionTitle from '@/Components/UI/SectionTitle.vue';
import Card from '@/Components/Cards/Card.vue';
import AppIcon from '@/Components/UI/AppIcon.vue';

const highlights = [
    { label: 'Full-Stack Development', icon: 'layers' },
    { label: 'Responsive Web Design', icon: 'devices' },
    { label: 'Reusable Components', icon: 'components' },
    { label: 'Modern Web Technologies', icon: 'terminal' },
];
</script>

<template>
    <section id="about" class="scroll-mt-16 border-t border-ink-border lg:scroll-mt-0">
        <div class="mx-auto grid max-w-6xl gap-12 px-6 py-24 lg:grid-cols-[1.2fr_1fr]">
            <div>
                <SectionTitle title="About Myself" />

                <div class="reveal mt-6 space-y-4 leading-relaxed text-neutral-400">
                    <p>
                        I'm <span class="font-semibold text-white">John Lee Calulut</span>, a frontend and backend
                        developer. I build modern, responsive web applications — from the database schema
                        all the way to the interface people actually touch.
                    </p>
                    <p>
                        My day-to-day stack is <span class="text-orange-400">Laravel</span> on the backend and
                        <span class="text-orange-400">Vue</span> on the frontend, connected with Inertia and styled
                        with <span class="text-orange-400">Tailwind CSS</span>. I care about clean architecture:
                        thin controllers, honest models, and components that are built once and reused everywhere.
                    </p>
                    <p>
                        I focus on applications that stay maintainable as they grow — responsive by default,
                        accessible to everyone, and structured so the next developer (or future me)
                        can pick them up quickly.
                    </p>
                </div>
            </div>

            <!-- Highlights — no invented numbers, just genuine focus areas -->
            <ul class="grid content-start gap-4 sm:grid-cols-2" aria-label="Focus areas">
                <li v-for="highlight in highlights" :key="highlight.label" class="reveal">
                    <Card class="flex h-full flex-col gap-3">
                        <span class="flex h-10 w-10 items-center justify-center rounded-xl border border-orange-500/30 bg-orange-500/10 text-orange-500">
                            <AppIcon :name="highlight.icon" class="h-5 w-5" />
                        </span>
                        <span class="text-sm font-semibold leading-snug text-white">{{ highlight.label }}</span>
                    </Card>
                </li>
            </ul>
        </div>
    </section>
</template>
