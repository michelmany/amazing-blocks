/**
 * EDIT: Newsletter Block.
 */
import { __ } from "@wordpress/i18n";
const { Fragment, useState, useEffect } = wp.element;
const { Button } = wp.components;
const { InnerBlocks, RichText } = wp.blockEditor;

const Edit = props => {
	const { className, setAttributes, attributes } = props;
	const [newsletters, setNewsletters] = useState([]);
	const [settings, setSettings] = useState([]);

	const allowedBlocks = ["core/paragraph", "core/heading"];
	const template = [
		["core/heading", { placeholder: "Enter title..." }],
		["core/paragraph", { placeholder: "Enter side content..." }]
	];

	const fetchLatestNewsletter = () => {
		wp.apiFetch({
			url: `/wp-json/wp/v2/sb-newsletter?per_page=1`
		}).then(response => {
			setNewsletters(response);
			setAttributes({ newsletters: response });
		});
	};

	const fetchSettings = () => {
		wp.apiFetch({
			url: `/wp-json/sb/v1/acf/newsletter-options`
		}).then(response => {
			setSettings(response);
			setAttributes({ settings: response });
		});
	};

	useEffect(() => {
		fetchLatestNewsletter();
		fetchSettings();
	}, []);

	// Update field content on change.
	const onChangeContent = newContent => {
		setAttributes({ content: newContent });
	};

	return (
		<Fragment>
			<div className={className}>
				{newsletters.map(newsletter => {
					return (
						<div className={`${className}__item`}>
							{settings.settings && settings.settings.newsletter_add_image && (
								<div className={`${className}__item-image`}>
									{newsletter.acf.newsletter_image && (
										<img
											src={newsletter.acf.newsletter_image.sizes.medium_large}
										/>
									)}
								</div>
							)}

							<div className={`${className}__item-content`}>
								<InnerBlocks
									allowedBlocks={allowedBlocks}
									template={template}
								/>
								<div className="btn btn--primary">
									<RichText
										value={attributes.btnLabel}
										onChange={btnLabel => setAttributes({ btnLabel })}
									/>
								</div>
							</div>
						</div>
					);
				})}
			</div>
		</Fragment>
	);
};

export default Edit;
