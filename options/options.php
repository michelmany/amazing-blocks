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

function skinny_blocks_premium_getting_started_menu() {
	add_submenu_page(
		'skinny-blocks',
		'Settings Page',
		esc_html__( 'Settings', 'skinny-blocks' ),
		'manage_options',
		'skinny-blocks-premium-settings',
		'skinny_blocks_premium_render_settings_page'
	);

	add_submenu_page(
		'skinny-blocks',
		'Branding Page',
		esc_html__( 'Branding', 'skinny-blocks' ),
		'manage_options',
		'skinny-blocks-premium-branding',
		'skinny_blocks_premium_render_branding_page'
	);
}
add_action( 'admin_menu', 'skinny_blocks_premium_getting_started_menu', 101 );


/**
 * Renders the plugin settings page.
 */
function skinny_blocks_premium_settings_header() {
	?>
	<div class="settings-header">
		<img
			src="<?php echo plugin_dir_url( __FILE__ ) . 'images/skinny-blocks-logo.png'; ?>"
			class="settings-header__logo">
	</div>
	<?php
}

add_action( 'sbp_fs_header', 'skinny_blocks_premium_settings_header' );
add_action( 'sbp_settings_header', 'skinny_blocks_premium_settings_header' );



/**
 * Renders the plugin settings page.
 */
function skinny_blocks_premium_render_settings_page() {

	$pages_dir = trailingslashit( dirname( __FILE__ ) ) . 'pages/';

	include $pages_dir . 'settings.php';
}

/**
 * Renders the plugin branding page.
 */
function skinny_blocks_premium_render_branding_page() {

	$pages_dir = trailingslashit( dirname( __FILE__ ) ) . 'pages/';

	include $pages_dir . 'branding-page.php';
}

