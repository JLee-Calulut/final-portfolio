<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import AdminLayout from '@/Components/Admin/AdminLayout.vue';
import Field from '@/Components/Admin/Field.vue';

defineOptions({ layout: AdminLayout });

const props = defineProps({
    service: { type: Object, default: null },
    nextSortOrder: { type: Number, default: 0 },
});

const isEdit = !!props.service;

const form = useForm({
    title: props.service?.title ?? '',
    description: props.service?.description ?? '',
    icon: props.service?.icon ?? '',
    sort_order: props.service?.sort_order ?? props.nextSortOrder,
});

function submit() {
    if (isEdit) {
        form.put(`/admin/services/${props.service.id}`);
    } else {
        form.post('/admin/services');
    }
}
</script>

<template>
    <Head :title="isEdit ? 'Edit Service' : 'Add Service'" />

    <div class="max-w-3xl">
        <h1 class="mt-3 text-3xl font-bold tracking-tight">{{ isEdit ? 'Edit service' : 'Add a service' }}</h1>
        <p class="mt-3 text-neutral-400">Services are the offerings shown in the services section.</p>

        <form class="mt-10 space-y-8 rounded-2xl border border-ink-border bg-ink-card p-8" @submit.prevent="submit">
            <div class="space-y-6">
                <Field label="Title" :error="form.errors.title">
                    <input v-model="form.title" type="text" required class="w-full rounded-xl border border-ink-border bg-ink px-4 py-3 text-white placeholder-neutral-600 transition focus:border-orange-500 focus:outline-none focus:ring-2 focus:ring-orange-500/30" placeholder="Full-Stack Development" />
                </Field>

                <Field label="Description" :error="form.errors.description">
                    <textarea v-model="form.description" rows="3" required class="w-full rounded-xl border border-ink-border bg-ink px-4 py-3 text-white placeholder-neutral-600 transition focus:border-orange-500 focus:outline-none focus:ring-2 focus:ring-orange-500/30" placeholder="A short description of this service." />
                </Field>

                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                    <Field label="Icon" hint="Icon identifier used by the frontend, e.g. monitor, server, layers." :error="form.errors.icon">
                        <input v-model="form.icon" type="text" class="w-full rounded-xl border border-ink-border bg-ink px-4 py-3 font-mono text-sm text-white placeholder-neutral-600 transition focus:border-orange-500 focus:outline-none focus:ring-2 focus:ring-orange-500/30" placeholder="layers" />
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
                    {{ form.processing ? 'Saving…' : (isEdit ? 'Save changes' : 'Add service') }}
                </button>
                <Link href="/admin/services" class="rounded-xl border border-ink-border px-6 py-3 text-sm text-neutral-300 transition hover:border-orange-500/50 hover:text-orange-400">Cancel</Link>
            </div>
        </form>
    </div>
</template>
