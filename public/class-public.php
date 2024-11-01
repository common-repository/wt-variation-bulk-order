<?php
/**
 * The public-facing functionality of the plugin.
 *
 * @package    WTVBO_Variation_Bulk_Order
 * @subpackage WTVBO_Variation_Bulk_Order/public
 * @author     Webby Template <support@webbytemplate.com>
 */
class WTVBO_Variation_Bulk_Order_Public {

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
	 * The WT Variation Bulk Order Option Type of this plugin.
	 *
	 * @since    1.0.0
	 * @access   public
	 * @var      string    $quick_order_option_type    The WT Variation Bulk Order Option Type of this plugin.
	 */
	public $quick_order_option_type;

	/**
	 * The WT Variation Bulk Order Option Type of this plugin.
	 *
	 * @since    1.0.0
	 * @access   public
	 * @var      string    $default_table_open    The WT Variation Bulk Order Option Type of this plugin.
	 */
	public $default_table_open;


	/**
	 * The WT Variation Bulk Order Option Type of this plugin.
	 *
	 * @since    1.0.0
	 * @access   public
	 * @var      string    $table_max_height    The WT Variation Bulk Order Option Type of this plugin.
	 */
	public $table_max_height;

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
		$this->quick_order_option_type = wtvbo_get_variation_bulk_order_field( 'quick_order_option_type','general', $this->plugin_name );	
		$this->default_table_open = wtvbo_get_variation_bulk_order_field( 'defult_open_variation_table','general', $this->plugin_name );
		$this->table_max_height = wtvbo_get_variation_bulk_order_field( 'table_max_height','general', $this->plugin_name );

		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_styles' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		wp_enqueue_style( 'wt-font-awesome', plugin_dir_url( __DIR__ ) . '/admin/css/all.min.css', array(), $this->version, 'all' );
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/public.css', array(), $this->version, 'all' );

		$custom_css = "";


		if( $this->quick_order_option_type == 'show_only_order_option' ){
			$custom_css .= "
			.wt-quick-order-main-wrap .variations_form{
				display: none;
			}";
		}

		if( $this->default_table_open == 'yes' ){
			$custom_css .= "
			.wt-order-list .wt-order-table-wrap{
				display: block !important;
			}";
		}

		if( isset( $this->table_max_height['width'] ) && isset( $this->table_max_height['value'] ) ){

			$custom_css .= "
			.wt-order-table-wrap .wt-quick-order-table{
				max-height: ".$this->table_max_height['width']."".$this->table_max_height['value'].";
			}
			.wt-order-table-wrap .wt-quick-order-table thead {
				position: sticky; top: 0;
			}
			.wt-order-table-wrap .wt-quick-order-table tfoot {
				position: sticky; bottom: 0;
			}";
		}

		wp_add_inline_style( $this->plugin_name, $custom_css );
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {
		
		wp_enqueue_script( 'wt-font-awesome', plugin_dir_url( __DIR__ ) . '/admin/js/all.min.js', array( 'jquery' ), $this->version, true );
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/wt-variation-bulk-order-public.js', array( 'jquery' ), $this->version, true );		
		wp_localize_script( $this->plugin_name, 'wtqoAjax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ));
		
	}

	
}