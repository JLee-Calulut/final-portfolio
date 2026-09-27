<script setup>
import { Head, Link, router } from '@inertiajs/vue3';
import AdminLayout from '@/Components/Admin/AdminLayout.vue';

defineOptions({ layout: AdminLayout });

defineProps({
    timelineItems: { type: Array, default: () => [] },
});

function destroy(item) {
    if (confirm(`Delete timeline entry “${item.title}”?`)) {
        router.delete(`/admin/timeline-items/${item.id}`);
    }
}
</script>

<template>
    <Head title="Timeline" />

    <div class="flex flex-wrap items-end justify-between gap-4">
        <div>
            <h1 class="mt-3 text-3xl font-bold tracking-tight">Timeline</h1>
            <p class="mt-3 text-neutral-400">{{ timelineItems.length }} entry{{ timelineItems.length === 1 ? '' : 'ies' }} in your experience timeline.</p>
        </div>
        <Link href="/admin/timeline-items/create" class="rounded-xl bg-orange-500 px-5 py-3 text-sm font-semibold text-black transition hover:bg-orange-400">
            Add entry
        </Link>
    </div>

    <div class="mt-10 overflow-hidden rounded-2xl border border-ink-border bg-ink-card">
        <div class="overflow-x-auto">
            <table class="w-full min-w-[640px] text-left text-sm">
                <thead class="border-b border-ink-border bg-ink-soft">
                    <tr>
                        <th class="px-6 py-4 font-mono text-xs font-medium uppercase tracking-wide text-neutral-500">Title</th>
                        <th class="px-6 py-4 font-mono text-xs font-medium uppercase tracking-wide text-neutral-500">Subtitle</th>
                        <th class="px-6 py-4 font-mono text-xs font-medium uppercase tracking-wide text-neutral-500">Period</th>
                        <th class="px-6 py-4 font-mono text-xs font-medium uppercase tracking-wide text-neutral-500">Order</th>
                        <th class="px-6 py-4 text-right font-mono text-xs font-medium uppercase tracking-wide text-neutral-500">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-ink-border">
                    <tr v-for="item in timelineItems" :key="item.id" class="transition hover:bg-white/[0.02]">
                        <td class="px-6 py-4 font-medium text-white">{{ item.title }}</td>
                        <td class="px-6 py-4 text-neutral-400">{{ item.subtitle || '—' }}</td>
                        <td class="px-6 py-4 font-mono text-xs text-neutral-400">{{ item.period || '—' }}</td>
                        <td class="px-6 py-4 font-mono text-xs text-neutral-400">{{ item.sort_order }}</td>
                        <td class="px-6 py-4">
                            <div class="flex justify-end gap-2">
                                <Link :href="item.edit_url" class="rounded-lg border border-ink-border px-3 py-2 text-xs text-neutral-300 transition hover:border-orange-500/50 hover:text-orange-400">Edit</Link>
                                <button type="button" @click="destroy(item)" class="rounded-lg border border-ink-border px-3 py-2 text-xs text-neutral-300 transition hover:border-red-500/50 hover:text-red-400">Delete</button>
                            </div>
                        </td>
                    </tr>
                    <tr v-if="timelineItems.length === 0">
                        <td colspan="5" class="px-6 py-16 text-center font-mono text-sm text-neutral-500">No timeline entries yet. Click “Add entry” to get started.</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>
