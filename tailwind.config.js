import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],

    theme: {
        extend: {
            colors: {
                // Portfolio design tokens (dark orange / black developer theme)
                ink: {
                    DEFAULT: '#050505',
                    soft: '#111111',
                    card: '#171717',
                    border: '#262626',
                },
            },
            fontFamily: {
                sans: ['Inter', ...defaultTheme.fontFamily.sans],
                mono: ['JetBrains Mono', ...defaultTheme.fontFamily.mono],
            },
            boxShadow: {
                glow: '0 0 40px -10px rgba(249, 115, 22, 0.25)',
            },
        },
    },

    plugins: [forms],
};
