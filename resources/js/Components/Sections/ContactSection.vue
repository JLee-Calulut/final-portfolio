<script setup>
import { site } from '@/Data/site';
import SectionTitle from '@/Components/UI/SectionTitle.vue';
import ContactForm from '@/Components/Forms/ContactForm.vue';
import Card from '@/Components/Cards/Card.vue';
import AppIcon from '@/Components/UI/AppIcon.vue';
</script>

<template>
    <section id="contact" class="scroll-mt-16 border-t border-ink-border bg-ink-soft/40 lg:scroll-mt-0">
        <div class="mx-auto max-w-6xl px-6 py-24">
            <SectionTitle
                title="Let's build projects"
                description="Have a project in mind, or just want to say hi? My inbox is open."
            />

            <div class="mt-14 grid gap-10 lg:grid-cols-[1fr_1.4fr]">
                <!-- Contact info -->
                <div class="reveal space-y-6">
                    <p class="leading-relaxed text-neutral-400">
                        I'm open to freelance projects, collaboration, and full-time opportunities.
                        Send a message and I'll get back to you as soon as I can.
                    </p>

                    <a
                        :href="`mailto:${site.email}`"
                        class="group flex items-center gap-4 rounded-2xl border border-ink-border bg-ink-card p-4 transition duration-300 hover:border-orange-500/60"
                    >
                        <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl border border-orange-500/30 bg-orange-500/10 text-orange-500">
                            <AppIcon name="mail" class="h-5 w-5" />
                        </span>
                        <span>
                            <span class="block text-xs text-neutral-500">Email me at</span>
                            <span class="block text-sm font-semibold text-white transition group-hover:text-orange-400">
                                {{ site.email }}
                            </span>
                        </span>
                    </a>

                    <ul class="flex gap-3" aria-label="Social links">
                        <li v-for="social in site.socials" :key="social.label">
                            <a
                                :href="social.url"
                                target="_blank"
                                rel="noopener noreferrer"
                                :aria-label="social.label"
                                class="flex h-11 w-11 items-center justify-center rounded-xl border border-ink-border text-neutral-400 transition duration-300 hover:border-orange-500 hover:text-orange-400"
                            >
                                <AppIcon :name="social.icon" class="h-5 w-5" />
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Form -->
                <Card>
                    <ContactForm />
                </Card>
            </div>
        </div>
    </section>
</template>
