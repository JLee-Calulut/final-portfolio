<script setup>
import { Head, Link, router } from '@inertiajs/vue3';
import AdminLayout from '@/Components/Admin/AdminLayout.vue';

defineOptions({ layout: AdminLayout });

defineProps({
    skills: { type: Array, default: () => [] },
});

const categoryLabels = {
    frontend: 'Frontend',
    backend: 'Backend',
    database: 'Database',
    tools: 'Tools',
};

function destroy(skill) {
    if (confirm(`Remove skill “${skill.name}”?`)) {
        router.delete(`/admin/skills/${skill.id}`);
    }
}
</script>

<template>
    <Head title="Skills" />

    <div class="flex flex-wrap items-end justify-between gap-4">
        <div>
            <h1 class="mt-3 text-3xl font-bold tracking-tight">Skills</h1>
            <p class="mt-3 text-neutral-400">{{ skills.length }} skill{{ skills.length === 1 ? '' : 's' }} grouped by category.</p>
        </div>
        <Link href="/admin/skills/create" class="rounded-xl bg-orange-500 px-5 py-3 text-sm font-semibold text-black transition hover:bg-orange-400">
            Add a skill
        </Link>
    </div>

    <div class="mt-10 overflow-hidden rounded-2xl border border-ink-border bg-ink-card">
        <div class="overflow-x-auto">
            <table class="w-full min-w-[640px] text-left text-sm">
                <thead class="border-b border-ink-border bg-ink-soft">
                    <tr>
                        <th class="px-6 py-4 font-mono text-xs font-medium uppercase tracking-wide text-neutral-500">Name</th>
                        <th class="px-6 py-4 font-mono text-xs font-medium uppercase tracking-wide text-neutral-500">Category</th>
                        <th class="px-6 py-4 font-mono text-xs font-medium uppercase tracking-wide text-neutral-500">Proficiency</th>
                        <th class="px-6 py-4 font-mono text-xs font-medium uppercase tracking-wide text-neutral-500">Order</th>
                        <th class="px-6 py-4 text-right font-mono text-xs font-medium uppercase tracking-wide text-neutral-500">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-ink-border">
                    <tr v-for="skill in skills" :key="skill.id" class="transition hover:bg-white/[0.02]">
                        <td class="px-6 py-4 font-medium text-white">{{ skill.name }}</td>
                        <td class="px-6 py-4">
                            <span class="rounded-md bg-ink px-2.5 py-1 font-mono text-xs text-neutral-400">{{ categoryLabels[skill.category] ?? skill.category }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="h-1.5 w-28 overflow-hidden rounded-full bg-ink">
                                    <div
                                        class="h-full rounded-full bg-orange-500"
                                        :style="{ width: `${skill.proficiency ?? 0}%` }"
                                    />
                                </div>
                                <span class="font-mono text-xs text-neutral-400">{{ skill.proficiency ?? '—' }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 font-mono text-xs text-neutral-400">{{ skill.sort_order }}</td>
                        <td class="px-6 py-4">
                            <div class="flex justify-end gap-2">
                                <Link :href="skill.edit_url" class="rounded-lg border border-ink-border px-3 py-2 text-xs text-neutral-300 transition hover:border-orange-500/50 hover:text-orange-400">Edit</Link>
                                <button type="button" @click="destroy(skill)" class="rounded-lg border border-ink-border px-3 py-2 text-xs text-neutral-300 transition hover:border-red-500/50 hover:text-red-400">Delete</button>
                            </div>
                        </td>
                    </tr>
                    <tr v-if="skills.length === 0">
                        <td colspan="5" class="px-6 py-16 text-center font-mono text-sm text-neutral-500">No skills yet. Click “Add a skill” to get started.</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>
