<script setup>
import { Head, Link } from '@inertiajs/vue3';
import AppLayout from '@/Components/Layout/AppLayout.vue';
import AppIcon from '@/Components/UI/AppIcon.vue';
import TodoApp from '@/Components/Todo/TodoApp.vue';
</script>

<template>
    <Head title="Todo List">
        <meta
            name="description"
            content="A keyboard-friendly task manager built with Vue 3 and Tailwind CSS — add, complete, edit, and filter tasks with browser-local persistence."
            head-key="description"
        >
    </Head>

    <AppLayout>
        <section class="relative overflow-hidden">
            <!-- Dot-grid + glow backdrop, same treatment as the hero -->
            <div class="bg-grid absolute inset-0 opacity-60" aria-hidden="true" />
            <div class="absolute -top-24 right-1/4 h-80 w-80 rounded-full bg-orange-500/10 blur-3xl" aria-hidden="true" />

            <div class="relative mx-auto max-w-5xl px-6 py-16 lg:py-24">
                <!-- Page heading -->
                <div class="reveal max-w-2xl">
                    <div class="flex items-center gap-3">
                        <span class="flex h-10 w-10 items-center justify-center rounded-xl border border-orange-500/30 bg-orange-500/10 text-orange-500">
                            <AppIcon name="check" class="h-5 w-5" />
                        </span>
                        <p class="font-mono text-sm text-orange-400">Personal project</p>
                    </div>
                    <h1 class="mt-4 text-3xl font-bold tracking-tight text-white sm:text-4xl">Todo List</h1>
                    <p class="mt-4 leading-relaxed text-neutral-400">
                        A keyboard-friendly task manager built with Vue 3 and Tailwind CSS.
                        Add, complete, edit, and filter tasks — they persist in your browser,
                        no account or database needed.
                    </p>
                    <Link
                        href="/"
                        class="mt-6 inline-flex items-center gap-2 font-mono text-sm text-neutral-500 transition hover:text-orange-400"
                    >
                        <AppIcon name="arrow-right" class="h-4 w-4 rotate-180" />
                        Back to portfolio
                    </Link>
                </div>

                <!-- The app -->
                <div class="reveal mx-auto mt-12 w-full max-w-2xl">
                    <TodoApp />
                </div>
            </div>
        </section>
    </AppLayout>
</template>
