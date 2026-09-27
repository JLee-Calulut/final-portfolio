/**
 * Centralized site configuration — the single source of truth for
 * site-wide information. Import from here instead of repeating values
 * across components.
 *
 * NOTE: The social URLs below are placeholders. Replace them with your
 * real profiles before deploying.
 */

export const site = {
    name: 'John Lee Calulut',
    fullName: 'John Lee Liberato Calulut',
    role: 'Frontend / Backend Developer',
    intro: "I'm a Laravel and Vue developer building modern, responsive web applications.",
    email: 'calulut.jlee@gmail.com',

    navigation: [
        { id: 'home',       label: 'Home',       icon: 'home' },
        { id: 'about',      label: 'About',      icon: 'user' },
        { id: 'skills',     label: 'Skills',     icon: 'code' },
        { id: 'services',   label: 'Services',   icon: 'briefcase' },
        { id: 'projects',   label: 'Projects',   icon: 'folder' },
        { id: 'experience', label: 'Experience', icon: 'clock' },
        { id: 'education',  label: 'Education',  icon: 'book' },
        { id: 'contact',    label: 'Contact',    icon: 'mail' },
    ],

    socials: [
        { label: 'GitHub',   url: 'https://github.com/JLee-Calulut',   icon: 'github' },
        { label: 'LinkedIn', url: 'https://www.linkedin.com/in/john-lee-calulut-7b7222437/',  icon: 'linkedin' },
    ],

    technologies: ['Laravel', 'Vue.js', 'Tailwind CSS', 'PHP', 'JavaScript', 'MySQL'],

    meta: {
        title: 'John Lee Calulut — Frontend / Backend Developer',
        description:
            'John Lee Calulut — Frontend and Backend Developer specializing in Laravel, Vue.js and modern responsive web applications.',
    },
};

export default site;
