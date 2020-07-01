<?php

/*
==========================================
	Add Settings Options Page
==========================================
*/

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
	$newsletter_options['settings']['newsletter_add_image']      = get_field( 'newsletter_add_image', 'options' );
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

/*
==========================================
	Show a field depending on the option value
==========================================
*/

add_filter( 'acf/location/rule_types', 'acf_location_rules_types' );

function acf_location_rules_types( $choices ) {
	$choices['Forms']['newsletter_settings'] = 'Newsletter - Add Image';
	return $choices;
}

add_filter( 'acf/location/rule_values/newsletter_settings', 'acf_location_rule_values_newsletter_settings' );

function acf_location_rule_values_newsletter_settings( $choices ) {
	$choices['Yes'] = 1;
	$choices['No']  = 0;
	return $choices;
}

add_filter( 'acf/location/rule_match/newsletter_settings', 'acf_location_rule_match_newsletter_settings', 10, 4 );
function acf_location_rule_match_newsletter_settings( $match, $rule, $options, $field_group ) {
	$value          = get_field( 'newsletter_add_image', 'option' );
	$selected_value = (int) $rule['value'];

	if ( $rule['operator'] == '==' ) {
		$match = ( $value == $selected_value );
	} elseif ( $rule['operator'] == '!=' ) {
		$match = ( $value != $selected_value );
	}

	return $match;
}


/*
==========================================
	Creating Custom Newsletter Archive Page
==========================================
*/

add_filter( 'template_include', 'newsletter_archive_template' );

function newsletter_archive_template( $template ) {
	if ( is_post_type_archive( 'sb-newsletter' ) ) {
		$theme_files     = array( 'archive-sb-newsletter.php', 'skinny-blocks-premium/archive-sb-newsletter.php' );
		$exists_in_theme = locate_template( $theme_files, false );
		if ( $exists_in_theme != '' ) {
			return $exists_in_theme;
		}
		return plugin_dir_path( __FILE__ ) . 'archive-sb-newsletter.php';
	}
	return $template;
}


/*
==========================================
	Limit quantity posts on Archive Page
==========================================
*/

$posts_per_page = get_field( 'newsletter_how_many_posts', 'options' );

function sb_newsletters_query( $query ) {
	if ( ! is_admin()
			&& $query->is_post_type_archive( 'sb-newsletter' )
			&& $query->is_main_query() ) {
					$query->set( 'posts_per_page', $posts_per_page );
	}
}
add_action( 'pre_get_posts', 'sb_newsletters_query' );

/*
==========================================
	"Show Page" field config (disable blocks and redirect single page to)
==========================================
*/

$newsletter_show_page = get_field( 'newsletter_show_page', 'option' );

if ( ! $newsletter_show_page ) {

	function redirect_cpt_singular_posts() {
		if ( is_singular( 'sb-newsletter' ) ) {
			wp_safe_redirect( get_post_type_archive_link( 'sb-newsletter' ), 302 );
			exit;
		}
	}
	add_action( 'template_redirect', 'redirect_cpt_singular_posts' );

	function sb_allowed_block_types( $allowed_blocks, $post ) {
		if ( 'sb-newsletter' === $post->post_type ) {
			return $allowed_blocks = array();
		}

		return $allowed_blocks;
	}

	add_filter( 'allowed_block_types', 'sb_allowed_block_types', 10, 2 );
}

/**
 * When updating permalink field, refresh the rewrite rules
 */
function newsletter_permalinks_flush_rewrite_rules( $value, $page, $field ) {

	if ( 'newsletter_permalinks' === $field['name'] ) {
		$old_value = get_field( 'newsletter_permalinks', $page );

		$new_value = $_POST['acf'][ $field['key'] ];

		if ( $old_value !== $new_value ) {

			update_option( 'flush_rewrite_rules', 'true' );
		}
	}

	return $value;
}
add_filter( 'acf/update_value', 'newsletter_permalinks_flush_rewrite_rules', 10, 3 );


