import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
		'./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
		 './storage/framework/views/*.php',
		 './resources/views/**/*.blade.php',
		 "./vendor/robsontenorio/mary/src/View/Components/**/*.php"
	],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                primary: "#552E10",

                secodary: {
                    700: '#1d4ed8',  
                },
            },
        },
    },

    plugins: [
		forms,
		require("daisyui")
	],
    darkMode: 'class', 
    daisyui: {
        themes: ["light", "dark", "aqua", "cupcake"],
    },
};
