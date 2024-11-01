<?php
/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    WTVBO_Variation_Bulk_Order
 * @subpackage WTVBO_Variation_Bulk_Order/includes
 * @author     Webby Template <support@webbytemplate.com>
 */
class WTVBO_Variation_Bulk_Order {

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		$this->version = WTVBO_VARIATION_BULK_ORDER_VERSION;
		$this->plugin_name = WTVBO_VARIATION_BULK_ORDER_NAME;
		$this->load_dependencies();
		$this->set_locale();			

		add_filter( 'plugin_action_links_' . plugin_basename( WTVBO_VARIATION_BULK_ORDER_PLUGIN_FILE ), array( $this, 'plugin_setting_link' ) );
	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - WTVBO_Variation_Bulk_Order_i18n. Defines internationalization functionality.
	 * - WTVBO_Variation_Bulk_Order_Admin. Defines all hooks for the admin area.
	 * - WTVBO_Variation_Bulk_Order_Public. Defines all hooks for the public side of the site.
	 *
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {		

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-wtvbo-variation-bulk-order-custom-setting.php';

		/**
		 * The class responsible for defining array of plugin settings.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-setting.php';

		/**
		 * The class responsible for defining all methods that used in the plugin settings.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-field-functions.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-public.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/includes/wtvbo-variation-bulk-order-ajax-functions.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/includes/wtvbo-variation-bulk-order-table-functions.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/templates/wtvbo-variation-bulk-order-table.php';

		$plugin_admin = new WTVBO_Variation_Bulk_Order_Admin( $this->get_plugin_name(), $this->get_version() );
		$plugin_public = new WTVBO_Variation_Bulk_Order_Public( $this->get_plugin_name(), $this->get_version() );

		$WTVBO_Variation_Bulk_Order_Custom_Settings = new WTVBO_Variation_Bulk_Order_Custom_Settings( $this->get_plugin_name(), $this->get_version() );	

		$WTVBO_Variation_Bulk_Order_Ajax_Functions = new WTVBO_Variation_Bulk_Order_Ajax_Functions( $this->get_plugin_name(), $this->get_version() );		
		$WTVBO_Variation_Bulk_Order_Functions = new WTVBO_Variation_Bulk_Order_Functions( $this->get_plugin_name(), $this->get_version() );	

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the WTVBO_Variation_Bulk_Order_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new WTVBO_Variation_Bulk_Order_i18n();

		add_action( 'plugins_loaded', array( $plugin_i18n, 'load_plugin_textdomain' ) );

	}

	/**
	 * Show action links on the plugin screen.
	 *
	 * @param mixed $links Plugin Action links.
	 * @return array
	 */
	public function plugin_setting_link( $links ) {
		$action_links = array(
			'settings' => '<a href="' . admin_url( 'admin.php?page='.$this->plugin_name ) . '">' . esc_html__( 'Settings', 'wt-variation-bulk-order' ) . '</a>',
		);

		return array_merge( $action_links, $links );
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}