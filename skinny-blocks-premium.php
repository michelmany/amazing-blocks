<?php
/**
 * Plugin Name:     Skinny Blocks Premium
 * Description:     Premium Gutenberg blocks.
 * Version:         0.1.0
 * Author:          MRKWP
 * License:         GPL-2.0-or-later
 * License URI:     https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:     skinny-blocks-premium
 *
 * @package         MRKWP\SkinnyBlocksPremium
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

// Define conts.
define( 'PLUGIN_NAME', 'Skinny Blocks Premium' );
define( 'PLUGIN_VERSION', '0.1.0' );
define( 'ACF_SHOW_ADMIN', true );

register_activation_hook( __FILE__, 'check_plugin_dependencies' );

/**
 * Plugin loader.
 */
function skinny_blocks_loader() {

	if ( ! is_parent_activated() ) {
		return;
	}

	init_freemius();
}

add_action( 'plugins_loaded', 'skinny_blocks_loader' );


/**
 * Check if parent plugin is activated (not necessarly loaded).
 *
 * @return bool
 */
function is_parent_activated() {
	if ( is_admin() ) {
		include_once ABSPATH . '/wp-admin/includes/plugin.php';
		return is_plugin_active( 'skinny-blocks/skinny-blocks.php' );
	}
}

/**
 * Checks if the Skinny Blocks plugin is activated
 *
 * If the Skinny Blocks plugin is not active, then don't allow the
 * activation of this plugin.
 *
 * @since 1.0.0
 */
function check_plugin_dependencies() {
	if ( ! is_parent_activated() ) {
		deactivate_plugins( plugin_basename( __FILE__ ) );

		// Message error + allow back link.
		wp_die( esc_html__( 'Skinny Blocks Premium requires Skinny Blocks Plugin to be installed and activated.' ), esc_html__( 'Error' ), array( 'back_link' => true ) );
	}
}

/**
 * Init Freemius
 */
function init_freemius() {
	if ( ! function_exists( 'sbp_fs' ) ) {
		require_once plugin_dir_path( __FILE__ ) . 'includes/freemius.php';
	}
}

// The class for integrating ACF.
require_once plugin_dir_path( __FILE__ ) . 'includes/class-sb_acf_integrate.php';

// Include Post Types.
require_once plugin_dir_path( __FILE__ ) . 'post-types/register-post-types.php';

// Register blocks.
require_once plugin_dir_path( __FILE__ ) . 'register-blocks.php';






