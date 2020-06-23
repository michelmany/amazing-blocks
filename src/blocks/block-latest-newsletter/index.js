/**
 * REGISTER: Newsletter Block.
 */
import edit from "./edit";
import save from "./save";

import { __ } from "@wordpress/i18n";
import { registerBlockType } from "@wordpress/blocks";

registerBlockType("skinny-blocks/latest-newsletter", {
	title: __("Newsletter", "skinny-blocks"),
	icon: "edit",
	category: "common",
	keywords: [__("Newsletter", "skinny-blocks")],
	attributes: {
		content: {
			type: "array",
			source: "children",
			selector: "p"
		}
	},
	edit,
	save
});
