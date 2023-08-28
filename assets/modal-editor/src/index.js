import {render}from "@wordpress/element"
import { registerCoreBlocks } from '@wordpress/block-library';

import OverlayEditor from "./OverlayEditor"

import './styles.css';
registerCoreBlocks();
// Build Dialog Mechanism
window.addEventListener("DOMContentLoaded", createDialogAndReactRoot)
function createDialogAndReactRoot(){
	const rootWrapper = document.querySelector(".overlay-editor-wrapper");
	document.body.addEventListener("click", function(e){
		if(!e.target.matches("#show-overlay-editor")) return

		rootWrapper.dataset.active="true"
		mountEditor(()=>{
			rootWrapper.dataset.active="false"
		})
	})
} 

function mountEditor(closeFn){
	const settings = window.membergate.OverlayEditor.editorSettings
	render(
		<OverlayEditor settings={settings} closeModal={closeFn} />,
		document.querySelector("#overlay-editor-root")
	)
	console.log('hi')
}

