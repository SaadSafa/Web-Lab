/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme: {
    extend: {
      colors: {
        cream: {
          50:  "#fffaf0",
          100: "#fef3c7",
          200: "#fde68a",
        },
      },
    },
  },
  plugins: [],
}
