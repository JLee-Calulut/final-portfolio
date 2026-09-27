<script setup>
defineProps({
    history: { type: Array, default: () => [] },
});

const emit = defineEmits(['reuse', 'clear']);
</script>

<template>
    <div class="rounded-2xl border border-ink-border bg-ink-card p-6">
        <div class="flex items-center justify-between gap-3">
            <h2 class="text-sm font-semibold text-white">History</h2>
            <button
                v-if="history.length"
                type="button"
                class="rounded-lg border border-ink-border px-3 py-1.5 text-xs text-neutral-400 transition hover:border-orange-500/50 hover:text-orange-400"
                @click="emit('clear')"
            >
                Clear
            </button>
        </div>

        <p v-if="history.length === 0" class="mt-6 rounded-xl border border-dashed border-ink-border px-4 py-8 text-center font-mono text-xs text-neutral-500">
            No calculations yet — tap a few keys.
        </p>

        <ol v-else class="mt-4 max-h-80 space-y-2 overflow-y-auto lg:max-h-[26rem]">
            <li v-for="item in history" :key="item.id">
                <button
                    type="button"
                    class="flex w-full items-baseline justify-between gap-4 rounded-xl border border-ink-border bg-ink px-4 py-3 text-left transition hover:border-orange-500/50"
                    :title="`Use ${item.result} as the starting point`"
                    @click="emit('reuse', item)"
                >
                    <span class="truncate font-mono text-xs text-neutral-500">{{ item.expression }}</span>
                    <span class="shrink-0 font-mono text-sm font-semibold text-white">{{ item.result }}</span>
                </button>
            </li>
        </ol>
    </div>
</template>
