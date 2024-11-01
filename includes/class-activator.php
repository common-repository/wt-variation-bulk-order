<?php
/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    WTVBO_Variation_Bulk_Order
 * @subpackage WTVBO_Variation_Bulk_Order/includes
 * @author     Webby Template <support@webbytemplate.com>
 */
class WTVBO_Variation_Bulk_Order_Activator {	

	/**
	 * Activation code here
	 *
	 * @since    1.0.0
	 */
	public static function activate() {

		$admin_bulk_reorder = new WTVBO_Variation_Bulk_Order_Admin( WTVBO_VARIATION_BULK_ORDER_NAME, WTVBO_VARIATION_BULK_ORDER_VERSION );
		$admin_bulk_reorder->reset_plugin_data( false );
		
	}

}