import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],
    darkMode: 'class',

    theme: {
        extend: {
            colors: {
                // Vibrant Orange Theme (Brand Primary)
                indigo: {
                    50: '#fff2bc', // User light bright yellow
                    100: '#ffe0b2',
                    200: '#ffcc80',
                    300: '#ffb74d',
                    400: '#ff9800',
                    500: '#ff5a0b', // User main orange
                    600: '#e65100', // Hover 
                    700: '#ff0000', // User red
                    800: '#d50000',
                    900: '#b71c1c',
                },
                // Warm dark theme (Brand Base)
                slate: {
                    50: '#fff2bc',  // User bright yellow background
                    100: '#ffecaf',
                    200: '#e5d19e',
                    300: '#bca67e',
                    400: '#948175',
                    500: '#806f66', // User muted taupe
                    600: '#695850',
                    700: '#52433b',
                    800: '#383636', // User deep dark gray
                    900: '#262424',
                    950: '#171616',
                },
                // Red Accent (from user colors)
                emerald: {
                    100: '#ffcccc',
                    400: '#ff6666',
                    500: '#ff0000', // User Red
                    600: '#cc0000',
                }
            },
            fontFamily: {
                sans: ['Outfit', 'Figtree', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    plugins: [forms],
};
