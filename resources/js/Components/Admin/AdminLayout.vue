<script setup>
import { Link, usePage, router } from '@inertiajs/vue3';
import { computed } from 'vue';
import AppIcon from '@/Components/UI/AppIcon.vue';

const page = usePage();

const admin = computed(() => page.props.auth?.admin ?? null);
const flash = computed(() => page.props.flash ?? {});

const nav = [
    {
        label: 'Dashboard',
        href: '/admin',
        active: '/admin' === page.props.currentRoute || page.url === '/admin',
        icon: 'home',
    },
    {
        label: 'Projects',
        href: '/admin/projects',
        active: page.url.startsWith('/admin/projects'),
        icon: 'folder',
    },
    {
        label: 'Skills',
        href: '/admin/skills',
        active: page.url.startsWith('/admin/skills'),
        icon: 'code',
    },
    {
        label: 'Services',
        href: '/admin/services',
        active: page.url.startsWith('/admin/services'),
        icon: 'briefcase',
    },
    {
        label: 'Timeline',
        href: '/admin/timeline-items',
        active: page.url.startsWith('/admin/timeline-items'),
        icon: 'clock',
    },
    {
        label: 'Education',
        href: '/admin/education',
        active: page.url.startsWith('/admin/education'),
        icon: 'book',
    },
    {
        label: 'Messages',
        href: '/admin/contact-messages',
        active: page.url.startsWith('/admin/contact-messages'),
        icon: 'mail',
        badge: page.props.unreadCount ?? null,
    },
];

function logout() {
    router.post('/admin/logout');
}
</script>

<template>
    <div class="min-h-screen bg-ink text-white">
        <!-- Top bar (mobile) -->
        <header class="sticky top-0 z-40 border-b border-ink-border bg-ink-soft/95 backdrop-blur lg:hidden">
            <div class="flex items-center justify-between px-6 py-4">
                <div class="flex items-center gap-3">
                    <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-orange-500 font-mono text-xs font-bold text-black">JC</span>
                    <span class="text-sm font-semibold">Admin</span>
                </div>
                <button type="button" class="rounded-lg border border-ink-border bg-ink-card px-3 py-2 text-sm text-neutral-300" @click="logout">Logout</button>
            </div>
            <nav class="flex gap-1 overflow-x-auto px-4 pb-3" aria-label="Admin sections">
                <Link
                    v-for="item in nav"
                    :key="item.label"
                    :href="item.href"
                    class="whitespace-nowrap rounded-lg px-3 py-2 text-sm"
                    :class="item.active ? 'bg-orange-500/10 text-orange-400' : 'text-neutral-400'"
                >
                    {{ item.label }}
                </Link>
            </nav>
        </header>

        <!-- Sidebar (desktop) -->
        <aside class="fixed inset-y-0 left-0 z-30 hidden w-64 flex-col border-r border-ink-border bg-ink-soft lg:flex">
            <div class="flex h-20 items-center gap-4 border-b border-ink-border px-6">
                <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-orange-500 font-mono text-sm font-bold text-black">JC</span>
                <div class="min-w-0">
                    <p class="truncate text-sm font-semibold">John Lee Calulut</p>
                    <p class="text-xs text-orange-400">Admin Panel</p>
                </div>
            </div>

            <nav class="flex-1 space-y-1 overflow-y-auto px-3 py-6" aria-label="Admin sections">
                <Link
                    v-for="item in nav"
                    :key="item.label"
                    :href="item.href"
                    class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm transition-colors"
                    :class="item.active ? 'bg-orange-500/10 text-orange-400' : 'text-neutral-400 hover:bg-white/5 hover:text-white'"
                >
                    <AppIcon :name="item.icon" class="h-5 w-5 shrink-0" />
                    <span class="flex-1">{{ item.label }}</span>
                    <span
                        v-if="item.badge"
                        class="flex h-5 min-w-5 items-center justify-center rounded-full bg-orange-500 px-1.5 text-xs font-semibold text-black"
                    >
                        {{ item.badge }}
                    </span>
                </Link>
            </nav>

            <div class="space-y-1 border-t border-ink-border px-3 py-4">
                <a
                    href="/"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm text-neutral-400 transition-colors hover:text-white"
                >
                    <AppIcon name="external" class="h-5 w-5" />
                    View portfolio
                </a>
                <button
                    type="button"
                    @click="logout"
                    class="flex w-full items-center gap-3 rounded-xl px-3 py-2.5 text-left text-sm text-neutral-400 transition-colors hover:text-orange-400"
                >
                    <AppIcon name="x" class="h-5 w-5" />
                    {{ admin?.name ? `Logout · ${admin.name}` : 'Logout' }}
                </button>
            </div>
        </aside>

        <!-- Content -->
        <div class="lg:pl-64">
            <main class="mx-auto max-w-6xl px-6 py-10 lg:px-10">
                <div
                    v-if="flash.success || flash.error"
                    class="mb-8 rounded-xl border px-5 py-4 text-sm"
                    :class="flash.success ? 'border-green-500/40 bg-green-500/10 text-green-300' : 'border-red-500/40 bg-red-500/10 text-red-300'"
                    role="status"
                >
                    {{ flash.success || flash.error }}
                </div>

                <slot />
            </main>
        </div>
    </div>
</template>
