/**
 * REGISTER: Newsletter Block.
 */
import edit from "./edit";
import save from "./save";
const { InnerBlocks } = wp.blockEditor;

import { __ } from "@wordpress/i18n";
import { registerBlockType } from "@wordpress/blocks";

registerBlockType("skinny-blocks/latest-newsletter", {
	title: __("Latest Newsletter", "skinny-blocks"),
	icon: "edit",
	category: "common",
	keywords: [__("Latest Newsletter", "Newsletter", "Latest")],
	attributes: {
		newsletters: {
			type: "array",
			default: []
		},
		settings: {
			type: "array",
			default: []
		},
		btnLabel: {
			type: "string",
			default: "Download"
		}
	},

	edit,

	save: props => <InnerBlocks.Content />
});
