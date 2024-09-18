import "./styles/rule-editor.css";
import "./tailwind.css";
import Dashboard from "./lib/Dashboard/app.svelte"


const rootEl = document.querySelector<HTMLDivElement>('#svelte-root')

const app = new Dashboard({
	target: rootEl,
	props: JSON.parse(rootEl.dataset.pageData),
});
