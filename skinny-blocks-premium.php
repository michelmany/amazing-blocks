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

// Include Freemius.
if ( ! function_exists( 'sbp_fs' ) ) {
	require_once plugin_dir_path( __FILE__ ) . 'includes/freemius.php';
}
// Include the ACF plugin.
require_once plugin_dir_path( __FILE__ ) . 'includes/acf/acf.php';

// Include Post Types.
require_once plugin_dir_path( __FILE__ ) . 'post-types/register-post-types.php';


/**
 * TODO:
 * Create Dependency Check
 * Create a class-skinny-blocks for this plugin.
*/

