<script setup>
import { site } from '@/Data/site';
import PrimaryButton from '@/Components/Buttons/PrimaryButton.vue';
import OutlineButton from '@/Components/Buttons/OutlineButton.vue';
import AppIcon from '@/Components/UI/AppIcon.vue';
</script>

<template>
    <section id="home" class="relative flex min-h-screen scroll-mt-16 items-center overflow-hidden lg:scroll-mt-0">
        <!-- Subtle background: dot grid + single orange glow -->
        <div class="bg-grid absolute inset-0 opacity-70" aria-hidden="true" />
        <div class="absolute -top-24 right-1/4 h-80 w-80 rounded-full bg-orange-500/10 blur-3xl" aria-hidden="true" />

        <div class="relative mx-auto grid w-full max-w-6xl gap-14 px-6 py-24 lg:grid-cols-[1.1fr_1fr] lg:items-center">
            <!-- Copy -->
            <div class="reveal">
                <h1 class="mt-4 text-4xl font-extrabold tracking-tight text-white sm:text-5xl">
                    Hi, I'm <span class="text-orange-500">John Lee Calulut</span>
                </h1>
                <p class="mt-4 text-xl font-semibold text-neutral-200">{{ site.role }}</p>
                <p class="mt-4 max-w-md leading-relaxed text-neutral-400">
                    I build modern, responsive and scalable web applications using
                    <span class="text-orange-400">Laravel</span>,
                    <span class="text-orange-400">Vue</span> and
                    <span class="text-orange-400">Tailwind CSS</span>.
                </p>

                <div class="mt-8 flex flex-wrap gap-4">
                    <PrimaryButton href="#projects">View My Projects</PrimaryButton>
                    <OutlineButton href="#contact">Contact Me</OutlineButton>
                </div>

                <ul class="mt-10 flex flex-wrap gap-2" aria-label="Core technologies">
                    <li
                        v-for="tech in site.technologies"
                        :key="tech"
                        class="rounded-lg border border-ink-border bg-ink-soft/80 px-3 py-1.5 font-mono text-xs text-neutral-300"
                    >
                        {{ tech }}
                    </li>
                </ul>
            </div>

            <!-- Developer visual: a code-editor mock built with pure markup -->
            <div class="reveal relative hidden md:block" aria-hidden="true">
                <div class="rounded-2xl border border-ink-border bg-ink-soft/90 shadow-glow backdrop-blur">
                    <div class="flex items-center gap-2 border-b border-ink-border px-4 py-3">
                        <span class="h-3 w-3 rounded-full bg-neutral-700" />
                        <span class="h-3 w-3 rounded-full bg-neutral-700" />
                        <span class="h-3 w-3 rounded-full bg-orange-500" />
                        <span class="ml-3 font-mono text-xs text-neutral-500">PortfolioController.php</span>
                    </div>
                    <pre class="overflow-x-auto p-6 font-mono text-[13px] leading-7"><code><span class="text-orange-400">class</span> <span class="text-white">PortfolioController</span>
{
    <span class="text-orange-400">public function</span> <span class="text-white">index</span>(): <span class="text-white">Response</span>
    {
        <span class="text-orange-400">return</span> Inertia::render(<span class="text-orange-300">'Portfolio'</span>, [
            <span class="text-orange-300">'stack'</span> =&gt; [<span class="text-orange-300">'Laravel'</span>, <span class="text-orange-300">'Vue'</span>, <span class="text-orange-300">'Tailwind'</span>],
            <span class="text-orange-300">'design'</span> =&gt; <span class="text-orange-300">'dark · minimal · technical'</span>,
        ]);
    }
}</code></pre>
                </div>

                <!-- Floating tech badges -->
                <span class="absolute -left-4 bottom-10 rounded-xl border border-ink-border bg-ink-card px-4 py-2 font-mono text-xs font-semibold text-orange-400 shadow-glow">
                    Laravel
                </span>
                <span class="absolute -right-4 -top-4 rounded-xl border border-ink-border bg-ink-card px-4 py-2 font-mono text-xs font-semibold text-orange-400 shadow-glow">
                    Vue.js
                </span>
            </div>
        </div>

        <!-- Scroll indicator -->
        <a
            href="#about"
            class="absolute bottom-6 left-1/2 -translate-x-1/2 text-neutral-500 transition hover:text-orange-500"
            aria-label="Scroll to the About section"
        >
            <AppIcon name="chevron-down" class="h-6 w-6 animate-bounce" />
        </a>
    </section>
</template>
