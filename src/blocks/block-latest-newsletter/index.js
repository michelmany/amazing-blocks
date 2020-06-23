/**
 * REGISTER: Newsletter Block.
 */
import edit from "./edit";
import save from "./save";

import { __ } from "@wordpress/i18n";
import { registerBlockType } from "@wordpress/blocks";

registerBlockType("skinny-blocks/latest-newsletters", {
	title: __("Latest Newsletters", "skinny-blocks"),
	icon: "edit",
	category: "common",
	keywords: [__("Newsletter", "skinny-blocks", "Latest")],
	attributes: {
		posts: {
			type: "array",
			default: []
		}
	},
	edit,
	save
});
