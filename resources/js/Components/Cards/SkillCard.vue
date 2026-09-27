<script setup>
import { computed } from 'vue';
import Card from '@/Components/Cards/Card.vue';
import AppIcon from '@/Components/UI/AppIcon.vue';

const props = defineProps({
    skill: { type: Object, required: true },
});

// Category-based icon fallback keeps cards visual without fake brand logos.
const categoryIcons = {
    frontend: 'monitor',
    backend: 'server',
    database: 'database',
    tools: 'tools',
};

const iconName = computed(() => props.skill.icon && categoryIcons[props.skill.icon]
    ? props.skill.icon
    : categoryIcons[props.skill.category] ?? 'code');

// Clamp proficiency so a bad value never breaks the bar.
const proficiency = computed(() => {
    const value = Number(props.skill.proficiency);
    if (Number.isNaN(value)) return null;
    return Math.min(100, Math.max(0, value));
});
</script>

<template>
    <Card class="reveal h-full">
        <div class="flex items-center gap-4">
            <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl border border-orange-500/30 bg-orange-500/10 text-orange-500">
                <AppIcon :name="iconName" class="h-5 w-5" />
            </span>
            <div>
                <h3 class="font-semibold text-white">{{ skill.name }}</h3>
                <p v-if="skill.description" class="mt-0.5 text-sm text-neutral-400">{{ skill.description }}</p>
            </div>
        </div>

        <div v-if="proficiency !== null" class="mt-5">
            <div class="flex items-center justify-between text-xs">
                <span class="text-neutral-500">Proficiency</span>
                <span class="font-mono text-orange-400">{{ proficiency }}%</span>
            </div>
            <div
                class="mt-2 h-1.5 overflow-hidden rounded-full bg-ink"
                role="progressbar"
                :aria-valuenow="proficiency"
                aria-valuemin="0"
                aria-valuemax="100"
                :aria-label="`${skill.name} proficiency`"
            >
                <div
                    class="h-full rounded-full bg-gradient-to-r from-orange-600 to-orange-400 transition-[width] duration-700"
                    :style="{ width: `${proficiency}%` }"
                />
            </div>
        </div>
    </Card>
</template>
