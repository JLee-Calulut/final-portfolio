<script setup>
import { Head, useForm, Link } from '@inertiajs/vue3';

const form = useForm({
    email: '',
    password: '',
    remember: true,
});

function submit() {
    form.post('/admin/login');
}
</script>

<template>
    <Head title="Admin Login" />

    <div class="flex min-h-screen items-center justify-center bg-ink px-6 py-16 text-white">
        <div class="w-full max-w-md">
            <div class="mb-10 text-center">
                <span class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-orange-500 font-mono text-xl font-bold text-black">JC</span>
                <h1 class="mt-6 text-2xl font-bold tracking-tight">Admin Login</h1>
                <p class="mt-2 font-mono text-sm text-orange-400"> Welcome Developer </p>
            </div>

            <form
                class="space-y-6 rounded-2xl border border-ink-border bg-ink-card p-8"
                @submit.prevent="submit"
            >
                <div>
                    <label for="email" class="mb-2 block text-sm font-medium text-neutral-200">Email</label>
                    <input
                        id="email"
                        v-model="form.email"
                        type="email"
                        autocomplete="username"
                        required
                        class="w-full rounded-xl border border-ink-border bg-ink px-4 py-3 text-white placeholder-neutral-600 transition focus:border-orange-500 focus:outline-none focus:ring-2 focus:ring-orange-500/30"
                        placeholder="admin@johncalulut.dev"
                    />
                    <p v-if="form.errors.email" class="mt-2 text-xs text-red-400">{{ form.errors.email }}</p>
                </div>

                <div>
                    <label for="password" class="mb-2 block text-sm font-medium text-neutral-200">Password</label>
                    <input
                        id="password"
                        v-model="form.password"
                        type="password"
                        autocomplete="current-password"
                        required
                        class="w-full rounded-xl border border-ink-border bg-ink px-4 py-3 text-white placeholder-neutral-600 transition focus:border-orange-500 focus:outline-none focus:ring-2 focus:ring-orange-500/30"
                        placeholder="••••••••"
                    />
                    <p v-if="form.errors.password" class="mt-2 text-xs text-red-400">{{ form.errors.password }}</p>
                </div>

                <label class="flex cursor-pointer items-center gap-3 text-sm text-neutral-300">
                    <input v-model="form.remember" type="checkbox" class="h-4 w-4 rounded border-ink-border bg-ink text-orange-500 focus:ring-orange-500" />
                    Remember me
                </label>

                <button
                    type="submit"
                    :disabled="form.processing"
                    class="inline-flex w-full items-center justify-center gap-2 rounded-xl bg-orange-500 px-6 py-3 text-sm font-semibold text-black transition hover:bg-orange-400 disabled:opacity-60"
                >
                    {{ form.processing ? 'Signing in…' : 'Sign in' }}
                </button>

                <Link href="/" class="block text-center font-mono text-xs text-neutral-500 hover:text-orange-400">
                    ← back to portfolio
                </Link>
            </form>
        </div>
    </div>
</template>
