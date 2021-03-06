/**
 * EDIT: Newsletter Block.
 */
const { __ } = wp.i18n;
const { Fragment, useState, useEffect } = wp.element;
const { InnerBlocks } = wp.blockEditor;
const { select, dispatch } = wp.data;

const Edit = props => {
	const { className, setAttributes, clientId } = props;
	const [latestNewsletter, setLatestNewsletter] = useState([]);
	const [settings, setSettings] = useState([]);
	const [loading, setLoading] = useState(false);

	const allowedBlocks = ["core/paragraph", "core/heading", "core/button"];

	const fetchLatestNewsletter = settings => {
		wp.apiFetch({
			url: `/wp-json/wp/v2/sb-newsletter?per_page=1`
		}).then(res => {
			setLatestNewsletter(res[0]);
			setAttributes({ latestNewsletter: res[0] });
			updateButtonBlockUrl(res[0], settings);
			setLoading(false);
		});
	};

	const fetchSettings = () => {
		wp.apiFetch({
			url: `/wp-json/sb/v1/acf/newsletter-options`
		}).then(response => {
			setSettings(response);
			setAttributes({ settings: response });
			fetchLatestNewsletter(response);
		});
	};

	const updateButtonBlockUrl = (newsletter, settings) => {
		const parent = select("core/block-editor").getBlocksByClientId(clientId)[0];
		const childBlocks = parent.innerBlocks;
		const buttonBlock = childBlocks.filter(
			block => block.name === "core/button"
		);

		let btn_link =
			settings.settings.newsletter_item_link === "item_page"
				? newsletter.link
				: newsletter.acf.newsletter_type === "pdf"
				? newsletter.acf.pdf_file.url
				: newsletter.acf.link.url;

		dispatch("core/block-editor").updateBlockAttributes(
			buttonBlock[0].clientId,
			{ url: btn_link }
		);
	};

	useEffect(() => {
		fetchSettings();
		setLoading(true);
	}, []);

	return (
		<Fragment>
			{loading ? (
				"Loading..."
			) : (
				<div className={className}>
					<div className={`${className}__item`}>
						{settings.settings && settings.settings.newsletter_add_image && (
							<div className={`${className}__item-image`}>
								{latestNewsletter.acf.newsletter_image && (
									<img
										src={
											latestNewsletter.acf.newsletter_image.sizes.medium_large
										}
									/>
								)}
							</div>
						)}

						<div className={`${className}__item-content`}>
							<InnerBlocks
								allowedBlocks={allowedBlocks}
								template={[
									[
										"core/heading",
										{ placeholder: __("Enter title...", "skinny-blocks") }
									],
									[
										"core/paragraph",
										{
											placeholder: __("Enter side content...", "skinny-blocks")
										}
									],
									[
										"core/button",
										{
											placeholder: __("Button label", "skinny-blocks"),
											align: "left"
										}
									]
								]}
								templateLock={true}
							/>
						</div>
					</div>
				</div>
			)}
		</Fragment>
	);
};

export default Edit;
