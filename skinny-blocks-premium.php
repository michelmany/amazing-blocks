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

// ACF Admin
define( 'ACF_SHOW_ADMIN', true );

// Include Freemius.
if ( ! function_exists( 'sbp_fs' ) ) {
	require_once plugin_dir_path( __FILE__ ) . 'includes/freemius.php';
}

// This IF block will be auto removed from the Free version.
if ( sbp_fs()->is__premium_only() ) {

	if ( sbp_fs()->can_use_premium_code() ) {

		// The class for integrating ACF.
		if ( ! class_exists( 'SB_ACF_Integrate ' ) ) {
			require_once plugin_dir_path( __FILE__ ) . 'includes/class-sb_acf_integrate.php';
			new SB_ACF_Integrate( 'Skinny Blocks Premium', '0.1.0' );
		}

		// Include Post Types.
		require_once plugin_dir_path( __FILE__ ) . 'post-types/register-post-types.php';
	}
}

/**
 * Register the block with WordPress.
 *
 * @author MRKWP
 * @since 0.0.1
 */
function register_block() {

	// Define our assets.
	$editor_script   = 'build/index.js';
	$editor_style    = 'build/editor.css';
	$frontend_style  = 'build/style.css';
	$frontend_script = 'build/frontend.js';

	// Verify we have an editor script.
	if ( ! file_exists( plugin_dir_path( __FILE__ ) . $editor_script ) ) {
		wp_die( esc_html__( 'Whoops! You need to run `npm run build` for the MRKWP Skinny Blocks Premium first.', 'skinny-blocks' ) );
	}

	// Autoload dependencies and version.
	$asset_file = require plugin_dir_path( __FILE__ ) . 'build/index.asset.php';

	// Register editor script.
	wp_register_script(
		'skinny-blocks-premium-editor-script',
		plugins_url( $editor_script, __FILE__ ),
		$asset_file['dependencies'],
		$asset_file['version'],
		true
	);

	// Register editor style.
	if ( file_exists( plugin_dir_path( __FILE__ ) . $editor_style ) ) {
		wp_register_style(
			'skinny-blocks-premium-editor-style',
			plugins_url( $editor_style, __FILE__ ),
			array( 'wp-edit-blocks' ),
			filemtime( plugin_dir_path( __FILE__ ) . $editor_style )
		);
	}

	// Register frontend style.
	if ( file_exists( plugin_dir_path( __FILE__ ) . $frontend_style ) ) {
		wp_register_style(
			'skinny-blocks-premium-style',
			plugins_url( $frontend_style, __FILE__ ),
			array(),
			filemtime( plugin_dir_path( __FILE__ ) . $frontend_style )
		);
	}

	// Register block with WordPress.
	register_block_type(
		'mrkwp/skinny-blocks',
		array(
			'editor_script' => 'skinny-blocks-premium-editor-script',
			'editor_style'  => 'skinny-blocks-premium-editor-style',
			'style'         => 'skinny-blocks-premium-style',
		)
	);

	// Register frontend script.
	if ( file_exists( plugin_dir_path( __FILE__ ) . $frontend_script ) ) {
		wp_enqueue_script(
			'skinny-blocks-premium-frontend-script',
			plugins_url( $frontend_script, __FILE__ ),
			$asset_file['dependencies'],
			$asset_file['version'],
			true
		);
	}
}

// Check if premium before loading hook for register block
if ( sbp_fs()->is__premium_only() ) {
	add_action( 'init', __NAMESPACE__ . '\register_block' );
}

$show_page = get_field( 'newsletter_show_page', 'option' );

if ( ! $show_page ) {

	function redirect_cpt_singular_posts() {
		if ( is_singular( 'sb-newsletter' ) ) {
			wp_safe_redirect( home_url(), 302 );
			exit;
		}
	}
	add_action( 'template_redirect', 'redirect_cpt_singular_posts' );

	function sb_allowed_block_types( $allowed_blocks ) {

		$allowed_blocks = array(
		// 'core/image',
		// 'core/paragraph',
		// 'core/heading',
		// 'core/list',
		);

		if ( 'post' !== $post->post_type && 'page' !== $post->post_type ) {
			$allowed_blocks = array();
		}

		return $allowed_blocks;
	}

	add_filter( 'allowed_block_types', 'sb_allowed_block_types', 10, 2 );
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
	if ( is_admin() ) {
		include_once ABSPATH . '/wp-admin/includes/plugin.php';

		if ( ! is_plugin_active( 'skinny-blocks/skinny-blocks.php' ) ) {
			$error_message = '<p style="font-family:-apple-system,BlinkMacSystemFont,\'Segoe UI\',Roboto,Oxygen-Sans,Ubuntu,Cantarell,\'Helvetica Neue\',sans-serif;font-size: 13px;line-height: 1.5;color:#444;">' . esc_html__( 'This plugin requires ', 'skinny-blocks-premium' ) . '<a href="' . esc_url( 'https://wordpress.org/plugins/skinny-blocks/' ) . '" target="_blank">Skinny Blocks</a>' . esc_html__( ' plugin to be active.', 'skinny-blocks-premium' ) . '</p>';

			die( $error_message );
		}
	}

}
register_activation_hook( __FILE__, 'check_plugin_dependencies' );

