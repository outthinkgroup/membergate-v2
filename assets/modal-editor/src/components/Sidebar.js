import { createSlotFill, Panel, SelectControl } from "@wordpress/components";
import { useState, useEffect } from "@wordpress/element";
import { __ } from "@wordpress/i18n";
import OverlaySettingsPanel from "./OverlaySettingsPanel.js"
// import ModalSettings from "./ModalSettings"

/**
 * @type OverlaySettingsT = {
 * bgColor:string;
 * textColor:string;
 * maxWidth:Size;
 * padding:{
 * 		top:Size;
 * 		right:Size;
 * 		bottom:Size;
 * 		left:Size;
 * 	};
 * 	borderRadius:number;
 * 	}
 **/
const { Slot: InspectorSlot, Fill: InspectorFill } = createSlotFill(
  "MembergateOverlaySidbarInspector",
);
function Sidebar({ modalSettings, setModalSettings, }) {
  const [activeTab, setActiveTab] = useState("Document");

  function setDocumentTab() {
    setActiveTab("Document");
  }
  function setInspectorTab() {
    setActiveTab("Inspector");
  }

  return (
    <div
      className="overlay-editor-sidebar sticky top-12"
      role="region"
      aria-label={__(" Overlay Editor advanced settings.")}
      tabIndex="-1"
    >
      <div className="h-12 flex">
        <button
          className={`${
            activeTab == "Document"
              ? "border-b-cyan-600"
              : "border-b-transparent"
          } flex-1 border-b-2 hover:border-b-cyan-600 hover:bg-slate-50`}
          onClick={setDocumentTab}
        >
          Document
        </button>
        <button
          className={`${
            activeTab == "Inspector"
              ? "border-b-cyan-600"
              : "border-b-transparent"
          } flex-1 border-b-2 hover:border-b-cyan-600 hover:bg-slate-50`}
          onClick={setInspectorTab}
        >
          Inspector
        </button>
      </div>
      {activeTab == "Inspector" ? (
        <Panel header={__("⭐ Inspector")}>
          <InspectorSlot bubblesVirtually />
        </Panel>
      ) : (
        <Panel header="Document" className="border-0">
					<OverlaySettingsPanel  /> 
        </Panel>
      )}
    </div>
  );
}

Sidebar.InspectorFill = InspectorFill;

export default Sidebar;
