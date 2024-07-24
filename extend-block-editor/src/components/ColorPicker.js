import { ColorIndicator, ColorPicker, Popover } from "@wordpress/components";
import { useState } from "@wordpress/element";
export default function MyColorPicker({
  color,
  updateColor,
  label,
}) {
	const [anchorEl, setAnchorEl] = useState(null);
  const [isShowingPicker, setIsShowingPicker] = useState(false);

  return (
    <>
      <button
				ref={setAnchorEl}
        onClick={() => setIsShowingPicker((s) => !s)}
        style={{
					minHeight:40,
					textAlign:"left",
          display: "flex",
          alignItems: "center",
          appearance: "none",
          background: "transparent",
          border: "1px solid #ccc",
          gap: ".5rem",
          padding: ".25rem",
          borderRadius: ".25rem",
          width: "100%",
          color: "#363F53",
        }}
      >
				<span style={{width:"max-content", aspectRatio:1}}>
        <ColorIndicator colorValue={color} />
				</span>
        <span>{label}</span>
      </button>
      {isShowingPicker && (
				<Popover
					anchor={anchorEl}
					onFocusOutside={()=>setIsShowingPicker(false)}
					placement="left-start"
					offset={10}
					resize={true}
					shift={true}
					onClose={()=>setIsShowingPicker(false)}
					noArrow={false}
					headerTitle={`Setting ${label}'s Color`}
				>
				<div style={{padding:".25rem",}}>
        <ColorPicker
          color={color}
          onChange={(newColor) => {
            updateColor(newColor);
          }}
        />
				</div>
				</Popover>
      )}
    </>
  );
}
