/** @type {import('tailwindcss').Config} */
module.exports = {
  mode: "jit",
  important: ".tailwind",
  content: ["./templates/**/*.php", "./assets/**/*.{svelte,ts}"],
  theme: {
    extend: {},
  },
  plugins: [],
};
