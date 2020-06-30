/**
 * REGISTER: Newsletter Block.
 */
import edit from "./edit";

const { InnerBlocks } = wp.blockEditor;
const { __ } = wp.i18n;
const { registerBlockType } = wp.blocks;

registerBlockType("skinny-blocks/latest-newsletter", {
	title: __("Latest Newsletter", "skinny-blocks"),
	icon: "edit",
	category: "common",
	keywords: [__("Latest Newsletter", "Newsletter", "Latest")],
	attributes: {
		latestNewsletters: {
			type: "array",
			default: []
		},
		settings: {
			type: "array",
			default: []
		}
	},

	edit,

	save: props => <InnerBlocks.Content />
});
