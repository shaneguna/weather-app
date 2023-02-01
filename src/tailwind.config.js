/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        "./resources/**/*.js",
        "./resources/**/*.blade.php",
        "./resources/**/*.vue"
    ],
    theme: {
        fontSize: {
            '2xl': '1.563rem',
            '3xl': '1.953rem',
            '4xl': '2.441rem',
            '5xl': '3.052rem',
        },
        extend: {},
    },
    plugins: [],
}
