import { computed, ref, watch } from 'vue';

/**
 * Todo list composable.
 *
 * Fully client-side: tasks persist to browser localStorage (no database
 * or migrations needed). Mirrors the portfolio's `use*` composable and the
 * calculator's shared-singleton pattern.
 *
 * Guarded so it also runs safely outside the browser (e.g. unit tests).
 */

const STORAGE_KEY = 'jlc.todo.v1';

function loadTasks() {
    if (typeof localStorage === 'undefined') {
        return [];
    }

    try {
        const raw = localStorage.getItem(STORAGE_KEY);
        if (!raw) {
            return [];
        }
        const parsed = JSON.parse(raw);
        if (!Array.isArray(parsed)) {
            return [];
        }
        // Sanitize: only well-formed, non-empty tasks survive.
        return parsed
            .filter((task) => task && typeof task.title === 'string' && task.title.trim() !== '')
            .map((task) => ({
                id: typeof task.id === 'string' || typeof task.id === 'number'
                    ? task.id
                    : `${Date.now()}-${Math.random().toString(36).slice(2, 8)}`,
                title: String(task.title),
                done: Boolean(task.done),
                createdAt: typeof task.createdAt === 'string' ? task.createdAt : new Date().toISOString(),
            }));
    } catch {
        return [];
    }
}

function createTodoListState() {
    const tasks = ref(loadTasks());
    const filter = ref('all'); // 'all' | 'active' | 'completed'

    // Persist every change.
    watch(tasks, (value) => {
        if (typeof localStorage !== 'undefined') {
            try {
                localStorage.setItem(STORAGE_KEY, JSON.stringify(value));
            } catch {
                // Storage full or blocked — non-fatal, the app still works.
            }
        }
    }, { deep: true });

    const filteredTasks = computed(() => {
        if (filter.value === 'active') return tasks.value.filter((task) => !task.done);
        if (filter.value === 'completed') return tasks.value.filter((task) => task.done);
        return tasks.value;
    });

    const activeCount = computed(() => tasks.value.filter((task) => !task.done).length);
    const completedCount = computed(() => tasks.value.length - activeCount.value);
    const totalCount = computed(() => tasks.value.length);

    function add(rawTitle) {
        const title = String(rawTitle ?? '').trim();
        if (!title) {
            return false;
        }
        // Skip exact duplicates so quick Enter-mashing can't double-add.
        if (tasks.value.some((task) => task.title.toLowerCase() === title.toLowerCase())) {
            return false;
        }
        tasks.value.push({
            id: `${Date.now()}-${Math.random().toString(36).slice(2, 8)}`,
            title,
            done: false,
            createdAt: new Date().toISOString(),
        });
        return true;
    }

    function toggle(id) {
        const task = tasks.value.find((task) => task.id === id);
        if (task) {
            task.done = !task.done;
        }
    }

    function remove(id) {
        tasks.value = tasks.value.filter((task) => task.id !== id);
    }

    function update(id, rawTitle) {
        const title = String(rawTitle ?? '').trim();
        if (!title) {
            return;
        }
        const task = tasks.value.find((task) => task.id === id);
        if (task) {
            task.title = title;
        }
    }

    function clearCompleted() {
        tasks.value = tasks.value.filter((task) => !task.done);
    }

    function setFilter(value) {
        filter.value = value;
    }

    return {
        tasks,
        filter,
        filteredTasks,
        activeCount,
        completedCount,
        totalCount,
        add,
        toggle,
        remove,
        update,
        clearCompleted,
        setFilter,
    };
}

/**
 * Single shared instance for this one-screen app, so every component
 * (input, filters, list) reads and writes the same tasks.
 */
const shared = createTodoListState();

export function useTodoList() {
    return shared;
}

export default useTodoList;
