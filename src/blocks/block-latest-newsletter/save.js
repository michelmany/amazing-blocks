/**
 * SAVE: Latest Newsletter Block
 */
const { getBlockDefaultClassName } = wp.blocks;
const { InnerBlocks, PlainText } = wp.blockEditor;

const Save = props => {
	const {
		attributes: { newsletters, settings, btnLabel }
	} = props;
	const className = getBlockDefaultClassName("skinny-blocks/latest-newsletter");

	return (
		<div className={className}>
			{newsletters.map(newsletter => {
				const DownloadButton = () => {
					const btn_link =
						newsletter.acf.newsletter_type === "pdf"
							? newsletter.acf.pdf_file.url
							: newsletter.acf.link.url;
					return (
						<a href={btn_link} className="btn btn--primary">
							<PlainText.Content tag="p" value={btnLabel} />
						</a>
					);
				};

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
							<InnerBlocks.Content />
							<DownloadButton />
						</div>
					</div>
				);
			})}
		</div>
	);
};

export default Save;
