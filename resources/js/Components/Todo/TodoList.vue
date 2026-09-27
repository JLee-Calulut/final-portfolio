<script setup>
import TodoItem from '@/Components/Todo/TodoItem.vue';

defineProps({
    tasks: { type: Array, default: () => [] },
    filter: { type: String, default: 'all' },
});

const emit = defineEmits(['toggle', 'remove', 'update']);
</script>

<template>
    <ul v-if="tasks.length" aria-label="Tasks">
        <TodoItem
            v-for="task in tasks"
            :key="task.id"
            :task="task"
            @toggle="emit('toggle', task.id)"
            @remove="emit('remove', task.id)"
            @update="(id, title) => emit('update', id, title)"
        />
    </ul>

    <div v-else class="rounded-xl border border-dashed border-ink-border px-4 py-10 text-center">
        <p class="font-mono text-sm text-neutral-500">
            <template v-if="filter === 'all'">No tasks yet — add your first one above.</template>
            <template v-else-if="filter === 'active'">Nothing left to do — nice work. 🎉</template>
            <template v-else>No completed tasks yet.</template>
        </p>
    </div>
</template>
