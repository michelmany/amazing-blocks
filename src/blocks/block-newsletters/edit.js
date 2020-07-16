/**
 * EDIT: Newsletter Block.
 */
import { __ } from "@wordpress/i18n";
const { Fragment, useState, useEffect } = wp.element;

const Edit = props => {
	const { className, setAttributes } = props;
	const [posts, setPosts] = useState([]);
	const [settings, setSettings] = useState([]);
	const [loading, setLoading] = useState(false);

	const fetchPosts = () => {
		wp.apiFetch({
			url: `/wp-json/wp/v2/sb-newsletter`
		}).then(response => {
			setPosts(response);
			setAttributes({ posts: response });
			setLoading(false);
		});
	};

	const fetchSettings = () => {
		wp.apiFetch({
			url: `/wp-json/sb/v1/acf/newsletter-options`
		}).then(response => {
			setSettings(response);
			setAttributes({ settings: response });
			fetchPosts();
		});
	};

	useEffect(() => {
		fetchSettings();
		setLoading(true);
	}, []);

	return (
		<Fragment>
			<div className={className}>
				<ul>
					{loading
						? "Loading..."
						: posts.map(newsletter => {
								let btn_link =
									settings.settings.newsletter_item_link == "item_page"
										? newsletter.link
										: newsletter.acf.newsletter_type === "pdf"
										? newsletter.acf.pdf_file.url
										: newsletter.acf.link.url;

								return (
									<li className={`${className}__item`}>
										<a className={`${className}__item-title`} href={btn_link}>
											{newsletter.title.rendered}
										</a>
									</li>
								);
						  })}
				</ul>
			</div>
		</Fragment>
	);
};

export default Edit;
