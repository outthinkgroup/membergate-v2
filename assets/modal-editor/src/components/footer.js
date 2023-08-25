import { createSlotFill, Panel, SelectControl } from "@wordpress/components";
import { useState } from "@wordpress/element";
import { __ } from "@wordpress/i18n";
const { Slot: InspectorSlot, Fill: InspectorFill } =
  createSlotFill("WPModalFooter");

function Footer() {
  return (
    <div className="overlay-editor-footer border-t">
      <InspectorSlot bubblesVirtually />
    </div>
  );
}

Footer.InspectorFill = InspectorFill;

export default Footer;
