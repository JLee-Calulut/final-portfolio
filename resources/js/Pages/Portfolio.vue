<script setup>
import { Head } from '@inertiajs/vue3';
import AppLayout from '@/Components/Layout/AppLayout.vue';
import HeroSection from '@/Components/Sections/HeroSection.vue';
import AboutSection from '@/Components/Sections/AboutSection.vue';
import SkillsSection from '@/Components/Sections/SkillsSection.vue';
import ServicesSection from '@/Components/Sections/ServicesSection.vue';
import ProjectsSection from '@/Components/Sections/ProjectsSection.vue';
import ExperienceSection from '@/Components/Sections/ExperienceSection.vue';
import EducationSection from '@/Components/Sections/EducationSection.vue';
import ContactSection from '@/Components/Sections/ContactSection.vue';
import { site } from '@/Data/site';

defineProps({
    projects: { type: Array, default: () => [] },
    skills: { type: Object, default: () => ({}) },
    services: { type: Array, default: () => [] },
    timeline: { type: Array, default: () => [] },
    education: { type: Array, default: () => [] },
});
</script>

<template>
    <Head :title="site.meta.title">
        <meta name="description" :content="site.meta.description" head-key="description">
    </Head>

    <AppLayout>
        <HeroSection />
        <AboutSection />
        <SkillsSection :skills="skills" />
        <ServicesSection :services="services" />
        <ProjectsSection :projects="projects" />
        <ExperienceSection :timeline="timeline" />
        <EducationSection :education="education" />
        <ContactSection />
    </AppLayout>
</template>
