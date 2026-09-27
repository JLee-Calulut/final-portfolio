<script setup>
import { nextTick, ref } from 'vue';
import AppIcon from '@/Components/UI/AppIcon.vue';

const props = defineProps({
    task: { type: Object, required: true },
});

const emit = defineEmits(['toggle', 'remove', 'update']);

const editing = ref(false);
const draft = ref(props.task.title);

async function startEdit() {
    draft.value = props.task.title;
    editing.value = true;
    await nextTick();
    document.getElementById(`todo-edit-${props.task.id}`)?.focus();
}

function saveEdit() {
    emit('update', props.task.id, draft.value);
    editing.value = false;
}

function cancelEdit() {
    editing.value = false;
}

function onKeydown(event) {
    if (event.key === 'Enter') {
        saveEdit();
    } else if (event.key === 'Escape') {
        cancelEdit();
    }
}
</script>

<template>
    <li class="group flex items-start gap-3 border-b border-ink-border py-3 last:border-b-0">
        <!-- Toggle -->
        <button
            type="button"
            class="mt-0.5 flex h-6 w-6 shrink-0 items-center justify-center rounded-md border transition"
            :class="task.done
                ? 'border-orange-500 bg-orange-500 text-black'
                : 'border-ink-border text-transparent hover:border-orange-500/60 hover:text-orange-500/40'"
            :aria-label="task.done ? `Mark ${task.title} as not done` : `Mark ${task.title} as done`"
            :aria-pressed="task.done"
            @click="emit('toggle', task.id)"
        >
            <AppIcon name="check" class="h-4 w-4" />
        </button>

        <!-- Title / edit input -->
        <div class="min-w-0 flex-1">
            <input
                v-if="editing"
                :id="`todo-edit-${task.id}`"
                v-model="draft"
                type="text"
                maxlength="200"
                class="w-full rounded-lg border border-orange-500/60 bg-ink px-3 py-1 text-sm text-white focus:outline-none focus:ring-2 focus:ring-orange-500/30"
                @keydown="onKeydown"
                @blur="saveEdit"
            >
            <p
                v-else
                class="break-words text-sm leading-relaxed transition"
                :class="task.done ? 'text-neutral-500 line-through' : 'text-neutral-200'"
                @dblclick="startEdit"
            >
                {{ task.title }}
            </p>
        </div>

        <!-- Actions -->
        <div class="flex shrink-0 items-center gap-1 opacity-0 transition group-hover:opacity-100 focus-within:opacity-100">
            <button
                type="button"
                class="flex h-8 w-8 items-center justify-center rounded-lg text-neutral-400 transition hover:bg-white/5 hover:text-orange-400"
                :aria-label="`Edit ${task.title}`"
                @click="startEdit"
            >
                <AppIcon name="pencil" class="h-4 w-4" />
            </button>
            <button
                type="button"
                class="flex h-8 w-8 items-center justify-center rounded-lg text-neutral-400 transition hover:bg-white/5 hover:text-red-400"
                :aria-label="`Delete ${task.title}`"
                @click="emit('remove', task.id)"
            >
                <AppIcon name="trash" class="h-4 w-4" />
            </button>
        </div>
    </li>
</template>
