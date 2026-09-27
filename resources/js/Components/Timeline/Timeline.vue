<script setup>
// Reusable vertical timeline. Used for the "Development Journey" today;
// drop in real employment entries later without touching the component.
defineProps({
    items: { type: Array, default: () => [] },
});
</script>

<template>
    <ol class="relative space-y-10 border-l border-ink-border pl-8">
        <li v-for="(item, index) in items" :key="item.id ?? index" class="reveal relative">
            <!-- Node -->
            <span
                class="absolute -left-[41px] top-1 flex h-5 w-5 items-center justify-center rounded-full border border-orange-500 bg-ink"
                aria-hidden="true"
            >
                <span class="h-2 w-2 rounded-full bg-orange-500" />
            </span>

            <p v-if="item.period" class="font-mono text-xs text-orange-400">{{ item.period }}</p>
            <h3 class="text-lg font-semibold text-white">{{ item.title }}</h3>
            <p v-if="item.subtitle" class="mt-0.5 text-sm text-orange-400/80">{{ item.subtitle }}</p>
            <p v-if="item.description" class="mt-2 max-w-xl text-sm leading-relaxed text-neutral-400">
                {{ item.description }}
            </p>
        </li>
    </ol>
</template>
