import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Inter', ...defaultTheme.fontFamily.sans],
                mono: ['"DM Mono"', ...defaultTheme.fontFamily.mono],
            },
            colors: {
                ink: '#111110',
                paper: '#E6E6E4',
                card: '#EEEEED',
                accent: '#FF2D78',
                muted: '#8A8A88',
            },
            boxShadow: {
                'neu-raised': '7px 7px 18px rgba(0,0,0,0.13), -5px -5px 14px rgba(255,255,255,0.90)',
                'neu-inset': 'inset 4px 4px 10px rgba(0,0,0,0.11), inset -3px -3px 8px rgba(255,255,255,0.82)',
                'neu-subtle': '4px 4px 10px rgba(0,0,0,0.09), -3px -3px 8px rgba(255,255,255,0.88)',
                'neu-card': '3px 3px 8px rgba(0,0,0,0.08), -2px -2px 6px rgba(255,255,255,0.82)',
                'neu-accent': '4px 4px 14px rgba(255,45,120,0.35), -2px -2px 8px rgba(255,255,255,0.06)',
            },
        },
    },

    plugins: [forms],
};
