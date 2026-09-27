<script setup>
// Secondary action button — subtle dark outline.
defineProps({
    href: { type: String, default: null },
    type: { type: String, default: 'button' },
    disabled: { type: Boolean, default: false },
});

const classes = [
    'inline-flex items-center justify-center gap-2 rounded-xl border border-ink-border bg-ink-soft',
    'px-6 py-3 text-sm font-semibold text-neutral-300',
    'transition duration-500',
    'hover:border-orange-500/60 hover:text-orange-400 hover:scale-105',
    'active:scale-95',
    'disabled:pointer-events-none disabled:opacity-50',
].join(' ');
</script>

<template>
    <a v-if="href" :href="href" :class="classes"><slot /></a>
    <button v-else :type="type" :disabled="disabled" :class="classes"><slot /></button>
</template>
