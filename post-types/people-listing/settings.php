<?php

if ( function_exists( 'acf_add_options_page' ) ) {
	acf_add_options_sub_page(
		array(
			'page_title'  => 'People Listing Settings',
			'menu_title'  => 'Settings',
			'menu_slug'   => 'people-listing-settings',
			'parent_slug' => 'edit.php?post_type=sb-people-listing',
		)
	);
}

/*
	==========================================
	 JSON API to show Advanced Custom Fields
	==========================================
 */
add_filter(
	'rest_prepare_sb-people-listing',
	function( $response ) {
		$response->data['acf'] = get_fields( $response->data['id'] );
		return $response;
	}
);

/*
	==========================================
	 Rest Api Custom Endpoints People Listing Options
	==========================================
 */
function sb_custom_route_acf_people_listing_options() {
	$people_listing_options = array();
	$people_listing_options['settings']['people_listing_how_many_posts'] = get_field( 'people_listing_how_many_posts', 'options' );
	$people_listing_options['settings']['people_listing_item_link']      = get_field( 'people_listing_item_link', 'options' );
	$people_listing_options['settings']['people_listing_add_image']      = get_field( 'people_listing_add_image', 'options' );
	return $people_listing_options;
}

add_action(
	'rest_api_init',
	function() {
		register_rest_route(
			'sb/v1',
			'acf/people-listing-options',
			array(
				'methods'  => 'GET',
				'callback' => 'sb_custom_route_acf_people_listing_options',
			)
		);
	}
);



function sb_people_listing_allowed_block_types( $allowed_blocks, $post ) {
	if ( 'sb-people-listing' === $post->post_type ) {
		return $allowed_blocks = array();
	}

	return $allowed_blocks;
}

add_filter( 'allowed_block_types', 'sb_people_listing_allowed_block_types', 10, 2 );


/**
 * When updating permalink field, refresh the rewrite rules
 */
function people_listing_permalinks_flush_rewrite_rules( $value, $page, $field ) {
	if ( 'people_listing_permalinks' === $field['name'] ) {
		$old_value = get_field( 'people_listing_permalinks', $page );

		$new_value = $_POST['acf'][ $field['key'] ];

		if ( $old_value !== $new_value ) {
			update_option( 'flush_rewrite_rules', 'true' );
		}
	}

	return $value;
}
add_filter( 'acf/update_value', 'people_listing_permalinks_flush_rewrite_rules', 10, 3 );
