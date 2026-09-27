<script setup>
import SectionTitle from '@/Components/UI/SectionTitle.vue';
import SkillCard from '@/Components/Cards/SkillCard.vue';

// `skills` arrives grouped by category from PortfolioController.
defineProps({
    skills: { type: Object, default: () => ({}) },
});

const groups = [
    { key: 'frontend', label: 'Frontend' },
    { key: 'backend', label: 'Backend' },
    { key: 'database', label: 'Database' },
    { key: 'tools', label: 'Tools' },
];
</script>

<template>
    <section id="skills" class="scroll-mt-16 border-t border-ink-border bg-ink-soft/40 lg:scroll-mt-0">
        <div class="mx-auto max-w-6xl px-6 py-24">
            <SectionTitle
                title="Tech stack"
                description="The technologies I build with every day — grouped by where they live in the stack."
            />

            <div class="mt-14 space-y-14">
                <div v-for="group in groups" :key="group.key">
                    <template v-if="skills[group.key]?.length">
                        <h3 class="reveal mb-6 flex items-center gap-3 font-mono text-sm text-orange-500">
                            <span class="h-px w-8 bg-orange-500/50" aria-hidden="true" />
                            {{ group.label }}
                        </h3>
                        <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
                            <SkillCard v-for="skill in skills[group.key]" :key="skill.id" :skill="skill" />
                        </div>
                    </template>
                </div>
            </div>
        </div>
    </section>
</template>
