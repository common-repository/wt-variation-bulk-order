<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
/**
* table content.
*
* @see wtvbo_variation_bulk_order_table_before_content() 
*/

add_action( 'wtvbo_variation_bulk_order_table_before_content','wtvbo_variation_bulk_order_table_before_content', 10 );
/**
* table content.
*
* @see wtvbo_variation_bulk_order_table_before() 
*/

add_action( 'wtvbo_variation_bulk_order_table_before','wtvbo_variation_bulk_order_table_before', 10 );

/**
* table content.
*
* @see wtvbo_variation_bulk_order_table_after() 
*/

add_action( 'wtvbo_variation_bulk_order_table_after','wtvbo_variation_bulk_order_table_after', 10 );

/**
* table content.
*
* @see wtvbo_variation_bulk_order_table_after_content() 
*/

add_action( 'wtvbo_variation_bulk_order_table_after_content','wtvbo_variation_bulk_order_table_after_content', 10 );
