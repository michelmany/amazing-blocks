/**
 * REGISTER: Button Block.
 */

import { __ } from "@wordpress/i18n";
const { registerBlockType } = wp.blocks;

const { InspectorControls, RichText } = wp.editor;

import ButtonWithLink from "../../components/ButtonWithLink";

registerBlockType("skinny-blocks/button", {
	title: __("Button", "skinny-blocks"),
	icon: "smiley",
	category: "common",
	keywords: [__("Button", "Newsletter", "Latest")],
	supports: {
		align: true
	},

	attributes: {
		align: true,
		buttonText: {
			type: String
		},
		buttonUrl: {
			url: String
		}
	},

	edit(props) {
		const { className, setAttributes } = props;
		const { buttonText, buttonUrl } = props.attributes;

		function updateAttr(key, value) {
			setAttributes({
				[key]: value
			});
		}

		return [
			<InspectorControls>
				<div style={{ padding: "1em 0" }}>Options</div>
			</InspectorControls>,
			<div className={className}>
				<ButtonWithLink
					text={buttonText}
					url={buttonUrl}
					onButtonTextChange={val => updateAttr("buttonText", val)}
					onURLChange={val => updateAttr("buttonUrl", val)}
				/>
			</div>
		];
	},

	save(props) {
		// const className = getBlockDefaultClassName('test/button-example'); // For use with say, BEM
		const { buttonText, buttonUrl } = props.attributes;

		return (
			<div>
				<ButtonWithLink.View text={buttonText} url={buttonUrl} />
			</div>
		);
	}
});
