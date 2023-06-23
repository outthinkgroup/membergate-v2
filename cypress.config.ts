import { defineConfig } from "cypress";

export default defineConfig({
	projectId: "vmwzzr",
  e2e: {
		experimentalRunAllSpecs: true,
    setupNodeEvents(on, config) {
      // implement node event listeners here
    },

  },
});


