import { computed } from 'vue';
import { site } from '@/Data/site';

/**
 * Theme composable — convenient access to the design tokens and
 * site configuration used across components.
 */
export function useTheme() {
    const colors = {
        background: '#050505',
        backgroundSoft: '#111111',
        card: '#171717',
        accent: '#f97316',
        accentHover: '#fb923c',
        text: '#ffffff',
        textSecondary: '#a3a3a3',
        border: '#262626',
    };

    const currentYear = computed(() => new Date().getFullYear());

    return { site, colors, currentYear };
}
