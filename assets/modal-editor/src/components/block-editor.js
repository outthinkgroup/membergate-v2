import "@wordpress/editor"; // This shouldn't be necessary
import "@wordpress/format-library";
import { useSelect, useDispatch } from "@wordpress/data";
import { useEffect, useState, useMemo } from "@wordpress/element";
import {  parse } from "@wordpress/blocks";
import { uploadMedia } from "@wordpress/media-utils";

import {
  BlockBreadcrumb,
  BlockEditorKeyboardShortcuts,
  BlockEditorProvider,
  BlockList,
  BlockTools,
  BlockInspector,
  WritingFlow,
  ObserveTyping,
} from "@wordpress/block-editor";

/**
 * Internal dependencies
 */
import Sidebar from "./Sidebar.js";
//import { saveModal } from "../saveModal";
import Footer from "./footer.js";

function BlockEditor({ settings: _settings }) {


  const [blocks, updateBlocks] = useState([]);
  const { createInfoNotice } = useDispatch("core/notices");

  const canUserCreateMedia = useSelect((select) => {
    const _canUserCreateMedia = select("core").canUser("create", "media");
    return _canUserCreateMedia || _canUserCreateMedia !== false;
  }, []);



  const settings = useMemo(() => {
    if (!canUserCreateMedia) {
      return _settings;
    }
    return {
      ..._settings,
      mediaUpload({ onError, ...rest }) {
        uploadMedia({
          wpAllowedMimeTypes: _settings.allowedMimeTypes,
          onError: ({ message }) => onError(message),
          ...rest,
        });
      },
    };
  }, [canUserCreateMedia, _settings]);

  useEffect(() => {
    const storedBlocks = window.membergate.OverlayEditor.blocks;
		console.log(storedBlocks)

    if (storedBlocks?.length) {
      handleUpdateBlocks(() => parse(storedBlocks));
      createInfoNotice("Blocks loaded", {
        type: "snackbar",
        isDismissible: true,
      });
    }
  }, []);


  /**
   * Wrapper for updating blocks. Required as `onInput` callback passed to
   * `BlockEditorProvider` is now called with more than 1 argument. Therefore
   * attempting to setState directly via `updateBlocks` will trigger an error
   * in React.
   *
   * @param  blocks
   * @param  _blocks
   */
  function handleUpdateBlocks(_blocks) {
    updateBlocks(_blocks);
		if(typeof _blocks == "function"){
			window.membergate.OverlayEditor.blockObjects = _blocks()
		}else{
			window.membergate.OverlayEditor.blockObjects = _blocks
		}
  }

  async function handlePersistBlocks(newBlocks) {
    updateBlocks(newBlocks);
		window.membergate.OverlayEditor.blockObjects = newBlocks
  }

  return (
    <div className="overlay-editor-blocks z-50 border-r" style={{background:"var(--bgColor, white)", color:"var(--textColor,black)", padding:"var(--overlayPadding)"}}>
      <BlockEditorProvider
        value={blocks}
        onInput={handleUpdateBlocks}
        onChange={handlePersistBlocks}
        settings={settings}
      >
        <Sidebar.InspectorFill>
          <BlockInspector showNoBlockSelectedMessage={false} />
        </Sidebar.InspectorFill>
        <div className="editor-styles-wrapper  bg-inherit">
          <BlockEditorKeyboardShortcuts.Register />
          <BlockTools>
            <WritingFlow>
              <ObserveTyping>
                <BlockList className="overlay-block-list overflow-x-auto px-1 text-inherit mx-auto max-w-[var(--maxWidth)]"  />
              </ObserveTyping>
            </WritingFlow>
          </BlockTools>
        </div>
				<Footer.InspectorFill>
					<BlockBreadcrumb />
				</Footer.InspectorFill>
      </BlockEditorProvider>
    </div>
  );
}

export default BlockEditor;
