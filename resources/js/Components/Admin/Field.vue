<script setup>
// Labelled form field with error message. Slots default to an <input>,
// but any element can be wrapped (select, textarea, toggle, chips).
const props = defineProps({
    label: { type: String, required: true },
    hint: { type: String, default: '' },
    error: { type: String, default: '' },
});
</script>

<template>
    <label class="block">
        <span class="mb-2 block text-sm font-medium text-neutral-200">{{ label }}</span>
        <slot />
        <span v-if="hint" class="mt-2 block text-xs text-neutral-500">{{ hint }}</span>
        <span v-if="error" class="mt-2 block text-xs text-red-400">{{ error }}</span>
    </label>
</template>
