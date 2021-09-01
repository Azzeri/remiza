const defaultTheme = require('tailwindcss/defaultTheme');

module.exports = {
    purge: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Nunito', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                primary: {
                    100: '#e05652',
                    200: '#db3a34'
                },
                secondary : {
                    50: '#ffffff',
                    100: '#ffc857',
                    200: '#ffbb33'
                },
                
                'tertiary':'#f2f2f2',
                text: {
                    100: '#413e40',
                    200: '#323031'
                }
            }
        },
    },

    variants: {
        extend: {
            opacity: ['disabled'],
        },
    },

    plugins: [require('@tailwindcss/forms')],
};
