<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly 
$wt_flag = 0;
$variation_attr = isset( $args['variation_attr'] ) ? $args['variation_attr'] : array();
$product_id = isset( $args['product_id'] ) ? $args['product_id'] : '';

if( $variation_attr ){
	foreach ( $variation_attr as $variation_id => $variation_value ) {
		if( !empty( $variation_id ) ){
			$wt_flag = 1;
			$args = array( 
				'product_id' => $product_id,
				'variation_id' => $variation_id
			);

			wtvbo_variation_bulk_get_template( 'variation-bulk-order-table/wtvbo-tb-items.php', false, $args ); 
		} 
	}	
}

if( $wt_flag == 0  ){
	wtvbo_variation_bulk_get_template( 'variation-bulk-order-table/wtvbo-tb-body-non.php'); 
}