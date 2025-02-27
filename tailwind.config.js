const defaultTheme = require('tailwindcss/defaultTheme');

module.exports = {
    content: [
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],
    theme: {
        extend: {
            fontFamily: {
                poppins: ['Poppins', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                softred: "#E55A3C",  
                softoren: "#FFA24D",
                hvoren: "#cc7828", 
              },
        },
    },
    plugins: [],
};
