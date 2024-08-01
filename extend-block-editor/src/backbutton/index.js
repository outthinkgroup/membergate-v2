import "./index.css";
import { registerBlockType } from "@wordpress/blocks";
import { Edit, Save } from "./BackButton.js";
import metadata from "./block.json";

/**
 * Every block starts by registering a new block type definition.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-registration/
 */
registerBlockType(metadata.name, {
  attributes: {
    buttonText: { type: "string", default: "&larr; Back" },
		style:{
			default:{
				color:{
					background:"#ffffff",
					text:"#000000"
				}
			}
		}
  },

  supports: {
    color: {
      text: true,
      gradients: true,
      background: true,
    },
  },

  category: metadata.category,
  title: metadata.title,

  edit: Edit,
  save: Save,
});
