<?php
/**
 * Plugin Name:       WT Variation Bulk Order
 * Plugin URI:        https://wt-quick-bulk-order.webbytemplate.com/
 * Description:       A fully featured wt quick reorder plugin that allows to reorder your product that you have ordered previously.It's easy to find your product for reorder.
 * Version:           1.0.0
 * Author:            webbytemplate
 * Author URI:        https://webbytemplate.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wt-variation-bulk-order
 * Requires Plugins: woocommerce
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin name ,version.
 */
define( 'WTVBO_VARIATION_BULK_ORDER_VERSION', '1.0.0' );
define( 'WTVBO_VARIATION_BULK_ORDER_NAME', 'wt-variation-bulk-order' );
define( 'WTVBO_VARIATION_BULK_ORDER_PLUGIN_FILE', __FILE__ );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-activator.php
 */
function initiate_variation_bulk_order() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-activator.php';
	WTVBO_Variation_Bulk_Order_Activator::activate();
}

register_activation_hook( __FILE__, 'initiate_variation_bulk_order' );

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-deactivator.php
 */
function shutoff_variation_bulk_order() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-deactivator.php';
	WTVBO_Variation_Bulk_Order_Deactivator::deactivate();
}

register_deactivation_hook( __FILE__, 'shutoff_variation_bulk_order' );

/**
 * The code load core packages, admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/packages.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */

function install_variation_bulk_order() {

    if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
        $plugin = new WTVBO_Variation_Bulk_Order();
    } else {
        if( is_admin() ) {
            wtvbo_variation_bulk_order_woocommerce_activation_notice();
        }
    }
}

/**
 * Show notice message on admin plugin page.
 *
 * Callback function for admin_notices(action).
 *
 * @since  1.0.0
 * @access public
 */
function wtvbo_variation_bulk_order_woocommerce_activation_notice() {
    ?>
    <div class="error">
        <p>
            <?php echo wp_kses_post( '<strong> WT Variation Bulk Order </strong> requires <a target="_blank" href="https://wordpress.org/plugins/woocommerce/">Woocommerce</a> to be installed & activated!' ); ?>
        </p>
    </div>
    <?php
}

install_variation_bulk_order();