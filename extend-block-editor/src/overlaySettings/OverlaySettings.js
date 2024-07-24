import { useEffect, useCallback } from "@wordpress/element";
import { __experimentalNumberControl as NumberControl } from "@wordpress/components";
import { compose } from "@wordpress/compose";
import { withSelect, withDispatch } from "@wordpress/data";
import { PluginDocumentSettingPanel } from "@wordpress/editor";
import MyColorPicker from "../components/ColorPicker.js";
import { updateCSSVars } from "./utils.js";

function OverlaySettings({ meta, setMeta }) {
  const { membergate_overlay_settings: settings } = meta;

  const setSettings = useCallback(
    (key, value) => {
      setMeta(
        {
          ...settings,
          [key]: value,
        },
        "membergate_overlay_settings",
      );
    },
    [settings],
  );

  useEffect(() => {
    updateCSSVars(settings);
  }, [settings]);

  return (
    <PluginDocumentSettingPanel
      className="membergate-overlay-settings"
      title="Overlay Settings"
      name="overlay-settings"
      isOpen={true}
    >
      {settings && (
        <div>
          {Object.entries(settings).map(([key, value]) => {
            if (key === "padding") return null;
            if (key.includes("Color")) {
              return (
                <MyColorPicker
                  color={value}
                  updateColor={(newColor) => setSettings(key, newColor)}
                  label={key}
                />
              );
            }
            return (
              <div>
                <NumberControl
                  value={value.split("px")[0]}
                  onChange={(newValue) => setSettings(key, newValue.toString() + "px")}
                  label={key}
                />
              </div>
            );
          })}
        </div>
      )}
    </PluginDocumentSettingPanel>
  );
}
export default compose(
  withSelect((select) => {
    const postMeta = select("core/editor").getEditedPostAttribute("meta");
    const oldPostMeta = select("core/editor").getCurrentPostAttribute("meta");
    return {
      meta: { ...oldPostMeta, ...postMeta },
    };
  }),
  withDispatch((dispatch) => ({
    setMeta: (value, field) =>
      dispatch("core/editor").editPost({ meta: { [field]: value } }),
  })),
)(OverlaySettings);
