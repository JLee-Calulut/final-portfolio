<script setup>
defineProps({
    eyebrow: { type: String, required: true },
    title: { type: String, required: true },
    description: { type: String, default: '' },
});
</script>

<template>
    <div class="reveal max-w-2xl">
        <h2 class="mt-3 text-3xl font-bold tracking-tight text-white sm:text-4xl">{{ title }}</h2>
        <p v-if="description" class="mt-4 leading-relaxed text-neutral-400">{{ description }}</p>
    </div>
</template>
