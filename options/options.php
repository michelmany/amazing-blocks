<?php

/**
 * Load Getting Started styles in the admin
 */
function skinny_blocks_premium_load_admin_scripts() {

	// Getting Started styles.
	wp_register_style( 'skinny-blocks-premium-settings', plugins_url( 'options/options.css', dirname( __FILE__ ) ), false, '1.0.0' );
	wp_enqueue_style( 'skinny-blocks-premium-settings' );
}
add_action( 'admin_enqueue_scripts', 'skinny_blocks_premium_load_admin_scripts' );


/*
==========================================
	Add Plugin Settings Options Page
==========================================
*/

function skinny_blocks_premium_register_menu() {
	add_submenu_page(
		'skinny-blocks',
		'Premium Settings',
		esc_html__( 'Premium Settings', 'skinny-blocks-premium' ),
		'manage_options',
		'skinny-blocks-premium-settings',
		'skinny_blocks_premium_render_premium_settings'
	);
}
add_action( 'admin_menu', 'skinny_blocks_premium_register_menu', 101 );
add_action( 'admin_init', 'skinny_blocks_premium_options_register_settings', 101 );


/**
 * Renders the premium settings.
 */
function skinny_blocks_premium_render_premium_settings() {
	$pages_dir = trailingslashit( dirname( __FILE__ ) ) . 'pages/';
	include $pages_dir . 'premium-settings.php';
}

function skinny_blocks_premium_options_register_settings() {
	register_setting( 'skinny_blocks_premium_options', 'show_newsletter_cpt_accordion' );
	register_setting( 'skinny_blocks_premium_options', 'show_people_listing_cpt_accordion' );
}

