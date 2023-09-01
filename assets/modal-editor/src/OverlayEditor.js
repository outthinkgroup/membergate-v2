/**
 * WordPress dependencies
 */
import {
  Popover,
  SlotFillProvider,
  FocusReturnProvider,
} from "@wordpress/components";

import { StrictMode, useEffect, useState } from "@wordpress/element";
// import { FullscreenMode, InterfaceSkeleton } from '@wordpress/interface';
import { ShortcutProvider } from "@wordpress/keyboard-shortcuts";

/**
 * Internal dependencies
 */
import Notices from "./components/notices.js";
import Header from "./components/header.js";
import Sidebar from "./components/Sidebar.js";
import BlockEditor from "./components/block-editor.js";
import Footer from "./components/footer.js";

function OverlayEditor({ settings, closeModal }) {
	const [overlaySettings, _setOverlaySettings] = useState({})
	async function setOverlaySettings(settings){
		_setOverlaySettings(settings)
		window.initialOverlaySettings = settings
	}
	useEffect(()=>{
		_setOverlaySettings(window.initialOverlaySettings)
	},[])

  return (
    <>
      <StrictMode>
        <ShortcutProvider>
          <SlotFillProvider>
            <div class="overlay-editor-layout p-5">
              <Header closeAction={closeModal} />
              <Sidebar modalSettings={overlaySettings} setModalSettings={setOverlaySettings} />
              <Notices />
              <BlockEditor settings={settings} />
							<Footer />
            </div>
            <Popover.Slot />
          </SlotFillProvider>
        </ShortcutProvider>
      </StrictMode>
    </>
  );
}

export default OverlayEditor;
