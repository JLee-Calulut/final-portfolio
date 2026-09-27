<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import AdminLayout from '@/Components/Admin/AdminLayout.vue';
import Field from '@/Components/Admin/Field.vue';

defineOptions({ layout: AdminLayout });

const props = defineProps({
    education: { type: Object, default: null },
    nextSortOrder: { type: Number, default: 0 },
});

const isEdit = !!props.education;

const form = useForm({
    institution: props.education?.institution ?? '',
    degree: props.education?.degree ?? '',
    field_of_study: props.education?.field_of_study ?? '',
    location: props.education?.location ?? '',
    description: props.education?.description ?? '',
    period: props.education?.period ?? '',
    sort_order: props.education?.sort_order ?? props.nextSortOrder,
});

function submit() {
    if (isEdit) {
        form.put(`/admin/education/${props.education.id}`);
    } else {
        form.post('/admin/education');
    }
}
</script>

<template>
    <Head :title="isEdit ? 'Edit Education Entry' : 'Add Education Entry'" />

    <div class="max-w-3xl">
        <h1 class="mt-3 text-3xl font-bold tracking-tight">{{ isEdit ? 'Edit entry' : 'Add an education entry' }}</h1>
        <p class="mt-3 text-neutral-400">Entries appear as cards in the public education section.</p>

        <form class="mt-10 space-y-8 rounded-2xl border border-ink-border bg-ink-card p-8" @submit.prevent="submit">
            <div class="space-y-6">
                <Field label="Institution" :error="form.errors.institution">
                    <input v-model="form.institution" type="text" required class="w-full rounded-xl border border-ink-border bg-ink px-4 py-3 text-white placeholder-neutral-600 transition focus:border-orange-500 focus:outline-none focus:ring-2 focus:ring-orange-500/30" placeholder="University name" />
                </Field>

                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                    <Field label="Degree" :error="form.errors.degree">
                        <input v-model="form.degree" type="text" required class="w-full rounded-xl border border-ink-border bg-ink px-4 py-3 text-white placeholder-neutral-600 transition focus:border-orange-500 focus:outline-none focus:ring-2 focus:ring-orange-500/30" placeholder="Bachelor of Science" />
                    </Field>
                    <Field label="Field of study" :error="form.errors.field_of_study">
                        <input v-model="form.field_of_study" type="text" class="w-full rounded-xl border border-ink-border bg-ink px-4 py-3 text-white placeholder-neutral-600 transition focus:border-orange-500 focus:outline-none focus:ring-2 focus:ring-orange-500/30" placeholder="Computer Science" />
                    </Field>
                </div>

                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                    <Field label="Location" :error="form.errors.location">
                        <input v-model="form.location" type="text" class="w-full rounded-xl border border-ink-border bg-ink px-4 py-3 text-white placeholder-neutral-600 transition focus:border-orange-500 focus:outline-none focus:ring-2 focus:ring-orange-500/30" placeholder="Quezon City, Philippines" />
                    </Field>
                    <Field label="Period" :error="form.errors.period">
                        <input v-model="form.period" type="text" class="w-full rounded-xl border border-ink-border bg-ink px-4 py-3 font-mono text-sm text-white placeholder-neutral-600 transition focus:border-orange-500 focus:outline-none focus:ring-2 focus:ring-orange-500/30" placeholder="2019 — 2023" />
                    </Field>
                </div>

                <Field label="Description" :error="form.errors.description">
                    <textarea v-model="form.description" rows="4" class="w-full rounded-xl border border-ink-border bg-ink px-4 py-3 text-white placeholder-neutral-600 transition focus:border-orange-500 focus:outline-none focus:ring-2 focus:ring-orange-500/30" placeholder="What did you study or focus on here?" />
                </Field>

                <Field label="Sort order" :error="form.errors.sort_order">
                    <input v-model.number="form.sort_order" type="number" min="0" class="w-full rounded-xl border border-ink-border bg-ink px-4 py-3 font-mono text-sm text-white transition focus:border-orange-500 focus:outline-none focus:ring-2 focus:ring-orange-500/30" />
                </Field>
            </div>

            <div class="flex items-center gap-3 border-t border-ink-border pt-6">
                <button
                    type="submit"
                    :disabled="form.processing"
                    class="rounded-xl bg-orange-500 px-6 py-3 text-sm font-semibold text-black transition hover:bg-orange-400 disabled:opacity-60"
                >
                    {{ form.processing ? 'Saving…' : (isEdit ? 'Save changes' : 'Add entry') }}
                </button>
                <Link href="/admin/education" class="rounded-xl border border-ink-border px-6 py-3 text-sm text-neutral-300 transition hover:border-orange-500/50 hover:text-orange-400">Cancel</Link>
            </div>
        </form>
    </div>
</template>
