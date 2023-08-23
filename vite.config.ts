import { dirname, resolve } from "path";
import { fileURLToPath, URL } from "node:url";
import { defineConfig } from "vite";
import { NormalizedInputOptions, PluginContext } from "rollup";
import { svelte } from "@sveltejs/vite-plugin-svelte";
import { writeFile, writeFileSync, writeSync } from "fs";

// https://vitejs.dev/config/
export default defineConfig({
	root: ".",
	base:
		process.env.APP_ENV === "development"
			? "/"
			: resolve(__dirname, "/assets/dist/") + "/",

	build: {
		manifest: true,
		outDir: resolve(__dirname, "assets/dist"),
		rollupOptions: {
			input: {
				frontend: "assets/frontend.ts",
				ruleEditor: "assets/rule-editor.ts",
			},
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
	resolve: {
		alias: {
			$el: fileURLToPath(new URL("./assets/lib/elements", import.meta.url)),
		},
	},
	plugins: [
		{
			name: "assetFile",
			config(config){
				//@ts-ignore
				const {host, port } = config.server.hmr
				const env  = process.env.NODE_ENV ?? "development"
				const url = `http://${host}:${port}`

				const fileName = `${dirname(config.build.outDir)}/asset-info.json`
				const contents = JSON.stringify({url, env})
				writeFile(fileName, contents, {encoding:"utf-8"}, (err)=> {
					if(err){
						console.log(err)
					}
				})
			}
		},

		svelte(),
	],
});
