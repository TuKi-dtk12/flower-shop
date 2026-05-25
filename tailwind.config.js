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
            colors: {
                lux: {
                    bg: '#08100D',
                    card: '#111F1A',
                    gold: '#E5C07B',
                    text: '#E2E8F0',
                },
                floral: {
                    petal: '#f8d7df',
                    sage: '#9eb7a3',
                    charcoal: '#2a2a2a',
                    mist: '#f6f7f5',
                },
                organic: {
                    sage: '#f0f4f2',
                    rose: '#fdf2f4',
                    cream: '#fbf7f0',
                    forest: '#1a2e26',
                    charcoal: '#18221e',
                    coral: '#e5535f',
                    crimson: '#b12b3f',
                },
            },
            fontFamily: {
                sans: ['Montserrat', ...defaultTheme.fontFamily.sans],
                serif: ['Playfair Display', ...defaultTheme.fontFamily.serif],
            },
            keyframes: {
                'fade-in-up': {
                    '0%': { opacity: '0', transform: 'translateY(18px)' },
                    '100%': { opacity: '1', transform: 'translateY(0)' },
                },
                'soft-float': {
                    '0%, 100%': { transform: 'translateY(0px)' },
                    '50%': { transform: 'translateY(-6px)' },
                },
            },
            animation: {
                'fade-in-up': 'fade-in-up 0.7s ease-out both',
                'soft-float': 'soft-float 6s ease-in-out infinite',
            },
        },
    },

    plugins: [forms],
};
