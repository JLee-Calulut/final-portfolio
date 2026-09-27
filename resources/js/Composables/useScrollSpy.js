import { onMounted, onUnmounted, ref } from 'vue';

/**
 * Scroll-spy composable.
 *
 * Tracks which page section is currently in view and exposes its id,
 * so the sidebar / mobile nav can highlight the active section.
 *
 * Usage:
 *   const activeSection = useScrollSpy(['home', 'about', 'skills', ...]);
 */
export function useScrollSpy(sectionIds) {
    const activeId = ref(sectionIds[0] ?? '');
    let observer = null;

    onMounted(() => {
        observer = new IntersectionObserver(
            (entries) => {
                for (const entry of entries) {
                    if (entry.isIntersecting) {
                        activeId.value = entry.target.id;
                    }
                }
            },
            // A section counts as "active" when its middle band crosses the
            // upper-middle of the viewport.
            { rootMargin: '-35% 0px -55% 0px', threshold: 0 }
        );

        for (const id of sectionIds) {
            const el = document.getElementById(id);
            if (el) observer.observe(el);
        }
    });

    onUnmounted(() => observer?.disconnect());

    return activeId;
}
