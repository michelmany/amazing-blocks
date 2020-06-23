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
			{posts.map(newsletter => (
				<a href={newsletter.link}>
					<h3>{newsletter.title.rendered}</h3>
				</a>
			))}
		</div>
	);
};

export default Save;
