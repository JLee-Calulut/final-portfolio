<script setup>
defineProps({
    preview: { type: String, default: '' },
    value: { type: String, required: true },
});
</script>

<template>
    <div class="rounded-2xl border border-ink-border bg-ink px-6 py-5">
        <div
            class="min-h-5 overflow-hidden text-right font-mono text-sm text-neutral-500"
            aria-hidden="true"
        >
            {{ preview }}
        </div>

        <output
            class="block truncate text-right font-mono text-4xl font-medium tracking-tight text-white md:text-5xl"
            aria-live="polite"
            :aria-label="`Result ${value}`"
        >
            {{ value }}
        </output>
    </div>
</template>
