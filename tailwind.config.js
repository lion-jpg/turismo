/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
  ],
  darkMode: 'class',
  theme: {
    extend: {
      colors: { 
        danger: colors.rose,
        primary: colors.blue,
        success: colors.green,
        warning: colors.amber,
    }, 
    },
  },
  plugins: [],
}

