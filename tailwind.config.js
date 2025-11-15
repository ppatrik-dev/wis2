/** @type {import('tailwindcss').Config} */
module.exports = {
  darkMode: 'false',
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
    "./node_modules/flowbite/**/*.js",
     "./resources/views/vendor/pagination/*.blade.php",
  ],
  theme: {
    extend: {},
  },
  plugins: [
    require('flowbite/plugin')
  ],
}
