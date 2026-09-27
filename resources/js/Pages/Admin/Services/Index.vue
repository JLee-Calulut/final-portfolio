<script setup>
import { Head, Link, router } from '@inertiajs/vue3';
import AdminLayout from '@/Components/Admin/AdminLayout.vue';
import AppIcon from '@/Components/UI/AppIcon.vue';

defineOptions({ layout: AdminLayout });

defineProps({
    services: { type: Array, default: () => [] },
});

function destroy(service) {
    if (confirm(`Delete service “${service.title}”?`)) {
        router.delete(`/admin/services/${service.id}`);
    }
}
</script>

<template>
    <Head title="Services" />

    <div class="flex flex-wrap items-end justify-between gap-4">
        <div>
            <h1 class="mt-3 text-3xl font-bold tracking-tight">Services</h1>
            <p class="mt-3 text-neutral-400">{{ services.length }} service{{ services.length === 1 ? '' : 's' }} shown in the services grid.</p>
        </div>
        <Link href="/admin/services/create" class="rounded-xl bg-orange-500 px-5 py-3 text-sm font-semibold text-black transition hover:bg-orange-400">
            Add a service
        </Link>
    </div>

    <div class="mt-10 overflow-hidden rounded-2xl border border-ink-border bg-ink-card">
        <div class="overflow-x-auto">
            <table class="w-full min-w-[640px] text-left text-sm">
                <thead class="border-b border-ink-border bg-ink-soft">
                    <tr>
                        <th class="px-6 py-4 font-mono text-xs font-medium uppercase tracking-wide text-neutral-500">Title</th>
                        <th class="px-6 py-4 font-mono text-xs font-medium uppercase tracking-wide text-neutral-500">Icon</th>
                        <th class="px-6 py-4 font-mono text-xs font-medium uppercase tracking-wide text-neutral-500">Order</th>
                        <th class="px-6 py-4 text-right font-mono text-xs font-medium uppercase tracking-wide text-neutral-500">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-ink-border">
                    <tr v-for="service in services" :key="service.id" class="transition hover:bg-white/[0.02]">
                        <td class="px-6 py-4 font-medium text-white">{{ service.title }}</td>
                        <td class="px-6 py-4 font-mono text-xs text-neutral-400">{{ service.icon || '—' }}</td>
                        <td class="px-6 py-4 font-mono text-xs text-neutral-400">{{ service.sort_order }}</td>
                        <td class="px-6 py-4">
                            <div class="flex justify-end gap-2">
                                <Link :href="service.edit_url" class="rounded-lg border border-ink-border px-3 py-2 text-xs text-neutral-300 transition hover:border-orange-500/50 hover:text-orange-400">Edit</Link>
                                <button type="button" @click="destroy(service)" class="rounded-lg border border-ink-border px-3 py-2 text-xs text-neutral-300 transition hover:border-red-500/50 hover:text-red-400">Delete</button>
                            </div>
                        </td>
                    </tr>
                    <tr v-if="services.length === 0">
                        <td colspan="4" class="px-6 py-16 text-center font-mono text-sm text-neutral-500">No services yet. Click “Add a service” to get started.</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>
