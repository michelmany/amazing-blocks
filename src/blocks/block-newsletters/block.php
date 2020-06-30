<?php

sbp_register_dynamic_block(
	'newsletters',
	array(
		'render_callback' => 'sbp_render_newsletters_block',
		'attributes'      => array(
			'posts'    => array(
				'type'    => 'string',
				'default' => array(),
			),
			'settings' => array(
				'type'    => 'array',
				'default' => array(),
			),
		),
	)
);

function sbp_render_newsletters_block( $attributes ) {

	$link_page = get_field( 'newsletter_item_link', 'option' ) === 'item_page' ? true : false;
	$qty_posts = get_field( 'newsletter_how_many_posts', 'option' );

	$newsletters = get_posts(
		array(
			'post_type'   => 'sb-newsletter',
			'numberposts' => $qty_posts,
		)
	);

	$output .= '<ul>';

	foreach ( $newsletters as $key => $newsletter ) {
		$newsletter_type = get_field( 'newsletter_type', $newsletter->ID );
		$pdf_file        = get_field( 'pdf_file', $newsletter->ID );
		$link            = get_field( 'link', $newsletter->ID );

		$btn_link = $link_page
			? $newsletters->link
			: 'pdf' === $newsletter_type
			? $pdf_file['url']
			: $link->url;

			$output .= '<li class="wp-block-skinny-blocks-latest-newsletter__item">';
			$output .= '<a class="wp-block-skinny-blocks-latest-newsletter__item-title" href="' . $btn_link . '">' . $newsletter->post_title . '</a>';
			$output .= '</li>';
	}

	$output .= '</ul>';

	return $output;
}
