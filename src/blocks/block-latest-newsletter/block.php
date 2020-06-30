<?php

sbp_register_dynamic_block(
	'latest-newsletter',
	array(
		'render_callback' => 'sbp_render_latest_newsletter_block',

		'attributes'      => array(
			'latestNewsletters' => array(
				'type'    => 'array',
				'default' => array(),
			),
			'settings'          => array(
				'type'    => 'array',
				'default' => array(),
			),
		),
	)
);

function sbp_render_latest_newsletter_block( $attributes, $content ) {
	$newsletters = get_posts(
		array(
			'post_type'   => 'sb-newsletter',
			'numberposts' => 1,
		)
	);

	$link_page = get_field( 'newsletter_item_link', 'option' ) === 'item_page' ? true : false;

	$add_image        = get_field( 'newsletter_add_image', 'option' );
	$newsletter_image = get_field( 'newsletter_image', $newsletters[0]->ID );

	$output = '<div class="wp-block-skinny-blocks-latest-newsletter__item">';

	if ( $add_image ) :
		$output .= '<div class="wp-block-skinny-blocks-latest-newsletter__item-image">';
		$output .= '<img src="' . $newsletter_image['sizes']['medium_large'] . '">';
		$output .= '</div>';
	endif;

	$output .= '<div class="wp-block-skinny-blocks-latest-newsletter__item-content">';
	$output .= $content;
	$output .= '</div>';

	$output .= '</div>';

	return $output;
}
