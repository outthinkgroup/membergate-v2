import "./styles/rule-editor.css";
import "./tailwind.css";
import RuleEditor from "./lib/RuleEditor/RuleEditor.svelte";

const el = document.createElement("div");
el.classList.add("override", "tailwind");
console.log({el})
document.addEventListener("DOMContentLoaded", function () {
  // //insert Element
  // const parent = document.querySelector<HTMLDivElement>("#wpcontent");
  // parent.insertBefore(
  // 	el,
  // 	document.querySelector<HTMLDivElement>("#wpbody").nextElementSibling
  // );
  // parent.style.setProperty("visibility", "visible");
  //
  // //Set Element Size and position to take up full screen but allowing menus to show
  // const adminBar = document.querySelector("#wpadminbar");
  // el.style.setProperty(
  // 	"min-height",
  // 	`${document.documentElement.offsetHeight}px`
  // );
  // el.style.setProperty("top", `-${el.getBoundingClientRect().top}px`);
  // el.style.setProperty(
  // 	"--topOffest",
  // 	`${adminBar.getBoundingClientRect().height}px`
  // );

  // run svelte app
    const BlockEditor = document.querySelector("#rule-editor-root");
    const app = new RuleEditor({
      target: BlockEditor,
    });
});
