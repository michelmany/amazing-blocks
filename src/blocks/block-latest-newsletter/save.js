/**
 * SAVE: Latest Newsletter Block
 */
const { getBlockDefaultClassName } = wp.blocks;
// const { RichText } = wp.blockEditor;

const Save = props => {
	const {
		attributes: { posts }
	} = props;
	const className = getBlockDefaultClassName(
		"skinny-blocks/latest-newsletters"
	);

	console.log(className);

	return (
		<div className={className}>
			{posts.map(newsletter => {
				let button;
				if (newsletter.acf.newsletter_type === "pdf") {
					button = (
						<a href={newsletter.acf.pdf_file.url} download>
							Download PDF
						</a>
					);
				} else {
					button = <a href={newsletter.acf.link.url}>Download</a>;
				}

				return (
					<div className={`${className}__item`}>
						<div className={`${className}__item-image`}>
							{newsletter.acf.newsletter_image && (
								<img src={newsletter.acf.newsletter_image.sizes.medium_large} />
							)}
						</div>

						<div className={`${className}__item-content`}>
							<h4 className={`${className}__item-title`}>
								{newsletter.title.rendered}
							</h4>
							<div>{button}</div>

							{newsletter.acf.contents.length && (
								<ol>
									{newsletter.acf.contents.map(content => (
										<li>{content.item}</li>
									))}
								</ol>
							)}
						</div>
					</div>
				);
			})}
		</div>
	);
};

export default Save;
