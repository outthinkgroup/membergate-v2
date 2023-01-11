import path from "path";
import { defineConfig } from "vite";
import { svelte } from "@sveltejs/vite-plugin-svelte";

// https://vitejs.dev/config/
export default defineConfig({
  root: "./",
  base:
    process.env.APP_ENV === "development"
      ? "/"
      : `/wp-content/plugins/membergate/assets/dist/`,

  build: {
    manifest: true,
    outDir: path.resolve(__dirname, "assets/dist"),
    rollupOptions: {
      input: "assets/main.ts",
    },
  },
  server: {
    // required to load scripts from custom host
    cors: true,
    strictPort: true,
    port: 1234,
    hmr: {
      port: 1234,
      host: "localhost",
      protocol: "ws",
    },
  },
  plugins: [svelte()],
});