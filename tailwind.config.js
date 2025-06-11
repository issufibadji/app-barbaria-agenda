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
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                brown: {
                    50: '#efebe9',
                    100: '#d7ccc8',
                    200: '#bcaaa4',
                    300: '#a1887f',
                    400: '#8d6e63',
                    500: '#795548',
                    600: '#6d4c41',
                    700: '#5d4037',
                    800: '#4e342e',
                    900: '#3e2723',

                },
                camel: {
                    50: '#f5f0e3',
                    100: '#e7dcc0',
                    200: '#d9c69b',
                    300: '#ccb179',
                    400: '#c0af7d', // valor principal
                    500: '#a98f63',
                    600: '#8c744f',
                    700: '#6f5a3d',
                    800: '#53412d',
                    900: '#382a1d',
                },
            },
        },
    },

    plugins: [forms],
};
