<?php
/**
 * The public-facing functionality of the plugin.
 *
 * @package    WTVBO_Variation_Bulk_Order
 * @subpackage WTVBO_Variation_Bulk_Order/public
 * @author     Webby Template <support@webbytemplate.com>
 */
class WTVBO_Variation_Bulk_Order_Ajax_Functions {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0 
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    		The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

		add_action( "wp_ajax_wtvbo_variation_bulk_order_add_to_cart", array( $this, "wtvbo_variation_bulk_order_add_to_cart" ) );
		add_action( "wp_ajax_nopriv_wtvbo_variation_bulk_order_add_to_cart", array( $this, "wtvbo_variation_bulk_order_add_to_cart" ) );

	}	

	/**
	 * Get cart items quantities 
	 *
	 * @since  1.0.0
	 */
	public function wtvbo_cart_item_quantities() {
		$quantities = array();

		foreach ( WC()->cart->get_cart() as $cart_item_key => $values ) {
			$product = $values['data'];
			$quantities[ $product->get_stock_managed_by_id() ] = isset( $quantities[ $product->get_stock_managed_by_id() ] ) ? $quantities[ $product->get_stock_managed_by_id() ] + $values['quantity'] : $values['quantity'];
		}

		return $quantities;
	}

	/**
	 * WT variation bulk order Add To cart validation Function.
	 *
	 * @since    1.0.0
	 */
	public function wtvbo_variation_bulk_order_add_to_cart_validation( $product_id, $variation_id, $wt_quantity ) {
		
		$product_data = wc_get_product( $variation_id ? $variation_id : $product_id );
		$quantity = empty( $wt_quantity ) ? 1 : wc_stock_amount( wp_unslash( $wt_quantity ) );
		$passed_validation = apply_filters( 'woocommerce_add_to_cart_validation', true, $product_id, $quantity );
		if( $variation_id ){
			$passed_validation = apply_filters( 'woocommerce_add_to_cart_validation', true, $variation_id, $quantity );
		}
		$product_status = get_post_status( $product_id );
		$variation = array();
		$stock_quantity  = $product_data->get_stock_quantity();
		$product_name = $product_data->get_name();
		$products_qty_in_cart = $this->wtvbo_cart_item_quantities();	

		if ( $passed_validation && false !== WC()->cart->add_to_cart( $product_id, $quantity, $variation_id ) ) {

			$data = array(
				'success'  => true,
				'cart_url' => wp_kses_post( 'Your items <strong>'. $product_name .'</strong> where successfully added to your shopping cart' ),
			);

		} else {
			
			$message = '';
			ob_start();			
			wc_print_notices();
			$message .= ob_get_clean();

			$data = array(
				'error'       => true,	
				'error_msg'   => $message,
			);

		}

		return $data;

	}

	/**
	 * Cart Data the sanitize callback
	 *
	 * @since      	1.0.0
	 * @access   	public
	 * @param      	string    $plugin_name      The name of this plugin.
	 * @param      	string    $version    		The version of this plugin.
	 */
	public function wtvbo_cart_data_sanitize_callback($value) {
		if ( is_array( $value ) ) {
        	// If the value is an array, recursively sanitize it
			$value = array_map( array( $this, 'wtvbo_cart_data_sanitize_callback' ), $value );
		} else {
        	// Sanitize the value using sanitize_text_field()
			$value = sanitize_text_field( $value );
		}
		return $value;
	}


	/**
	 * Get all variation bulk order add to cart ajax callback.
	 *
	 * @since    1.0.0
	 */
	public function wtvbo_variation_bulk_order_add_to_cart() {

		if ( isset( $_POST['wqatcType'] ) && wp_verify_nonce( sanitize_text_field ( wp_unslash( $_POST['wqatcType'] ) ), 'wqatcaddcart' ) ) {

		/*
		* In $_POST['wt_cart_data'] We have store data as array format
		* We also sanitize data using wtvbo_cart_data_sanitize_callback function
		*/
		$wt_cart_data = isset( $_POST['wt_cart_data'] ) ? wp_unslash( $_POST['wt_cart_data'] ) : array();
		$wt_cart_data = array_map( array( $this, 'wtvbo_cart_data_sanitize_callback' ), $wt_cart_data );
		$data_arr = array();

		if( !empty( $wt_cart_data ) && is_array( $wt_cart_data ) ){
			foreach( $wt_cart_data as $wt_data ) {

				$product_id = isset( $wt_data['wt_pro_id'] ) ? $wt_data['wt_pro_id'] : '';
				$variation_id = isset( $wt_data['wt_var_id'] ) ? $wt_data['wt_var_id'] : '';
				$wt_quantity = isset( $wt_data['wt_quantity'] ) ? $wt_data['wt_quantity'] : '';

				if( !empty( $product_id ) && !empty( $wt_quantity ) && !empty(  $variation_id ) ){
					$data_arr[] = $this->wtvbo_variation_bulk_order_add_to_cart_validation( $product_id, $variation_id, $wt_quantity );
				}
			}
		}
	}

	wp_send_json( $data_arr );
}

}