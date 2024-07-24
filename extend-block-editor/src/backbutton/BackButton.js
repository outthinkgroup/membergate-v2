import { RichText } from "@wordpress/block-editor";
import { useEffect } from "@wordpress/element";
import {
  InspectorControls,
  useBlockProps,
  withColors,
  __experimentalColorGradientSettingsDropdown as ColorGradientSettingsDropdown,
  __experimentalUseMultipleOriginColorsAndGradients as useMultipleOriginColorsAndGradients,
} from "@wordpress/block-editor";

import {} from "@wordpress/block-editor";
function _Edit({
  attributes,
  setAttributes,
  backgroundColor,
  textColor,
  style,
}) {
	useEffect(() => {
		console.log({attributes});
	},[attributes]);
  const blockProps = useBlockProps({
    ...style,
    "--button-bg-color": backgroundColor.slug
      ? `var(--wp--preset--color--${backgroundColor.slug})`
      : attributes.background,
    "--button-text-color": textColor.slug
      ? `var(--wp--preset--color--${textColor.slug})`
      : attributes.color,
  });

  return (
    <>
        <button {...blockProps}>
          <RichText
            tagName="span"
            className=""
            onChange={(content) => setAttributes({ buttonText: content })}
            value={attributes.buttonText}
          />
        </button>
    </>
  );
}

export const Edit = withColors({
  backgroundColor: "button-bg-color",
  textColor: "button-text-color",
})(_Edit);

export function Save({ attributes }) {
  return (
      <button {...useBlockProps.save()}>
        <span>{attributes.buttonText}</span>
      </button>
  );
}
