import { useState, useEffect } from "@wordpress/element";

function size(value, unit) {
  return { value, unit };
}
function sizeToCss(size) {
  return `${size.value}${size.unit}`;
}
function OverlaySettingsPanel({}) {
  const [bgColor, setBgColor] = useState("");
  const [textColor, setTextColor] = useState("");
  const [maxWidth, setMaxWidth] = useState(size(900, "px"));
  const [padding, setPadding] = useState({
    top: size(0, "px"),
    right: size(0, "px"),
    bottom: size(0, "px"),
    left: size(0, "px"),
  });

  useEffect(() => {
    const initialOverlaySettings =
      window.membergate.OverlayEditor.overlaySettings;
    setBgColor(initialOverlaySettings.bgColor);
    setTextColor(initialOverlaySettings.textColor);
    setMaxWidth(initialOverlaySettings.maxWidth);
		setPadding(initialOverlaySettings.padding);
  }, []);

  useEffect(() => {
    window.membergate.OverlayEditor.overlaySettings.bgColor = bgColor;
    document
      .querySelector("#overlay-editor-root")
      .style.setProperty("--bgColor", bgColor);
  }, [bgColor]);
  useEffect(() => {
    window.membergate.OverlayEditor.overlaySettings.textColor = textColor;
    document
      .querySelector("#overlay-editor-root")
      .style.setProperty("--textColor", textColor);
  }, [textColor]);
  useEffect(() => {
    window.membergate.OverlayEditor.overlaySettings.maxWidth = maxWidth;
    document
      .querySelector("#overlay-editor-root")
      .style.setProperty("--maxWidth", sizeToCss(maxWidth));
  }, [maxWidth]);
  useEffect(() => {
    window.membergate.OverlayEditor.overlaySettings.padding = padding;
    document
      .querySelector("#overlay-editor-root")
      .style.setProperty("--overlayPadding", `${sizeToCss(padding.top)} ${sizeToCss(padding.right)} ${sizeToCss(padding.bottom)} ${sizeToCss(padding.left)}`);
  }, [padding]);

  return (
    <div class="components-panel__body">
      <h3>Overlay Settings</h3>
      <div>
        <label>Background Color</label>
        <input
          type="color"
          value={bgColor}
          onChange={(e) => setBgColor(e.target.value)}
        />
      </div>
      <div>
        <label>Text Color</label>
        <input
          type="color"
          value={textColor}
          onChange={(e) => setTextColor(e.target.value)}
        />
      </div>
    </div>
  );
}

export default OverlaySettingsPanel;
