<script setup>
import SectionTitle from '@/Components/UI/SectionTitle.vue';
import ServiceCard from '@/Components/Cards/ServiceCard.vue';

defineProps({
    services: { type: Array, default: () => [] },
});
</script>

<template>
    <section id="services" class="scroll-mt-16 border-t border-ink-border lg:scroll-mt-0">
        <div class="mx-auto max-w-6xl px-6 py-24">
            <SectionTitle
                title="What I can build for you"
                description="From a single component to a complete application — here's where I can help."
            />

            <div class="mt-14 grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
                <ServiceCard v-for="service in services" :key="service.id" :service="service" />
            </div>
        </div>
    </section>
</template>
