import {
  Popover,
  Button,
  ColorPicker as WPColorPicker,
  ColorIndicator,
} from "@wordpress/components";
import { useState , useCallback,useRef, useEffect} from "@wordpress/element";
function genId(label){
	return label.replaceAll(' ', '-').toLowerCase()
}
export default function ColorPicker({ color, onChange, label }) {
  const [isPickerShown, setIsPickerShown] = useState(false);
  return (
    <div class="">
      <button
				className="flex gap-2 border rounded px-3 py-2 w-full"
				onClick={()=>setIsPickerShown((s) => !s)}
			>
        <ColorIndicator colorValue={color} />
        <span>{label}</span>
      </button>
      {isPickerShown ? (
        <Popover  >
					<div className="flex justify-between gap-1 items-center">
					<p className="px-1 font-bold">{label}</p>
					<Button className="ml-auto block" onClick={()=>setIsPickerShown(false)}>Close</Button>
				</div>
          <WPColorPicker color={color} onChange={onChange} label={label} />
        </Popover>
      ) : null}
    </div>
  );
}
