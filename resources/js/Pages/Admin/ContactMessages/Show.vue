<script setup>
import { Head, Link, router } from '@inertiajs/vue3';
import AdminLayout from '@/Components/Admin/AdminLayout.vue';

defineOptions({ layout: AdminLayout });

const props = defineProps({
    message: { type: Object, required: true },
});

function destroy() {
    if (confirm(`Delete message from ${props.message.name}?`)) {
        router.delete(`/admin/contact-messages/${props.message.id}`);
    }
}
</script>

<template>
    <Head :title="`Message — ${message.subject}`" />

    <div class="max-w-3xl">
        <Link href="/admin/contact-messages" class="font-mono text-sm text-neutral-500 hover:text-orange-400">← back to messages</Link>

        <div class="mt-6 flex flex-wrap items-start justify-between gap-4">
            <div>
                <h1 class="text-3xl font-bold tracking-tight">{{ message.subject }}</h1>
                <p class="mt-2 text-sm text-neutral-400">
                    From <span class="font-medium text-white">{{ message.name }}</span>
                    · <span class="font-mono text-xs">{{ message.email }}</span>
                    · {{ message.created_at }}
                </p>
            </div>
            <div class="flex items-center gap-2">
                <a
                    :href="`mailto:${message.email}?subject=Re: ${message.subject}`"
                    class="rounded-xl bg-orange-500 px-4 py-2.5 text-sm font-semibold text-black transition hover:bg-orange-400"
                >
                    Reply
                </a>
                <button type="button" @click="destroy" class="rounded-xl border border-ink-border px-4 py-2.5 text-sm text-neutral-300 transition hover:border-red-500/50 hover:text-red-400">Delete</button>
            </div>
        </div>

        <div class="mt-8 rounded-2xl border border-ink-border bg-ink-card p-8">
            <p class="whitespace-pre-wrap leading-relaxed text-neutral-200">{{ message.message }}</p>
        </div>
    </div>
</template>
