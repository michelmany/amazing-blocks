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

if ( ! function_exists( 'sbp_fs' ) ) {
    // Create a helper function for easy SDK access.
    function sbp_fs() {
        global $sbp_fs;

        if ( ! isset( $sbp_fs ) ) {
            // Include Freemius SDK.
            require_once dirname(__FILE__) . '/freemius/start.php';

            $sbp_fs = fs_dynamic_init( array(
                'id'                  => '6387',
                'slug'                => 'skinny-blocks-premium',
                'type'                => 'plugin',
                'public_key'          => 'pk_eff2da3afd4e2319921cb3d0bb340',
                'is_premium'          => true,
                'is_premium_only'     => true,
                'has_addons'          => false,
                'has_paid_plans'      => true,
                'is_org_compliant'    => false,
                'trial'               => array(
                    'days'               => 14,
                    'is_require_payment' => false,
                ),
                'menu'                => array(
                    'slug'           => 'skinny-blocks',
                    'contact'        => false,
                    'support'        => false,
                ),
                // Set the SDK to work in a sandbox mode (for development & testing).
                // IMPORTANT: MAKE SURE TO REMOVE SECRET KEY BEFORE DEPLOYMENT.
                'secret_key'          => 'sk_;1EBsOIHP(ud?ct0koqDx%Ju^H2o[',
            ) );
        }

        return $sbp_fs;
    }

    // Init Freemius.
    sbp_fs();
    // Signal that SDK was initiated.
    do_action( 'sbp_fs_loaded' );
}
// Include the ACF plugin.
require_once plugin_dir_path( __FILE__ ) . 'includes/acf/acf.php';

// Include the ACF plugin.
require_once plugin_dir_path( __FILE__ ) . 'newsletters/newsletters.php';


/**
 * TODO:
 * Create Dependency Check
 * Create a class-skinny-blocks for this plugin.
*/

