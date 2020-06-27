const { RichText, URLInputButton } = wp.editor;

const ButtonWithLink = props => {
	return (
		<div>
			<RichText
				className="btn btn--primary"
				value={props.text}
				placeholder="Place your button text here!"
				onChange={props.onButtonTextChange}
			/>
			<URLInputButton url={props.url} onChange={props.onURLChange} />
		</div>
	);
};

ButtonWithLink.View = props => {
	return (
		<div>
			<RichText.Content
				className="btn btn--primary"
				value={props.text}
				tagName="a"
				href={props.url}
			/>
		</div>
	);
};

export default ButtonWithLink;
