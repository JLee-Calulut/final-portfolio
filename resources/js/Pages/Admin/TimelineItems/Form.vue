<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import AdminLayout from '@/Components/Admin/AdminLayout.vue';
import Field from '@/Components/Admin/Field.vue';

defineOptions({ layout: AdminLayout });

const props = defineProps({
    timelineItem: { type: Object, default: null },
    nextSortOrder: { type: Number, default: 0 },
});

const isEdit = !!props.timelineItem;

const form = useForm({
    title: props.timelineItem?.title ?? '',
    subtitle: props.timelineItem?.subtitle ?? '',
    description: props.timelineItem?.description ?? '',
    period: props.timelineItem?.period ?? '',
    sort_order: props.timelineItem?.sort_order ?? props.nextSortOrder,
});

function submit() {
    if (isEdit) {
        form.put(`/admin/timeline-items/${props.timelineItem.id}`);
    } else {
        form.post('/admin/timeline-items');
    }
}
</script>

<template>
    <Head :title="isEdit ? 'Edit Timeline Entry' : 'Add Timeline Entry'" />

    <div class="max-w-3xl">
        <h1 class="mt-3 text-3xl font-bold tracking-tight">{{ isEdit ? 'Edit entry' : 'Add a timeline entry' }}</h1>
        <p class="mt-3 text-neutral-400">Entries trace your development journey in the experience section.</p>

        <form class="mt-10 space-y-8 rounded-2xl border border-ink-border bg-ink-card p-8" @submit.prevent="submit">
            <div class="space-y-6">
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                    <Field label="Title" :error="form.errors.title">
                        <input v-model="form.title" type="text" required class="w-full rounded-xl border border-ink-border bg-ink px-4 py-3 text-white placeholder-neutral-600 transition focus:border-orange-500 focus:outline-none focus:ring-2 focus:ring-orange-500/30" placeholder="Full-Stack Projects" />
                    </Field>
                    <Field label="Subtitle" :error="form.errors.subtitle">
                        <input v-model="form.subtitle" type="text" class="w-full rounded-xl border border-ink-border bg-ink px-4 py-3 text-white placeholder-neutral-600 transition focus:border-orange-500 focus:outline-none focus:ring-2 focus:ring-orange-500/30" placeholder="Integration" />
                    </Field>
                </div>

                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                    <Field label="Period" :error="form.errors.period">
                        <input v-model="form.period" type="text" class="w-full rounded-xl border border-ink-border bg-ink px-4 py-3 font-mono text-sm text-white placeholder-neutral-600 transition focus:border-orange-500 focus:outline-none focus:ring-2 focus:ring-orange-500/30" placeholder="2024 — Present" />
                    </Field>
                    <Field label="Sort order" :error="form.errors.sort_order">
                        <input v-model.number="form.sort_order" type="number" min="0" class="w-full rounded-xl border border-ink-border bg-ink px-4 py-3 font-mono text-sm text-white transition focus:border-orange-500 focus:outline-none focus:ring-2 focus:ring-orange-500/30" />
                    </Field>
                </div>

                <Field label="Description" :error="form.errors.description">
                    <textarea v-model="form.description" rows="4" class="w-full rounded-xl border border-ink-border bg-ink px-4 py-3 text-white placeholder-neutral-600 transition focus:border-orange-500 focus:outline-none focus:ring-2 focus:ring-orange-500/30" placeholder="What happened at this stage?" />
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
                <Link href="/admin/timeline-items" class="rounded-xl border border-ink-border px-6 py-3 text-sm text-neutral-300 transition hover:border-orange-500/50 hover:text-orange-400">Cancel</Link>
            </div>
        </form>
    </div>
</template>
