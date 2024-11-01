<?php
/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    WTVBO_Variation_Bulk_Order
 * @subpackage WTVBO_Variation_Bulk_Order/includes
 * @author     Webby Template <support@webbytemplate.com>
 */
class WTVBO_Variation_Bulk_Order_i18n {

	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain( 'wt-variation-bulk-order', false, dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/' );

	}

}