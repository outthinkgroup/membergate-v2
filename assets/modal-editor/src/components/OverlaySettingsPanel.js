import { useState, useEffect } from "@wordpress/element";
import ColorPicker from "./ColorPicker.js";
import {
  __experimentalBoxControl as BoxControl,
  __experimentalInputControl as InputControl,
} from "@wordpress/components";
function size(value, unit) {
  return { value, unit };
}
function sizeToCss(size) {
  return `${size.value}${size.unit}`;
}

function parseBoxControlOutput(output) {
  const regex = /(\d*)(.*)/;
  return Object.entries(output).reduce((acc, [key, value]) => {
    const results = regex.exec(value);
    if (!results || results.length < 3) return acc;
    acc[key] = {
      value: results[1],
      unit: results[2],
    };
    return acc;
  }, {});
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
      .style.setProperty(
        "--overlayPadding",
        `${sizeToCss(padding.top)} ${sizeToCss(padding.right)} ${sizeToCss(
          padding.bottom,
        )} ${sizeToCss(padding.left)}`,
      );
  }, [padding]);

  return (
    <div class="components-panel__body">
      <h3>Overlay Settings</h3>
      <section>
        <p>Colors</p>
        <div class="flex flex-col gap-1">
          <div>
            <ColorPicker
              color={bgColor}
              onChange={setBgColor}
              label={"Background Color"}
            />
          </div>
          <div>
            <ColorPicker
              color={textColor}
              onChange={setTextColor}
              label={"Text Color"}
            />
          </div>
        </div>
      </section>
      <section>
        <InputControl
          label={"Content Max Width"}
          value={maxWidth.value}
          suffix={maxWidth.unit}
          type="number"
          onChange={(v) => setMaxWidth((s) => ({ ...s, value: v }))}
        />
        <BoxControl
          values={Object.keys(padding).reduce((acc, key) => {
            acc[key] = padding[key].value;
            return acc;
          }, {})}
          type={"number"}
          label={"Overlay Padding"}
          onChange={(v) =>
            setPadding((s) => ({ ...s, ...parseBoxControlOutput(v) }))
          }
        />
      </section>
    </div>
  );
}

export default OverlaySettingsPanel;
