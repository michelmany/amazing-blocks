<?php

// Register Custom Post Type Newsletter
function create_newsletter_cpt() {

	$exclude_from_search = ! get_field( 'newsletter_show_in_search', 'option' );
	$show_page           = get_field( 'newsletter_show_page', 'option' );
	$show_archive        = get_field( 'newsletter_show_archive', 'option' );
	$has_alternate_name  = get_field( 'newsletter_alternate_name_check', 'option' );
	$alternate_name      = get_field( 'newsletter_the_alternative_name', 'option' );
	$cpt_name            = $has_alternate_name && ! empty( $alternate_name ) ? $alternate_name : 'Newsletters';
	$custom_permalink    = ! empty( get_field( 'newsletter_permalinks', 'option' ) ) ? get_field( 'newsletter_permalinks', 'option' ) : 'newsletters';

	$labels = array(
		'name'                  => $cpt_name,
		'menu_name'             => $cpt_name,
		'name_admin_bar'        => $cpt_name,
		'archives'              => $cpt_name . __( ' Archives', 'sb-newsletter' ),
		'attributes'            => $cpt_name . __( ' Attributes', 'sb-newsletter' ),
		'parent_item_colon'     => __( 'Parent ', 'sb-newsletter' ) . $cpt_name,
		'all_items'             => __( 'All ', 'sb-newsletter' ) . $cpt_name,
		'add_new_item'          => __( 'Add New item', 'sb-newsletter' ),
		'add_new'               => __( 'Add New', 'sb-newsletter' ),
		'new_item'              => __( 'New item', 'sb-newsletter' ),
		'edit_item'             => __( 'Edit item', 'sb-newsletter' ),
		'update_item'           => __( 'Update item', 'sb-newsletter' ),
		'view_item'             => __( 'View item', 'sb-newsletter' ),
		'view_items'            => __( 'View items', 'sb-newsletter' ),
		'search_items'          => __( 'Search item', 'sb-newsletter' ),
		'not_found'             => __( 'Not found', 'sb-newsletter' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'sb-newsletter' ),
		'featured_image'        => __( 'Featured Image', 'sb-newsletter' ),
		'set_featured_image'    => __( 'Set featured image', 'sb-newsletter' ),
		'remove_featured_image' => __( 'Remove featured image', 'sb-newsletter' ),
		'use_featured_image'    => __( 'Use as featured image', 'sb-newsletter' ),
		'insert_into_item'      => __( 'Insert into item', 'sb-newsletter' ),
		'uploaded_to_this_item' => __( 'Uploaded to this Newsletter', 'sb-newsletter' ),
		'items_list'            => __( 'Items list', 'sb-newsletter' ),
		'items_list_navigation' => __( 'Items list navigation', 'sb-newsletter' ),
		'filter_items_list'     => __( 'Filter Items list', 'sb-newsletter' ),
	);

	$args = array(
		'label'               => __( 'Newsletter', 'sb-newsletter' ),
		'description'         => __( 'Newsletters', 'sb-newsletter' ),
		'labels'              => $labels,
		'menu_icon'           => 'dashicons-feedback',
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'menu_position'       => 20,
		'show_in_admin_bar'   => true,
		'show_in_nav_menus'   => true,
		'can_export'          => true,
		'has_archive'         => $show_archive,
		'hierarchical'        => false,
		'exclude_from_search' => $exclude_from_search,
		'show_in_rest'        => true,
		'publicly_queryable'  => true,
		'capability_type'     => 'post',
		'rewrite'             => array(
			'slug'       => $custom_permalink,
			'with_front' => false,
		),
		'taxonomies'          => array( 'categories', 'tags' ),
	);
	register_post_type( 'sb-newsletter', $args );

}
add_action( 'init', 'create_newsletter_cpt', 20 );

$enable_categories = get_field( 'newsletter_categories', 'option' );
$enable_tags       = get_field( 'newsletter_tags', 'option' );

function create_newsletter_category() {
	register_taxonomy(
		'category',
		'sb-newsletter',
		array(
			'label'        => __( 'Categories' ),
			'rewrite'      => array( 'slug' => 'newsletter-category' ),
			'hierarchical' => true,
		)
	);
}

function create_newsletter_tag() {
	register_taxonomy(
		'tag',
		'sb-newsletter',
		array(
			'label'        => __( 'Tags' ),
			'rewrite'      => array( 'slug' => 'newsletter-tag' ),
			'hierarchical' => false,
		)
	);
}

if ( $enable_categories ) {
	add_action( 'init', 'create_newsletter_category' );
}

if ( $enable_tags ) {
	add_action( 'init', 'create_newsletter_tag' );
}

