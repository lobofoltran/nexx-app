import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import typography from '@tailwindcss/typography';

/** @type {import('tailwindcss').Config} */
export default {
    darkMode: 'false',
    
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    safelist: [
        'bg-zinc-500',
        'bg-zinc-600',
        'bg-sky-500',
        'bg-sky-600',
        'bg-yellow-500',
        'bg-yellow-600',
        'bg-red-500',
        'bg-red-600',
        'bg-blue-500',
        'bg-blue-600',
        'bg-orange-500',
        'bg-orange-600',
        'bg-green-500',
        'bg-green-600',
        'border-yellow-500',
        'border-yellow-600',
        'border-red-500',
        'border-red-600',
        'border-blue-500',
        'border-blue-600',
        'border-orange-500',
        'border-orange-600',
        'border-green-500',
        'border-green-600',
    ],    

    plugins: [forms, typography],
};
