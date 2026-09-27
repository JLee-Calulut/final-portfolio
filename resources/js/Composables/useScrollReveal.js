import { onMounted, onUnmounted } from 'vue';

/**
 * Scroll-reveal composable.
 *
 * Observes every `.reveal` element inside the given container and toggles
 * `.is-visible` as elements enter/leave the viewport — so animations
 * replay on re-entry instead of running only once.
 *
 * Users with `prefers-reduced-motion` get fully visible content with no
 * animation (also enforced in CSS).
 *
 * Usage:
 *   const root = ref(null);
 *   useScrollReveal(root);
 *   <main ref="root"> ... <div class="reveal"> ...
 */
export function useScrollReveal(containerRef) {
    let observer = null;

    onMounted(() => {
        const root = containerRef.value ?? document;
        const elements = root.querySelectorAll('.reveal');

        const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
        if (reducedMotion) {
            elements.forEach((el) => el.classList.add('is-visible'));
            return;
        }

        observer = new IntersectionObserver(
            (entries) => {
                for (const entry of entries) {
                    entry.target.classList.toggle('is-visible', entry.isIntersecting);
                }
            },
            { threshold: 0.15, rootMargin: '0px 0px -8% 0px' }
        );

        elements.forEach((el) => observer.observe(el));
    });

    onUnmounted(() => observer?.disconnect());
}
