<script setup>
import SectionTitle from '@/Components/UI/SectionTitle.vue';

// Education history — rendered entirely from the database. Manage the
// entries from the admin panel at /admin/education.
defineProps({
    education: { type: Array, default: () => [] },
});
</script>

<template>
    <section id="education" class="scroll-mt-16 border-t border-ink-border lg:scroll-mt-0">
        <div class="mx-auto max-w-6xl px-6 py-24">
            <SectionTitle
                title="Education"
                description="My academic background and specialized training."
            />

            <p v-if="education.length === 0" class="mt-14 max-w-2xl rounded-2xl border border-dashed border-ink-border px-6 py-14 font-mono text-sm text-neutral-500">
                No education entries yet.
            </p>

            <div class="mt-14 grid grid-cols-1 gap-6 lg:grid-cols-2">
                <article
                    v-for="item in education"
                    :key="item.id"
                    class="reveal rounded-2xl border border-ink-border bg-ink-card p-7 transition duration-500 hover:-translate-y-1 hover:border-orange-500/60"
                >
                    <div class="flex flex-wrap items-start justify-between gap-3">
                        <div>
                            <p v-if="item.field_of_study" class="font-mono text-xs text-orange-400">
                                {{ item.field_of_study }}
                            </p>
                            <h3 class="mt-2 text-lg font-semibold text-white">{{ item.institution }}</h3>
                            <p class="mt-1 text-sm text-orange-400/80">{{ item.degree }}</p>
                        </div>
                        <div class="text-right">
                            <p v-if="item.period" class="font-mono text-xs text-neutral-400">{{ item.period }}</p>
                            <p v-if="item.location" class="mt-1 text-xs text-neutral-500">{{ item.location }}</p>
                        </div>
                    </div>
                    <p v-if="item.description" class="mt-4 leading-relaxed text-neutral-400">{{ item.description }}</p>
                </article>
            </div>
        </div>
    </section>
</template>
