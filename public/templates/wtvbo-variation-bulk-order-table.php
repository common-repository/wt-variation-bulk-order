<?php
/**
 * The public-facing functionality of the plugin.
 *
 * @package    WTVBO_Variation_Bulk_Order
 * @subpackage WTVBO_Variation_Bulk_Order/public
 * @author     Webby Template <support@webbytemplate.com>
 */
class WTVBO_Variation_Bulk_Order_Functions {

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
	 * The Enable Disable of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $enable_disable_Plugin  The Enable Disable of this plugin.
	 */
	public $enable_disable_Plugin;

	/**
	 * The Default Table Open of this plugin.
	 *
	 * @since    1.0.0
	 * @access   public
	 * @var      string    $default_table_open    The Default Table Open of this plugin.
	 */
	public $default_table_open;

	/**
	 * The Default Table Open of this plugin.
	 *
	 * @since    1.0.0
	 * @access   public
	 * @var      string    $table_header_logo    The Default Table Open of this plugin.
	 */
	public $table_header_logo;

	/**
	 * The Default Table Open of this plugin.
	 *
	 * @since    1.0.0
	 * @access   public
	 * @var      string    $table_title    The Default Table Open of this plugin.
	 */
	public $table_title;

	/**
	 * The Default Table Open of this plugin.
	 *
	 * @since    1.0.0
	 * @access   public
	 * @var      string    $table_sub_title    The Default Table Open of this plugin.
	 */

	public $table_sub_title;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since     1.0.0
	 * @param     string    $plugin_name       The name of the plugin.
	 * @param     string    $version    		The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

		$this->enable_disable_Plugin = wtvbo_get_variation_bulk_order_field( 'enable_disable_Plugin','general', $this->plugin_name );
		$this->default_table_open = wtvbo_get_variation_bulk_order_field( 'defult_open_variation_table','general', $this->plugin_name );
		$this->table_header_logo = wtvbo_get_variation_bulk_order_field( 'table_header_logo','general', $this->plugin_name );		
		$this->table_title = wtvbo_get_variation_bulk_order_field( 'table_title','general', $this->plugin_name );		
		$this->table_sub_title = wtvbo_get_variation_bulk_order_field( 'table_sub_title','general', $this->plugin_name );		

		if( $this->enable_disable_Plugin == 'yes' ){
			add_action( 'woocommerce_before_add_to_cart_form', array( $this, 'get_wtvbo_variation_bulk_order_before_add_to_cart_functions' ) );
			add_action( 'woocommerce_after_add_to_cart_form', array( $this, 'get_wtvbo_variation_bulk_order_after_add_to_cart_functions' ) );
		}
		
	}	

	/**
	 * Get all woo variation bulk order before add to cart table.
	 *
	 * @since    1.0.0
	 */
	public function get_wtvbo_variation_bulk_order_before_add_to_cart_functions() {

		global $product;

		$variation_active = 0;	

		if( is_object( $product ) && is_product() ){
			if( $product->is_type( 'variable' ) ) {
				$children_ids = $product->get_children();
				$product_id = $product->get_id();
				$wt_flag = 0;
				$variation_attr = array();
				if( $children_ids ){
					foreach( $children_ids as $children_id ) {
						$variation_id = isset( $children_id ) ? $children_id : '';
						$variation_product = wc_get_product( $variation_id );
						$stock_quantity = $variation_product->get_stock_quantity();
						$variation_variations = $variation_product->get_variation_attributes(); 						
						$variation_str = '';

						if( !empty( $variation_variations ) ) {
							$empty_variation = 0;

							foreach( $variation_variations as $variation_value ){
								if( !empty($variation_value) ){
									$variation_str .= $variation_value;
								}else{									
									$empty_variation = 1;									
								}
							}
							if( $empty_variation == 0 ){
								$variation_attr[$variation_id][] = $variation_str;	
							}						
						}
					}

					if( !empty( $variation_attr ) ){

						wtvbo_variation_bulk_get_template( 'variation-bulk-order-table/wtvbo-tb-content.php', false, array( 'variation_attr' => $variation_attr, 'product_id' => $product_id ,'default_table_open' => $this->default_table_open , 'table_header_logo' => $this->table_header_logo, 'table_title' => $this->table_title, 'table_sub_title' => $this->table_sub_title ) );
					}
				}
			}
		}
	}

	/**
	 * Woo variation bulk order after add to cart table end div.
	 *
	 * @since    1.0.0
	 */
	public function get_wtvbo_variation_bulk_order_after_add_to_cart_functions() {
		global $product;
		if( is_object( $product ) && is_product()  ){
			if( $product->is_type( 'variable' ) ) {
				echo '</div>';
			}
		}
	}
}