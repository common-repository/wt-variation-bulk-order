<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
/**
* This function return template name.
*
* @return string
*/

function wtvbo_variation_bulk_get_template( $template_name, $load_once = false, $args = array() ){

	if(dirname( __FILE__ ) ){
		$public_url = explode('public', dirname( __FILE__ ));
	}

	load_template( $public_url[0] . 'public/templates/'.$template_name, $load_once,  $args );
}

/**
* This function return a value of admin setting by name.
*
* @return string
*/

function wtvbo_get_variation_bulk_order_field( $name, $tab, $plugin_name ){

	$option_name = $plugin_name.'-'.$tab;

	$option = get_option($option_name);

	if( $option ){
		if( isset( $option[$name] ) && !empty( $option[$name] ) ){
			return str_replace("\'", "'", $option[$name]);
		}
	}
	return '';
}