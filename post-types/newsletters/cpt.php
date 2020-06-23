<?php

// Register Custom Post Type Newsletter
function create_newsletter_cpt() {

	$labels = array(
		'name' => _x( 'Newsletters', 'Post Type General Name', 'sb-newsletter' ),
		'singular_name' => _x( 'Newsletter', 'Post Type Singular Name', 'sb-newsletter' ),
		'menu_name' => _x( 'Newsletters', 'Admin Menu text', 'sb-newsletter' ),
		'name_admin_bar' => _x( 'Newsletter', 'Add New on Toolbar', 'sb-newsletter' ),
		'archives' => __( 'Newsletter Archives', 'sb-newsletter' ),
		'attributes' => __( 'Newsletter Attributes', 'sb-newsletter' ),
		'parent_item_colon' => __( 'Parent Newsletter:', 'sb-newsletter' ),
		'all_items' => __( 'All Newsletters', 'sb-newsletter' ),
		'add_new_item' => __( 'Add New Newsletter', 'sb-newsletter' ),
		'add_new' => __( 'Add New', 'sb-newsletter' ),
		'new_item' => __( 'New Newsletter', 'sb-newsletter' ),
		'edit_item' => __( 'Edit Newsletter', 'sb-newsletter' ),
		'update_item' => __( 'Update Newsletter', 'sb-newsletter' ),
		'view_item' => __( 'View Newsletter', 'sb-newsletter' ),
		'view_items' => __( 'View Newsletters', 'sb-newsletter' ),
		'search_items' => __( 'Search Newsletter', 'sb-newsletter' ),
		'not_found' => __( 'Not found', 'sb-newsletter' ),
		'not_found_in_trash' => __( 'Not found in Trash', 'sb-newsletter' ),
		'featured_image' => __( 'Featured Image', 'sb-newsletter' ),
		'set_featured_image' => __( 'Set featured image', 'sb-newsletter' ),
		'remove_featured_image' => __( 'Remove featured image', 'sb-newsletter' ),
		'use_featured_image' => __( 'Use as featured image', 'sb-newsletter' ),
		'insert_into_item' => __( 'Insert into Newsletter', 'sb-newsletter' ),
		'uploaded_to_this_item' => __( 'Uploaded to this Newsletter', 'sb-newsletter' ),
		'items_list' => __( 'Newsletters list', 'sb-newsletter' ),
		'items_list_navigation' => __( 'Newsletters list navigation', 'sb-newsletter' ),
		'filter_items_list' => __( 'Filter Newsletters list', 'sb-newsletter' ),
	);
	$args = array(
		'label' => __( 'Newsletter', 'sb-newsletter' ),
		'description' => __( 'Newsletters', 'sb-newsletter' ),
		'labels' => $labels,
		'menu_icon' => 'dashicons-feedback',
		'supports' => array(),
		'taxonomies' => array(),
		'public' => true,
		'show_ui' => true,
		'show_in_menu' => true,
		'menu_position' => 20,
		'show_in_admin_bar' => true,
		'show_in_nav_menus' => true,
		'can_export' => true,
		'has_archive' => true,
		'hierarchical' => false,
		'exclude_from_search' => false,
		'show_in_rest' => true,
		'publicly_queryable' => true,
		'capability_type' => 'post',
	);
	register_post_type( 'sb-newsletter', $args );

}
add_action( 'init', 'create_newsletter_cpt', 0 );