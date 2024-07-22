import { render } from "@wordpress/element";
import { doFilter } from '@wordpress/hooks';
import { registerCoreBlocks } from "@wordpress/block-library";

import OverlayEditor from "./OverlayEditor.js";

import "./styles.css";
registerCoreBlocks();
// Build Dialog Mechanism
window.addEventListener("DOMContentLoaded", createDialogAndReactRoot);
function createDialogAndReactRoot() {
  const rootWrapper = document.querySelector(".overlay-editor-wrapper");
  document.body.addEventListener("click", function (e) {
    if (!e.target.matches("#show-overlay-editor")) return;

    rootWrapper.dataset.active = "true";
    mountEditor(() => {
      const root = rootWrapper.querySelector("#overlay-editor-root");
      root.classList.add("hiding");
      setTimeout(() => {
				rootWrapper.dataset.active = "false";
        root.classList.remove("hiding");
      }, 400);
    });
  });
}

console.log()
function mountEditor(closeFn) {
  const settings = window.membergate.OverlayEditor.editorSettings;
  render(
    <OverlayEditor  closeModal={closeFn} />,
    document.querySelector("#overlay-editor-root"),
  );
  // console.log("hi");
	
}
