<?php

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

add_action(
	'sbp_fs_loaded',
	function() {
		if ( sbp_fs()->is__premium_only() ) {
			if ( sbp_fs()->can_use_premium_code() ) {
				add_action( 'init', __NAMESPACE__ . '\register_block' );
			}
		}
	}
);
