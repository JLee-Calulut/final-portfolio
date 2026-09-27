<script setup>
import useTodoList from '@/Composables/useTodoList';
import TodoInput from '@/Components/Todo/TodoInput.vue';
import TodoFilters from '@/Components/Todo/TodoFilters.vue';
import TodoList from '@/Components/Todo/TodoList.vue';

const todo = useTodoList();
</script>

<template>
    <div class="rounded-3xl border border-ink-border bg-ink-soft/80 p-5 shadow-glow backdrop-blur sm:p-6">
        <TodoInput @add="todo.add" />

        <div class="mt-4">
            <TodoList
                :tasks="todo.filteredTasks.value"
                :filter="todo.filter.value"
                @toggle="todo.toggle"
                @remove="todo.remove"
                @update="todo.update"
            />
        </div>

        <div class="mt-4">
            <TodoFilters
                :filter="todo.filter.value"
                :counts="{ active: todo.activeCount.value, completed: todo.completedCount.value }"
                @change="todo.setFilter"
                @clear-completed="todo.clearCompleted"
            />
        </div>
    </div>
</template>
