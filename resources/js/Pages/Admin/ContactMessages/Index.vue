<script setup>
import { Head, Link, router } from '@inertiajs/vue3';
import AdminLayout from '@/Components/Admin/AdminLayout.vue';

defineOptions({ layout: AdminLayout });

const props = defineProps({
    messages: { type: Array, default: () => [] },
    pagination: { type: Object, default: () => ({}) },
    unreadFilter: { type: Boolean, default: false },
    unreadCount: { type: Number, default: 0 },
});

function destroy(message) {
    if (confirm(`Delete message from ${message.name}? This cannot be undone.`)) {
        router.delete(`/admin/contact-messages/${message.id}`);
    }
}

function markAllRead() {
    router.post('/admin/contact-messages/read-all');
}
</script>

<template>
    <Head title="Messages" />

    <div class="flex flex-wrap items-end justify-between gap-4">
        <div>
            <h1 class="mt-3 text-3xl font-bold tracking-tight">Messages</h1>
            <p class="mt-3 text-neutral-400">Inbound contact form submissions.</p>
        </div>
        <div class="flex items-center gap-3">
            <button
                v-if="unreadCount > 0"
                type="button"
                @click="markAllRead"
                class="rounded-xl border border-ink-border px-5 py-3 text-sm text-neutral-300 transition hover:border-orange-500/50 hover:text-orange-400"
            >
                Mark all read
            </button>
            <div class="flex rounded-xl border border-ink-border bg-ink-card p-1">
                <Link
                    href="/admin/contact-messages"
                    class="rounded-lg px-4 py-2 text-sm transition"
                    :class="!unreadFilter ? 'bg-orange-500 text-black' : 'text-neutral-400 hover:text-white'"
                >
                    All
                </Link>
                <Link
                    href="/admin/contact-messages?unread=1"
                    class="rounded-lg px-4 py-2 text-sm transition"
                    :class="unreadFilter ? 'bg-orange-500 text-black' : 'text-neutral-400 hover:text-white'"
                >
                    Unread <span v-if="unreadCount" class="ml-1 font-mono text-xs">{{ unreadCount }}</span>
                </Link>
            </div>
        </div>
    </div>

    <div v-if="messages.length === 0" class="mt-10 rounded-2xl border border-dashed border-ink-border px-6 py-20 text-center font-mono text-sm text-neutral-500">
        {{ unreadFilter ? 'No unread messages.' : 'No messages yet. Submissions from the contact form will appear here.' }}
    </div>

    <ul v-else class="mt-10 space-y-4">
        <li
            v-for="message in messages"
            :key="message.id"
            class="rounded-2xl border bg-ink-card p-6"
            :class="message.is_read ? 'border-ink-border' : 'border-orange-500/40'"
        >
            <div class="flex flex-wrap items-start justify-between gap-4">
                <div class="flex min-w-0 items-start gap-3">
                    <span class="mt-2 h-2 w-2 shrink-0 rounded-full" :class="message.is_read ? 'bg-ink-border' : 'bg-orange-500'" />
                    <div class="min-w-0">
                        <p class="truncate font-medium text-white">{{ message.subject }}</p>
                        <p class="mt-1 text-sm text-neutral-500">
                            {{ message.name }} · <span class="font-mono text-xs">{{ message.email }}</span> · {{ message.created_at }}
                        </p>
                    </div>
                </div>
                <div class="flex shrink-0 items-center gap-2">
                    <Link :href="message.show_url" class="rounded-lg border border-ink-border px-3 py-2 text-xs text-neutral-300 transition hover:border-orange-500/50 hover:text-orange-400">View</Link>
                    <button type="button" @click="destroy(message)" class="rounded-lg border border-ink-border px-3 py-2 text-xs text-neutral-300 transition hover:border-red-500/50 hover:text-red-400">Delete</button>
                </div>
            </div>
        </li>
    </ul>

    <!-- Pagination -->
    <nav v-if="pagination.last_page > 1" class="mt-8 flex items-center justify-center gap-3" aria-label="Message pagination">
        <Link
            v-if="pagination.current_page > 1"
            :href="`/admin/contact-messages?page=${pagination.current_page - 1}${unreadFilter ? '&unread=1' : ''}`"
            class="rounded-lg border border-ink-border px-4 py-2 text-sm text-neutral-300 transition hover:text-orange-400"
        >
            ← Prev
        </Link>
        <span class="font-mono text-xs text-neutral-500">Page {{ pagination.current_page }} of {{ pagination.last_page }}</span>
        <Link
            v-if="pagination.current_page < pagination.last_page"
            :href="`/admin/contact-messages?page=${pagination.current_page + 1}${unreadFilter ? '&unread=1' : ''}`"
            class="rounded-lg border border-ink-border px-4 py-2 text-sm text-neutral-300 transition hover:text-orange-400"
        >
            Next →
        </Link>
    </nav>
</template>
