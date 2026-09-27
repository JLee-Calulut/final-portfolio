<script setup>
// Base card — neutral, informational by default. Set `interactive` for
// cards that behave as links/actions (orange hover treatment).
defineProps({
    interactive: { type: Boolean, default: false },
});
</script>

<template>
    <div
        class="rounded-2xl border border-ink-border bg-ink-card p-6"
        :class="
            interactive
                ? 'transition duration-500 hover:-translate-y-2 hover:border-orange-500/60 hover:shadow-2xl'
                : ''
        "
    >
        <slot />
    </div>
</template>
