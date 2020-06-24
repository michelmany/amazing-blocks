/**
 * SAVE: Latest Newsletter Block
 */
import { RichText } from "@wordpress/block-editor";

const Save = props => {
	const {
		attributes: { posts },
		className
	} = props;

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
					button = <a href={newsletter.link}>Download</a>;
				}

				return (
					<div className={`${className}__item`}>
						<h4 style={{ display: "inline-block" }}>
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
				);
			})}
		</div>
	);
};

export default Save;
