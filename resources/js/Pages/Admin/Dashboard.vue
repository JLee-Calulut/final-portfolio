<script setup>
import { Head, Link } from '@inertiajs/vue3';
import AdminLayout from '@/Components/Admin/AdminLayout.vue';

// Stat cards: each entry reads its count straight from the `stats` prop.
defineOptions({ layout: AdminLayout });

defineProps({
    stats: { type: Object, required: true },
    recentMessages: { type: Array, default: () => [] },
});

const cards = [
    { label: 'Projects', key: 'projects', href: '/admin/projects' },
    { label: 'Skills', key: 'skills', href: '/admin/skills' },
    { label: 'Services', key: 'services', href: '/admin/services' },
    { label: 'Timeline entries', key: 'timeline', href: '/admin/timeline-items' },
    { label: 'Education', key: 'education', href: '/admin/education' },
    { label: 'Messages', key: 'messages', href: '/admin/contact-messages', sub: 'unreadMessages' },
];
</script>

<template>
    <Head title="Dashboard" />

    <div class="space-y-10">
        <!-- Heading -->
        <div>
            <h1 class="mt-3 text-3xl font-bold tracking-tight sm:text-4xl">Dashboard</h1>
            <p class="mt-3 text-neutral-400">Everything on your portfolio, in one place.</p>
        </div>

        <!-- Stat cards -->
        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6">
            <Link
                v-for="card in cards"
                :key="card.label"
                :href="card.href"
                class="group flex flex-col justify-between gap-8 rounded-2xl border border-ink-border bg-ink-card p-6 transition hover:-translate-y-1 hover:border-orange-500/50"
            >
                <span class="text-sm font-medium text-neutral-400">{{ card.label }}</span>
                <div>
                    <span class="block text-4xl font-bold text-white">{{ stats[card.key] ?? 0 }}</span>
                    <span v-if="card.sub" class="mt-1 block font-mono text-xs" :class="stats[card.sub] > 0 ? 'text-orange-400' : 'text-neutral-600'">
                        {{ stats[card.sub] }} unread
                    </span>
                </div>
            </Link>
        </div>

        <!-- Quick action + recent messages -->
        <div class="grid grid-cols-1 gap-6 lg:grid-cols-5">
            <!-- Quick actions -->
            <div class="rounded-2xl border border-ink-border bg-ink-card p-6 lg:col-span-2">
                <h2 class="text-lg font-semibold">Quick actions</h2>
                <p class="mt-1 text-sm text-neutral-500">Add or update content fast.</p>
                <div class="mt-6 space-y-3">
                    <Link href="/admin/projects/create" class="flex items-center justify-between rounded-xl border border-ink-border bg-ink px-4 py-3 text-sm text-neutral-200 transition hover:border-orange-500/50 hover:text-orange-400">
                        New project <span class="font-mono text-orange-500">+</span>
                    </Link>
                    <Link href="/admin/skills/create" class="flex items-center justify-between rounded-xl border border-ink-border bg-ink px-4 py-3 text-sm text-neutral-200 transition hover:border-orange-500/50 hover:text-orange-400">
                        Add a skill <span class="font-mono text-orange-500">+</span>
                    </Link>
                    <Link href="/admin/services/create" class="flex items-center justify-between rounded-xl border border-ink-border bg-ink px-4 py-3 text-sm text-neutral-200 transition hover:border-orange-500/50 hover:text-orange-400">
                        Add a service <span class="font-mono text-orange-500">+</span>
                    </Link>
                    <Link href="/admin/timeline-items/create" class="flex items-center justify-between rounded-xl border border-ink-border bg-ink px-4 py-3 text-sm text-neutral-200 transition hover:border-orange-500/50 hover:text-orange-400">
                        Add a timeline entry <span class="font-mono text-orange-500">+</span>
                    </Link>
                    <Link href="/admin/education/create" class="flex items-center justify-between rounded-xl border border-ink-border bg-ink px-4 py-3 text-sm text-neutral-200 transition hover:border-orange-500/50 hover:text-orange-400">
                        Add an education entry <span class="font-mono text-orange-500">+</span>
                    </Link>
                </div>
            </div>

            <!-- Recent messages -->
            <div class="rounded-2xl border border-ink-border bg-ink-card p-6 lg:col-span-3">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-lg font-semibold">Recent messages</h2>
                        <p class="mt-1 text-sm text-neutral-500">Latest inbound contact form submissions.</p>
                    </div>
                    <Link href="/admin/contact-messages" class="font-mono text-sm text-orange-500 hover:text-orange-400">view all →</Link>
                </div>

                <p v-if="recentMessages.length === 0" class="mt-8 rounded-xl border border-dashed border-ink-border px-4 py-10 text-center font-mono text-sm text-neutral-500">
                    No messages yet.
                </p>

                <ul v-else class="mt-6 divide-y divide-ink-border">
                    <li v-for="message in recentMessages" :key="message.id">
                        <Link :href="message.show_url" class="flex items-start gap-4 py-4 transition hover:opacity-80">
                            <span class="mt-1.5 h-2 w-2 shrink-0 rounded-full" :class="message.is_read ? 'bg-ink-border' : 'bg-orange-500'" />
                            <div class="min-w-0 flex-1">
                                <p class="truncate text-sm font-medium">{{ message.subject }}</p>
                                <p class="truncate text-sm text-neutral-500">{{ message.name }} · {{ message.created_at }}</p>
                            </div>
                        </Link>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</template>
