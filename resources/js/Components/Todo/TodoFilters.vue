<script setup>
defineProps({
    filter: { type: String, required: true },
    counts: { type: Object, default: () => ({}) },
});

const emit = defineEmits(['change', 'clearCompleted']);

const filters = [
    { key: 'all', label: 'All' },
    { key: 'active', label: 'Active' },
    { key: 'completed', label: 'Completed' },
];
</script>

<template>
    <div class="flex flex-wrap items-center justify-between gap-3 border-t border-ink-border pt-4">
        <p class="font-mono text-xs text-neutral-500">
            {{ counts.active }} active · {{ counts.completed }} done
        </p>

        <div class="flex rounded-xl border border-ink-border bg-ink p-1" role="group" aria-label="Filter tasks">
            <button
                v-for="item in filters"
                :key="item.key"
                type="button"
                class="rounded-lg px-3 py-1.5 text-xs font-medium transition"
                :class="filter === item.key ? 'bg-orange-500 text-black' : 'text-neutral-400 hover:text-white'"
                :aria-pressed="filter === item.key"
                @click="emit('change', item.key)"
            >
                {{ item.label }}
            </button>
        </div>

        <button
            v-if="counts.completed > 0"
            type="button"
            class="text-xs text-neutral-400 transition hover:text-orange-400"
            @click="emit('clearCompleted')"
        >
            Clear completed
        </button>
    </div>
</template>
