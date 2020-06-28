<?php

// Register Custom Post Type People Listing
function create_people_listing_cpt() {

	$exclude_from_search = ! get_field( 'people_listing_show_in_search', 'option' ) || false;
	$show_page           = get_field( 'people_listing_show_page', 'option' ) || false;
	$show_archive        = get_field( 'people_listing_show_archive', 'option' ) || false;
	$has_alternate_name  = get_field( 'people_listing_alternate_name_check', 'option' );
	$alternate_name      = get_field( 'people_listing_the_alternative_name', 'option' );
	$cpt_name            = $has_alternate_name && ! empty( $alternate_name ) ? $alternate_name : 'People Listing';
	$custom_permalink    = ! empty( get_field( 'people_listing_permalinks', 'option' ) ) ? get_field( 'people_listing_permalinks', 'option' ) : 'newsletters';

	$labels = array(
		'name'                  => $cpt_name,
		'menu_name'             => $cpt_name,
		'name_admin_bar'        => $cpt_name,
		'archives'              => $cpt_name . __( ' Archives', 'sb-people-listing' ),
		'attributes'            => $cpt_name . __( ' Attributes', 'sb-people-listing' ),
		'parent_item_colon'     => __( 'Parent ', 'sb-people-listing' ) . $cpt_name,
		'all_items'             => __( 'All ', 'sb-people-listing' ) . $cpt_name,
		'add_new_item'          => __( 'Add New item', 'sb-people-listing' ),
		'add_new'               => __( 'Add New', 'sb-people-listing' ),
		'new_item'              => __( 'New item', 'sb-people-listing' ),
		'edit_item'             => __( 'Edit item', 'sb-people-listing' ),
		'update_item'           => __( 'Update item', 'sb-people-listing' ),
		'view_item'             => __( 'View item', 'sb-people-listing' ),
		'view_items'            => __( 'View items', 'sb-people-listing' ),
		'search_items'          => __( 'Search item', 'sb-people-listing' ),
		'not_found'             => __( 'Not found', 'sb-people-listing' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'sb-people-listing' ),
		'featured_image'        => __( 'Featured Image', 'sb-people-listing' ),
		'set_featured_image'    => __( 'Set featured image', 'sb-people-listing' ),
		'remove_featured_image' => __( 'Remove featured image', 'sb-people-listing' ),
		'use_featured_image'    => __( 'Use as featured image', 'sb-people-listing' ),
		'insert_into_item'      => __( 'Insert into item', 'sb-people-listing' ),
		'uploaded_to_this_item' => __( 'Uploaded to this People Listing', 'sb-people-listing' ),
		'items_list'            => __( 'Items list', 'sb-people-listing' ),
		'items_list_navigation' => __( 'Items list navigation', 'sb-people-listing' ),
		'filter_items_list'     => __( 'Filter Items list', 'sb-people-listing' ),
	);

	$args = array(
		'label'               => __( 'People Listing', 'sb-people-listing' ),
		'description'         => __( 'People Listing', 'sb-people-listing' ),
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
	);
	register_post_type( 'sb-people-listing', $args );

	if ( (bool) get_option( 'flush_rewrite_rules' ) ) {
		flush_rewrite_rules();
		update_option( 'flush_rewrite_rules', 'false' );
	}
}

if ( (bool) get_option( 'show_people_listing_cpt_accordion' ) ) {
	add_action( 'init', 'create_people_listing_cpt', 20 );
}

$enable_categories = get_field( 'people_listing_categories', 'option' );
$enable_tags       = get_field( 'people_listing_tags', 'option' );

function create_people_listing_category() {
	register_taxonomy(
		'category',
		'sb-people-listing',
		array(
			'label'        => __( 'Categories' ),
			'rewrite'      => array( 'slug' => 'people-listing-category' ),
			'hierarchical' => true,
		)
	);
}

function create_people_listing_tag() {
	register_taxonomy(
		'tag',
		'sb-people-listing',
		array(
			'label'        => __( 'Tags' ),
			'rewrite'      => array( 'slug' => 'people-listing-tag' ),
			'hierarchical' => false,
		)
	);
}

if ( $enable_categories ) {
	add_action( 'init', 'create_people_listing_category' );
}

if ( $enable_tags ) {
	add_action( 'init', 'create_people_listing_tag' );
}
