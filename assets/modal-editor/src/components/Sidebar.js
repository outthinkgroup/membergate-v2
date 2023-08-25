
import { createSlotFill, Panel, SelectControl } from "@wordpress/components";
import { useState } from "@wordpress/element";
import { __ } from "@wordpress/i18n";
// import ModalSettings from "./ModalSettings"

const { Slot: InspectorSlot, Fill: InspectorFill } = createSlotFill(
  "StandAloneBlockEditorSidebarInspector",
);

function Sidebar({modalSettings, setModalSettings}) {
  const [activeTab, setActiveTab] = useState("Document");
  function setDocumentTab() {
    setActiveTab("Document");
  }
  function setInspectorTab() {
    setActiveTab("Inspector");
  }

  return (
    <div
      className="wp-modal-editor-sidebar"
      role="region"
      aria-label={__("Standalone Block Editor advanced settings.")}
      tabIndex="-1"
    >
      <div className="sidebar-tabs">
        <button className={`${activeTab =="Document" ? 'is-active':''}`} onClick={setDocumentTab}>Document</button>
        <button className={`${activeTab =="Inspector" ? 'is-active':''}`}onClick={setInspectorTab}>Inspector</button>
      </div>
      {activeTab == "Inspector" ? (
        <Panel header={__("⭐ Inspector")}>
          <InspectorSlot bubblesVirtually />
        </Panel>
      ) : (
        <Panel header="Document">
					hi
        </Panel>
      )}
    </div>
  );
}

Sidebar.InspectorFill = InspectorFill;

export default Sidebar;
