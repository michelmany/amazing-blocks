/**
 * EDIT: Newsletter Block.
 */
import { RichText } from "@wordpress/block-editor";
import { __ } from "@wordpress/i18n";
const { Fragment, useState, useEffect } = wp.element;

const Edit = props => {
	const {
		attributes: { content },
		className,
		setAttributes
	} = props;

	const [posts, setPosts] = useState([]);

	const fetchPosts = () => {
		wp.apiFetch({
			url: `/wp-json/wp/v2/sb-newsletter`
		}).then(response => {
			console.log(response);
			setPosts(response);
			setAttributes({ posts: response });
		});
	};

	useEffect(() => {
		fetchPosts();
	}, []);

	// Update field content on change.
	const onChangeContent = newContent => {
		setAttributes({ content: newContent });
	};

	return (
		<Fragment>
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
									<img
										src={newsletter.acf.newsletter_image.sizes.medium_large}
									/>
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
			{/* <RichText
				tagName="p"
				className={className}
				onChange={onChangeContent}
				value={content}
				placeholder={__("Newsletter Block....", "skinny-blocks")}
			/> */}
		</Fragment>
	);
};

export default Edit;
