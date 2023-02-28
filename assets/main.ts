import "./tailwind.css";
import MembergateAdmin from "./lib/MembergateAdmin.svelte";

const app = new MembergateAdmin({
  target: document.getElementById("svelte-root"),
  props: {},
});
