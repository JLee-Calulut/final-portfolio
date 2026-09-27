<script setup>
import { computed } from 'vue';

const props = defineProps({
    name: { type: String, required: true },
});

// Stroke-based icons inherit `currentColor`; brand marks are filled.
const paths = {
    home: 'M3 10.5 12 3l9 7.5M5 9.5V21h5v-6h4v6h5V9.5',
    user: 'M12 12a4 4 0 1 0 0-8 4 4 0 0 0 0 8Zm-7 9a7 7 0 0 1 14 0',
    code: 'm8 8-5 4 5 4m8-8 5 4-5 4M13 5l-2 14',
    briefcase: 'M4 8h16v12H4zM9 8V6a3 3 0 0 1 6 0v2M4 13h16',
    folder: 'M3 7h6l2 2h10v10a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z',
    clock: 'M12 21a9 9 0 1 0 0-18 9 9 0 0 0 0 18Zm0-13v5l3 3',
    mail: 'M4 6h16v12H4zM4 7l8 6 8-6',
    menu: 'M4 7h16M4 12h16M4 17h16',
    x: 'M6 6l12 12M18 6 6 18',
    'chevron-down': 'm6 9 6 6 6-6',
    'arrow-right': 'M4 12h16m-6-6 6 6-6 6',
    external: 'M14 4h6v6M20 4 10 14M9 5H6a2 2 0 0 0-2 2v11a2 2 0 0 0 2 2h11a2 2 0 0 0 2-2v-3',
    monitor: 'M4 5h16v10H4zM9 20h6m-3-5v5',
    server: 'M4 5h16v6H4zM4 13h16v6H4zM7.5 8h.01M7.5 16h.01',
    layers: 'm12 3 9 5-9 5-9-5zM3 13l9 5 9-5',
    components: 'M4 4h6v6H4zM14 4h6v6h-6zM4 14h6v6H4zM14 14h6v6h-6z',
    devices: 'M4 6h12v9H4zM16 9h4v8h-4M9 19h4',
    database: 'M12 8c4.4 0 8-1.1 8-2.5S16.4 3 12 3 4 4.1 4 5.5 7.6 8 12 8Zm-8-2.5v13C4 19.9 7.6 21 12 21s8-1.1 8-2.5v-13M4 12c0 1.4 3.6 2.5 8 2.5s8-1.1 8-2.5',
    terminal: 'M4 5h16v14H4zM7 9l3 3-3 3m5 0h5',
    tools: 'M14.7 6.3a4 4 0 0 0-5.4 5.4L4 17l3 3 5.3-5.3a4 4 0 0 0 5.4-5.4L15 12l-3-3z',
    check: 'm5 13 4 4L19 7',
    book: 'M12 6.5C10 4.5 6 3.5 4 4.5v14c2-1 6 0 8 2 2-2 6-3 8-2v-14c-2-1-6 0-8 2zM12 6.5V20.5',
    plus: 'M12 5v14M5 12h14',
    trash: 'M4 7h16M10 7V4h4v3m-6 0 1.2 13h5.6L16 7M10 11v6m4-6v6',
    pencil: 'M4 20h4L19 9.4 14.6 5 4 15.6V20ZM13.6 6.4l4 4',
};

const brandPaths = {
    github: 'M12 .5C5.65.5.5 5.65.5 12c0 5.08 3.29 9.39 7.86 10.91.58.11.79-.25.79-.55 0-.27-.01-1.17-.02-2.12-3.2.7-3.88-1.36-3.88-1.36-.52-1.33-1.28-1.68-1.28-1.68-1.04-.71.08-.7.08-.7 1.15.08 1.76 1.19 1.76 1.19 1.03 1.76 2.69 1.25 3.35.96.1-.75.4-1.25.72-1.54-2.55-.29-5.24-1.28-5.24-5.69 0-1.26.45-2.28 1.19-3.09-.12-.29-.52-1.46.11-3.05 0 0 .97-.31 3.18 1.18a11.1 11.1 0 0 1 5.8 0c2.2-1.49 3.17-1.18 3.17-1.18.63 1.59.23 2.76.11 3.05.74.81 1.19 1.83 1.19 3.09 0 4.42-2.7 5.39-5.27 5.68.41.36.78 1.05.78 2.13 0 1.54-.01 2.78-.01 3.16 0 .31.21.67.8.55A11.52 11.52 0 0 0 23.5 12C23.5 5.65 18.35.5 12 .5Z',
    linkedin: 'M20.45 20.45h-3.55v-5.57c0-1.33-.03-3.04-1.85-3.04-1.86 0-2.14 1.45-2.14 2.94v5.67H9.35V9h3.41v1.56h.05a3.74 3.74 0 0 1 3.37-1.85c3.6 0 4.27 2.37 4.27 5.46v6.28ZM5.34 7.43a2.06 2.06 0 1 1 0-4.12 2.06 2.06 0 0 1 0 4.12ZM7.12 20.45H3.55V9h3.57v11.45Z',
};

const isBrand = computed(() => props.name in brandPaths);
const d = computed(() => paths[props.name] ?? brandPaths[props.name] ?? paths.code);
</script>

<template>
    <svg
        viewBox="0 0 24 24"
        aria-hidden="true"
        :fill="isBrand ? 'currentColor' : 'none'"
        :stroke="isBrand ? 'none' : 'currentColor'"
        stroke-width="1.8"
        stroke-linecap="round"
        stroke-linejoin="round"
    >
        <path :d="d" />
    </svg>
</template>
