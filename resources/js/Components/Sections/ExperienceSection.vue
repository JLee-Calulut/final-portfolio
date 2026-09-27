<script setup>
import SectionTitle from '@/Components/UI/SectionTitle.vue';
import Timeline from '@/Components/Timeline/Timeline.vue';

// Seeded as a "Development Journey". When real roles exist, update the
// timeline_items table — the component needs no changes.
defineProps({
    timeline: { type: Array, default: () => [] },
});
</script>

<template>
    <section id="experience" class="scroll-mt-16 border-t border-ink-border lg:scroll-mt-0">
        <div class="mx-auto max-w-6xl px-6 py-24">
            <SectionTitle
                title="Development journey"
                description="How I got here — the path from first HTML tag to full-stack applications."
            />

            <div class="mt-14 max-w-2xl">
                <Timeline :items="timeline" />
            </div>
        </div>
    </section>
</template>
