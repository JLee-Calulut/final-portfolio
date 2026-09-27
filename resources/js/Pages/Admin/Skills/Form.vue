<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import AdminLayout from '@/Components/Admin/AdminLayout.vue';
import Field from '@/Components/Admin/Field.vue';

defineOptions({ layout: AdminLayout });

const props = defineProps({
    skill: { type: Object, default: null },
    categories: { type: Array, default: () => [] },
    nextSortOrder: { type: Number, default: 0 },
});

const isEdit = !!props.skill;

const form = useForm({
    name: props.skill?.name ?? '',
    category: props.skill?.category ?? (props.categories[0] ?? 'frontend'),
    description: props.skill?.description ?? '',
    icon: props.skill?.icon ?? '',
    proficiency: props.skill?.proficiency ?? 70,
    sort_order: props.skill?.sort_order ?? props.nextSortOrder,
});

function submit() {
    if (isEdit) {
        form.put(`/admin/skills/${props.skill.id}`);
    } else {
        form.post('/admin/skills');
    }
}
</script>

<template>
    <Head :title="isEdit ? 'Edit Skill' : 'Add Skill'" />

    <div class="max-w-3xl">
        <h1 class="mt-3 text-3xl font-bold tracking-tight">{{ isEdit ? 'Edit skill' : 'Add a skill' }}</h1>
        <p class="mt-3 text-neutral-400">Skills appear under a category in the skills grid.</p>

        <form class="mt-10 space-y-8 rounded-2xl border border-ink-border bg-ink-card p-8" @submit.prevent="submit">
            <div class="space-y-6">
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                    <Field label="Name" :error="form.errors.name">
                        <input v-model="form.name" type="text" required class="w-full rounded-xl border border-ink-border bg-ink px-4 py-3 text-white placeholder-neutral-600 transition focus:border-orange-500 focus:outline-none focus:ring-2 focus:ring-orange-500/30" placeholder="Vue.js" />
                    </Field>
                    <Field label="Category" :error="form.errors.category">
                        <select v-model="form.category" class="w-full rounded-xl border border-ink-border bg-ink px-4 py-3 text-white transition focus:border-orange-500 focus:outline-none focus:ring-2 focus:ring-orange-500/30">
                            <option v-for="category in categories" :key="category" :value="category">{{ category }}</option>
                        </select>
                    </Field>
                </div>

                <Field label="Icon" hint="Optional icon identifier used by the frontend, e.g. vue, laravel, git." :error="form.errors.icon">
                    <input v-model="form.icon" type="text" class="w-full rounded-xl border border-ink-border bg-ink px-4 py-3 font-mono text-sm text-white placeholder-neutral-600 transition focus:border-orange-500 focus:outline-none focus:ring-2 focus:ring-orange-500/30" placeholder="vue" />
                </Field>

                <Field label="Short description" :error="form.errors.description">
                    <textarea v-model="form.description" rows="2" class="w-full rounded-xl border border-ink-border bg-ink px-4 py-3 text-white placeholder-neutral-600 transition focus:border-orange-500 focus:outline-none focus:ring-2 focus:ring-orange-500/30" placeholder="Reactive interfaces with the Composition API." />
                </Field>

                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                    <Field label="Proficiency (0–100)" :error="form.errors.proficiency">
                        <div class="flex items-center gap-4">
                            <input v-model.number="form.proficiency" type="range" min="0" max="100" step="5" class="w-full accent-orange-500" />
                            <span class="w-12 text-right font-mono text-sm text-orange-400">{{ form.proficiency }}</span>
                        </div>
                    </Field>
                    <Field label="Sort order" :error="form.errors.sort_order">
                        <input v-model.number="form.sort_order" type="number" min="0" class="w-full rounded-xl border border-ink-border bg-ink px-4 py-3 font-mono text-sm text-white transition focus:border-orange-500 focus:outline-none focus:ring-2 focus:ring-orange-500/30" />
                    </Field>
                </div>
            </div>

            <div class="flex items-center gap-3 border-t border-ink-border pt-6">
                <button
                    type="submit"
                    :disabled="form.processing"
                    class="rounded-xl bg-orange-500 px-6 py-3 text-sm font-semibold text-black transition hover:bg-orange-400 disabled:opacity-60"
                >
                    {{ form.processing ? 'Saving…' : (isEdit ? 'Save changes' : 'Add skill') }}
                </button>
                <Link href="/admin/skills" class="rounded-xl border border-ink-border px-6 py-3 text-sm text-neutral-300 transition hover:border-orange-500/50 hover:text-orange-400">Cancel</Link>
            </div>
        </form>
    </div>
</template>
