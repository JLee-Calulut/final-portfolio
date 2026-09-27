<script setup>
import { ref } from 'vue';
import AppIcon from '@/Components/UI/AppIcon.vue';

const emit = defineEmits(['add']);
const title = ref('');

function submit() {
    if (!title.value.trim()) {
        return;
    }
    emit('add', title.value);
    title.value = '';
}
</script>

<template>
    <form class="flex items-center gap-3" @submit.prevent="submit">
        <label for="todo-input" class="sr-only">New task</label>
        <input
            id="todo-input"
            v-model="title"
            type="text"
            autocomplete="off"
            maxlength="200"
            placeholder="What needs doing?"
            class="w-full rounded-xl border border-ink-border bg-ink px-4 py-3 text-sm text-white placeholder-neutral-600 transition focus:border-orange-500 focus:outline-none focus:ring-2 focus:ring-orange-500/30"
        >
        <button
            type="submit"
            class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-orange-500 text-black transition hover:bg-orange-400 active:scale-95"
            aria-label="Add task"
        >
            <AppIcon name="plus" class="h-5 w-5" />
        </button>
    </form>
</template>
