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
				{posts.map(newsletter => (
					<a href={newsletter.link}>
						<h3>{newsletter.title.rendered}</h3>
					</a>
				))}
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
