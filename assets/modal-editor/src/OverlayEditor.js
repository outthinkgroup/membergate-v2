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
import Notices from "./components/notices";
import Header from "./components/header";
import Sidebar from "./components/Sidebar";
import BlockEditor from "./components/block-editor";
import Footer from "./components/footer";
import { saveOverlaySettings } from "./saveOverlay";

function OverlayEditor({ settings, closeModal }) {
	const [overlaySettings, _setOverlaySettings] = useState({})
	async function setOverlaySettings(settings){
		_setOverlaySettings(settings)
		await saveOverlaySettings(settings)
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
            <div class="overlay-editor-layout">
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
