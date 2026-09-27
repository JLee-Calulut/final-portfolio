<script setup>
import Card from '@/Components/Cards/Card.vue';
import AppIcon from '@/Components/UI/AppIcon.vue';

// Informational card — deliberately NOT interactive, so it keeps the
// neutral style (no orange hover background) per the design system.
defineProps({
    service: { type: Object, required: true },
});
</script>

<template>
    <Card class="reveal h-full transition duration-500 hover:-translate-y-1 hover:border-orange-500/40">
        <span class="flex h-12 w-12 items-center justify-center rounded-xl border border-orange-500/30 bg-orange-500/10 text-orange-500">
            <AppIcon :name="service.icon ?? 'code'" class="h-6 w-6" />
        </span>
        <h3 class="mt-5 text-lg font-semibold text-white">{{ service.title }}</h3>
        <p class="mt-2 text-sm leading-relaxed text-neutral-400">{{ service.description }}</p>
    </Card>
</template>
