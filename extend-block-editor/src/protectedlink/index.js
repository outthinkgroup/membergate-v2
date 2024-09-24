import "./index.css";
import { registerBlockType, registerBlockVariation } from "@wordpress/blocks";
import { Edit, Save } from "./ProtectedLink.js";
import metadata from "./block.json";

/**
 * Every block starts by registering a new block type definition.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-registration/
 */
registerBlockType(metadata.name, {
  category: metadata.category,
  title: metadata.title,
  edit: Edit,
  save: Save,
});

registerBlockVariation("core/buttons", {
  name: "membergate/protectedbutton",
	title:"Membergate Protected Link",
  attributes: { className: "is-membergate-protect-link" },
  innerBlocks: [["core/button", { text: "Download" }]],
  isActive: (blockAttributes, variationAttributes) =>
    blockAttributes.className === variationAttributes.className,
});
