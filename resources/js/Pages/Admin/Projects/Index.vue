<script setup>
import { Head, Link, router } from '@inertiajs/vue3';
import AdminLayout from '@/Components/Admin/AdminLayout.vue';
import AppIcon from '@/Components/UI/AppIcon.vue';

defineOptions({ layout: AdminLayout });

defineProps({
    projects: { type: Array, default: () => [] },
});

function destroy(project) {
    if (confirm(`Delete “${project.title}”? This cannot be undone.`)) {
        router.delete(`/admin/projects/${project.id}`);
    }
}
</script>

<template>
    <Head title="Projects" />

    <div class="flex flex-wrap items-end justify-between gap-4">
        <div>
            <h1 class="mt-3 text-3xl font-bold tracking-tight">Projects</h1>
            <p class="mt-3 text-neutral-400">{{ projects.length }} project{{ projects.length === 1 ? '' : 's' }} on your portfolio.</p>
        </div>
        <Link href="/admin/projects/create" class="rounded-xl bg-orange-500 px-5 py-3 text-sm font-semibold text-black transition hover:bg-orange-400">
            New project
        </Link>
    </div>

    <div class="mt-10 overflow-hidden rounded-2xl border border-ink-border bg-ink-card">
        <div class="overflow-x-auto">
            <table class="w-full min-w-[640px] text-left text-sm">
                <thead class="border-b border-ink-border bg-ink-soft">
                    <tr>
                        <th class="px-6 py-4 font-mono text-xs font-medium uppercase tracking-wide text-neutral-500">Title</th>
                        <th class="px-6 py-4 font-mono text-xs font-medium uppercase tracking-wide text-neutral-500">Slug</th>
                        <th class="px-6 py-4 font-mono text-xs font-medium uppercase tracking-wide text-neutral-500">Status</th>
                        <th class="px-6 py-4 font-mono text-xs font-medium uppercase tracking-wide text-neutral-500">Order</th>
                        <th class="px-6 py-4 text-right font-mono text-xs font-medium uppercase tracking-wide text-neutral-500">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-ink-border">
                    <tr v-for="project in projects" :key="project.id" class="transition hover:bg-white/[0.02]">
                        <td class="px-6 py-4">
                            <p class="font-medium text-white">{{ project.title }}</p>
                            <p v-if="project.tech_stack.length" class="mt-1 flex flex-wrap gap-1">
                                <span v-for="tech in project.tech_stack.slice(0, 3)" :key="tech" class="rounded-md bg-ink px-2 py-0.5 font-mono text-xs text-neutral-400">{{ tech }}</span>
                                <span v-if="project.tech_stack.length > 3" class="font-mono text-xs text-neutral-600">+{{ project.tech_stack.length - 3 }}</span>
                            </p>
                        </td>
                        <td class="px-6 py-4 font-mono text-xs text-neutral-400">/{{ project.slug }}</td>
                        <td class="px-6 py-4">
                            <span
                                class="inline-flex items-center gap-2 rounded-md px-2.5 py-1 text-xs font-medium"
                                :class="project.is_published ? 'bg-green-500/10 text-green-300' : 'bg-neutral-500/10 text-neutral-400'"
                            >
                                <span class="h-1.5 w-1.5 rounded-full" :class="project.is_published ? 'bg-green-400' : 'bg-neutral-500'" />
                                {{ project.is_published ? 'Published' : 'Draft' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 font-mono text-xs text-neutral-400">{{ project.sort_order }}</td>
                        <td class="px-6 py-4">
                            <div class="flex justify-end gap-2">
                                <Link :href="project.edit_url" class="rounded-lg border border-ink-border px-3 py-2 text-xs text-neutral-300 transition hover:border-orange-500/50 hover:text-orange-400">
                                    Edit
                                </Link>
                                <button type="button" @click="destroy(project)" class="rounded-lg border border-ink-border px-3 py-2 text-xs text-neutral-300 transition hover:border-red-500/50 hover:text-red-400">
                                    Delete
                                </button>
                            </div>
                        </td>
                    </tr>
                    <tr v-if="projects.length === 0">
                        <td colspan="5" class="px-6 py-16 text-center font-mono text-sm text-neutral-500">No projects yet. Click “New project” to get started.</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>
