import { useState, useEffect } from "@wordpress/element";
import ColorPicker from "./ColorPicker.js";
import {
  __experimentalBoxControl as BoxControl,
  __experimentalInputControl as InputControl,
  SelectControl,
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
    <div className="components-panel__body px-1 bg-slate-100 flex flex-col gap-4">
      <h3 className="px-4 text-slate-800 font-bold">Overlay Settings</h3>
      <section className=" flex p-4 flex-col gap-3 bg-white border">
        <p className="text-slate-600 font-medium">Colors</p>
        <div className="flex flex-col gap-3">
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
      <section className="mg-input with-light-border p-4 bg-white border flex flex-col gap-3 ">
        <p className="text-slate-600 font-medium">Size</p>
        <div class="flex flex-col gap-2">
          <InputControl
            label={"Content Max Width"}
						className="hide-select-caret "
            value={maxWidth.value}
            suffix={
              <SelectControl
                value={maxWidth.unit}
                onChange={(v) => setMaxWidth((s) => ({ ...s, unit: v }))}
                className="h-full "
                options={[
                  { label: "px", value: "px" },
                  { label: "rem", value: "rem" },
                  { label: "em", value: "em" },
                  { label: "%", value: "%" },
                ]}
              />
            }
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
        </div>
      </section>
    </div>
  );
}

export default OverlaySettingsPanel;
