<?php
/**
 * The navs & panels array for setting page.
 *
 * @package    WTVBO_Variation_Bulk_Order
 * @subpackage WTVBO_Variation_Bulk_Order/admin
 * @author     Webby Template <support@webbytemplate.com>
 */
class WTVBO_Variation_Bulk_Order_Custom_Settings {

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
     * @param      string    $plugin_name       The name of this plugin.
     * @param      string    $version           The version of this plugin.
     */
    public function __construct( $plugin_name, $version ) {

     $this->plugin_name = $plugin_name;
     $this->version = $version;

     add_filter( "wtvbo_variation_bulk_order_settings_nav", array( $this, "add_wtvbo_variation_bulk_order_plugin_nav" ), 10, 1 );
     add_filter( "wtvbo_variation_bulk_order_settings_panel", array( $this, "add_wtvbo_variation_bulk_order_plugin_panel" ), 10, 1 );

   }

    /**
    * This function is return navs array.
    *
    * @since    1.0.0
    * @access   public
    */
    public function add_wtvbo_variation_bulk_order_plugin_nav( $navs ) {

      $navs = array(
        'general' => array(
          'title' => __( 'Settings', 'wt-variation-bulk-order' ),
          'icon' => 'fa-cogs',
          'action' => true
        ),
      );

      return $navs;
    }

    /**
     * This function is return panels array.
     *
     * @since    1.0.0
     * @access   public
     */
    public function add_wtvbo_variation_bulk_order_plugin_panel( $panels ) {

      $panels['general'] = array(
        'title' => __('general', 'wt-variation-bulk-order' ),
        'section' => array(
          array(
            'title' => __('General', 'wt-variation-bulk-order' ),
            'icon' => 'fa-solid fa-braille',
            'fields' => array(
              array(
                'type' => 'switch',
                'name' => 'enable_disable_Plugin',
                'title' => __('Enable/Disable Plugin', 'wt-variation-bulk-order' ),
                'desc' => __( 'Enable/Disable Plugin selection', 'wt-variation-bulk-order' ),
                'field_desc' => __( 'You can disable the wt variation bulk order by turning off this switch.', 'wt-variation-bulk-order' ),
                'default' => 'unable',
              ), 
              array(
                'name' => 'table_header_logo',
                'type' => 'file',
                'title' => __( 'Table Header Logo', 'wt-variation-bulk-order' ),
                'required' => false,
                'multiple' => false
              ),
              array(
                'name' => 'table_title',
                'type' => 'text',
                'title' => __( 'Table Header Title', 'wt-variation-bulk-order' ),
                'field_desc' => __( 'Need a larger amount In Disaply Table Heading.', 'wt-variation-bulk-order' ),
                'default' => __( 'Need a larger amount?', 'wt-variation-bulk-order' ),
                'disabled' => false,
                'readonly' => false,
                'required' => false,
                'icon' => ''                            
              ),
              array(
                'name' => 'table_sub_title',
                'type' => 'text',
                'title' => __( 'Table Header Sub Title', 'wt-variation-bulk-order' ),
                'field_desc' => __( 'Make a quick order In Disaply Table Sub Heading.', 'wt-variation-bulk-order' ),
                'default' => __( 'Make a quick order', 'wt-variation-bulk-order' ),
                'disabled' => false,
                'readonly' => false,
                'required' => false,
                'icon' => ''                            
              ),
              array(
                'name' => 'quick_order_option_type',
                'type' => 'select',
                'title' => __('Variation Bulk Order Option Type', 'wt-variation-bulk-order' ),
                'disabled' => false,
                'readonly' => false,
                'required' => false,
                'value' => 'select',
                'options' => array(
                  'show_only_order_option' => __( ' Show Only Order Option', 'wt-variation-bulk-order' ),
                  'both_option_show' => __( 'Both Option Show', 'wt-variation-bulk-order' ),
                ),
                'default' => 'both_option_show',
                'field_desc' => __( 'You can show Both Option and only order option in variation table.', 'wt-variation-bulk-order' ),
              ),
              array(
                'type' => 'switch',
                'name' => 'defult_open_variation_table',
                'title' => __('Default Open Variation table', 'wt-variation-bulk-order' ),
                'field_desc' => __( 'You can show default open variation table turning unable this switch.', 'wt-variation-bulk-order' ),
                'default' => 'disable',
              ),
              array(
                'name' => 'table_max_height',
                'type' => 'multiple_parameter_inputs',
                'class' => 'parameter_wrapper pixel_valid',
                'title' => __( 'Table Max Height', 'wt-variation-bulk-order' ),
                'attributes' => array(
                  'shortcode_attr' => 'table_max_height',
                ),
                'parameters' => array(
                  array(
                    'type' => 'number',
                    'name' => 'width',
                    'title' => __( 'Width', 'wt-variation-bulk-order' ),
                    'desc' => '',
                    'default' => 500,
                    'min' => 200
                  ),
                  array(
                    'type' => 'select',
                    'title' => __( 'Select', 'wt-variation-bulk-order' ),
                    'name' => 'value',
                    'options' => array(
                      'px' => __( 'PX', 'wt-variation-bulk-order' ),
                    ),
                    'default' => 'PX'
                  )
                )
              ), 
            )
),
)
);

return $panels;

}

}