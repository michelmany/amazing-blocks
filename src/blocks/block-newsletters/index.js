/**
 * REGISTER: Newsletter Block.
 */
import edit from "./edit";
import save from "./save";

import { __ } from "@wordpress/i18n";
import { registerBlockType } from "@wordpress/blocks";

registerBlockType("skinny-blocks/newsletters", {
	title: __("Newsletters", "skinny-blocks"),
	icon: "edit",
	category: "common",
	keywords: [__("Newsletters", "skinny-blocks", "Listing")],
	attributes: {
		posts: {
			type: "array",
			default: []
		},
		settings: {
			type: "array",
			default: []
		}
	},

	edit,

	save: () => {
		return null;
	}
});
