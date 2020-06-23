<?php

if ( function_exists( 'acf_add_options_page' ) ) {
	acf_add_options_sub_page(
		array(
			'page_title'  => 'Newsletter Settings',
			'menu_title'  => 'Settings',
			'parent_slug' => 'edit.php?post_type=sb-newsletter',
		)
	);
}

/*
	==========================================
	 JSON API to show Advanced Custom Fields
	==========================================
 */
add_filter(
	'rest_prepare_sb-newsletter',
	function( $response ) {
		$response->data['acf'] = get_fields( $response->data['id'] );
		return $response;
	}
);

/*
	==========================================
	 Rest Api Custom Endpoints Newsletter Options
	==========================================
 */
function sb_custom_route_acf_newsletter_options() {
	$newsletter_options = array();
	$newsletter_options['settings']['newsletter_how_many_posts'] = get_field( 'newsletter_how_many_posts', 'options' );
	$newsletter_options['settings']['newsletter_item_link']      = get_field( 'newsletter_item_link', 'options' );
	return $newsletter_options;
}

add_action(
	'rest_api_init',
	function() {
		register_rest_route(
			'sb/v1',
			'acf/newsletter-options',
			array(
				'methods'  => 'GET',
				'callback' => 'sb_custom_route_acf_newsletter_options',
			)
		);
	}
);
