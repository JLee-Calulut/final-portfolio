<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import AdminLayout from '@/Components/Admin/AdminLayout.vue';
import Field from '@/Components/Admin/Field.vue';
import { ref } from 'vue';

defineOptions({ layout: AdminLayout });

const props = defineProps({
    project: { type: Object, default: null },
    nextSortOrder: { type: Number, default: 0 },
});

const isEdit = !!props.project;
const techDraft = ref('');

const form = useForm({
    title: props.project?.title ?? '',
    slug: props.project?.slug ?? '',
    description: props.project?.description ?? '',
    thumbnail: props.project?.thumbnail ?? '',
    tech_stack: props.project?.tech_stack ?? [],
    github_url: props.project?.github_url ?? '',
    demo_url: props.project?.demo_url ?? '',
    sort_order: props.project?.sort_order ?? props.nextSortOrder,
    is_published: props.project?.is_published ?? true,
});

function addTech() {
    const value = techDraft.value.trim();
    if (value && !form.tech_stack.includes(value)) {
        form.tech_stack.push(value);
    }
    techDraft.value = '';
}

function removeTech(index) {
    form.tech_stack.splice(index, 1);
}

function submit() {
    if (isEdit) {
        form.put(`/admin/projects/${props.project.id}`);
    } else {
        form.post('/admin/projects');
    }
}
</script>

<template>
    <Head :title="isEdit ? 'Edit Project' : 'New Project'" />

    <div class="max-w-3xl">
        <h1 class="mt-3 text-3xl font-bold tracking-tight">{{ isEdit ? 'Edit project' : 'New project' }}</h1>
        <p class="mt-3 text-neutral-400">Projects show up in the portfolio grid, ordered by the sort value.</p>

        <form class="mt-10 space-y-8 rounded-2xl border border-ink-border bg-ink-card p-8" @submit.prevent="submit">
            <div class="space-y-6">
                <Field label="Title" :error="form.errors.title">
                    <input v-model="form.title" type="text" required class="w-full rounded-xl border border-ink-border bg-ink px-4 py-3 text-white placeholder-neutral-600 transition focus:border-orange-500 focus:outline-none focus:ring-2 focus:ring-orange-500/30" placeholder="Task Management App" />
                </Field>

                <Field label="Slug" hint="Leave blank to auto-generate from the title." :error="form.errors.slug">
                    <input v-model="form.slug" type="text" class="w-full rounded-xl border border-ink-border bg-ink px-4 py-3 font-mono text-sm text-white placeholder-neutral-600 transition focus:border-orange-500 focus:outline-none focus:ring-2 focus:ring-orange-500/30" placeholder="task-management-app" />
                </Field>

                <Field label="Description" :error="form.errors.description">
                    <textarea v-model="form.description" rows="4" required class="w-full rounded-xl border border-ink-border bg-ink px-4 py-3 text-white placeholder-neutral-600 transition focus:border-orange-500 focus:outline-none focus:ring-2 focus:ring-orange-500/30" placeholder="What does this project do?" />
                </Field>

                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                    <Field label="Thumbnail URL" :error="form.errors.thumbnail">
                        <input v-model="form.thumbnail" type="text" class="w-full rounded-xl border border-ink-border bg-ink px-4 py-3 font-mono text-sm text-white placeholder-neutral-600 transition focus:border-orange-500 focus:outline-none focus:ring-2 focus:ring-orange-500/30" placeholder="https://… or /images/…" />
                    </Field>
                    <Field label="Sort order" :error="form.errors.sort_order">
                        <input v-model.number="form.sort_order" type="number" min="0" class="w-full rounded-xl border border-ink-border bg-ink px-4 py-3 font-mono text-sm text-white placeholder-neutral-600 transition focus:border-orange-500 focus:outline-none focus:ring-2 focus:ring-orange-500/30" />
                    </Field>
                </div>

                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                    <Field label="GitHub URL" :error="form.errors.github_url">
                        <input v-model="form.github_url" type="url" class="w-full rounded-xl border border-ink-border bg-ink px-4 py-3 font-mono text-sm text-white placeholder-neutral-600 transition focus:border-orange-500 focus:outline-none focus:ring-2 focus:ring-orange-500/30" placeholder="https://github.com/…" />
                    </Field>
                    <Field label="Live demo URL" :error="form.errors.demo_url">
                        <input v-model="form.demo_url" type="text" class="w-full rounded-xl border border-ink-border bg-ink px-4 py-3 font-mono text-sm text-white placeholder-neutral-600 transition focus:border-orange-500 focus:outline-none focus:ring-2 focus:ring-orange-500/30" placeholder="https://… or /calculator" />
                    </Field>
                </div>

                <Field label="Tech stack" :error="form.errors.tech_stack">
                    <div class="flex gap-2">
                        <input v-model="techDraft" type="text" @keydown.enter.prevent="addTech" class="flex-1 rounded-xl border border-ink-border bg-ink px-4 py-3 text-white placeholder-neutral-600 transition focus:border-orange-500 focus:outline-none focus:ring-2 focus:ring-orange-500/30" placeholder="Vue.js — press Enter to add" />
                        <button type="button" @click="addTech" class="rounded-xl border border-ink-border px-4 py-3 text-sm text-neutral-300 transition hover:border-orange-500/50 hover:text-orange-400">Add</button>
                    </div>
                    <div class="mt-3 flex flex-wrap gap-2">
                        <span v-for="(tech, index) in form.tech_stack" :key="tech" class="inline-flex items-center gap-2 rounded-lg bg-ink px-3 py-1.5 font-mono text-xs text-neutral-300">
                            {{ tech }}
                            <button type="button" @click="removeTech(index)" class="text-neutral-600 transition hover:text-red-400" aria-label="Remove {{ tech }}">✕</button>
                        </span>
                    </div>
                </Field>

                <label class="flex cursor-pointer items-center gap-3 text-sm text-neutral-300">
                    <input v-model="form.is_published" type="checkbox" class="h-4 w-4 rounded border-ink-border bg-ink text-orange-500 focus:ring-orange-500" />
                    Published — visible on the portfolio
                </label>
            </div>

            <div class="flex items-center gap-3 border-t border-ink-border pt-6">
                <button
                    type="submit"
                    :disabled="form.processing"
                    class="rounded-xl bg-orange-500 px-6 py-3 text-sm font-semibold text-black transition hover:bg-orange-400 disabled:opacity-60"
                >
                    {{ form.processing ? 'Saving…' : (isEdit ? 'Save changes' : 'Create project') }}
                </button>
                <Link href="/admin/projects" class="rounded-xl border border-ink-border px-6 py-3 text-sm text-neutral-300 transition hover:border-orange-500/50 hover:text-orange-400">Cancel</Link>
            </div>
        </form>
    </div>
</template>
