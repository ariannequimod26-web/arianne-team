import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    safelist: [
        // Dynamic status colors used in Blade templates via $order->getStatusColor()
        {
            pattern: /bg-(yellow|blue|orange|green|gray|red)-(50|100|200|600)/,
        },
        {
            pattern: /text-(yellow|blue|orange|green|gray|red)-(400|500|600|700|800)/,
        },
        {
            pattern: /border-(yellow|blue|orange|green|gray|red)-(100|200)/,
        },
        {
            pattern: /shadow-(yellow|blue|orange|green|gray|red)-(500)/,
        },
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                canteen: {
                    50:  '#FFF7ED',
                    100: '#FFEDD5',
                    200: '#FED7AA',
                    300: '#FDBA74',
                    400: '#FB923C',
                    500: '#F97316',
                    600: '#EA580C',
                    700: '#C2410C',
                    800: '#9A3412',
                    900: '#7C2D12',
                    950: '#431407',
                },
                warm: {
                    bg: '#FFFBF5',
                    surface: '#FFFFFF',
                },
            },
            borderRadius: {
                '4xl': '2rem',
                '5xl': '2.5rem',
            },
        },
    },

    plugins: [forms],
};
