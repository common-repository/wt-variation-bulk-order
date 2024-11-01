<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly 
$wt_quick_class = $wt_quick_style = $wt_quick_table_top = $wt_quick_table_bottom = '';
$variation_attr = isset( $args['variation_attr'] ) ? $args['variation_attr'] : array() ;
$default_table_open = isset( $args['default_table_open'] ) ? $args['default_table_open'] : '';
$product_id = isset( $args['product_id'] ) ? $args['product_id'] : '';
$table_header_logo = isset( $args['table_header_logo'] ) ? $args['table_header_logo'] : '';
$table_title = isset( $args['table_title'] ) ? $args['table_title'] : '';
$table_sub_title = isset( $args['table_sub_title'] ) ? $args['table_sub_title'] : '';

if( $default_table_open == 'yes' ){
	$wt_quick_class = 'active off_table';
}
?>

<div class="wt-quick-order-main-wrap"> 	
	<div class="wt-quick-order-wrap">
		<?php 
		/**
		* wtvbo_variation_bulk_order_table_before_content hook.		 
		*/
		do_action( 'wtvbo_variation_bulk_order_table_before_content' );
		?>
		<ul class="wt-order-list">
			<li>
				<div class="<?php echo esc_attr( 'wt-order-header '.$wt_quick_class ); ?>">
					<div class="wt-order-image">
						<?php 
						if( $table_header_logo ){
							echo '<img src="'. esc_url( wp_get_attachment_url( $table_header_logo ) ) .'">';
						}
						?>
					</div>
					<div class="wt-order-heading">
						<span><?php echo esc_html( $table_title ); ?></span>
						<h3><?php echo esc_html( $table_sub_title ); ?></h3>
					</div>
				</div>
				<div class="<?php echo esc_attr( 'wt-order-table-wrap '.$wt_quick_class ); ?>">
					<form class="wt-quick-variations-form wt-cart"  action="" method="post" enctype="multipart/form-data">
					<?php 
					/**
					* wtvbo_variation_bulk_order_table_before hook.		 
					*/
					do_action( 'wtvbo_variation_bulk_order_table_before' );
					?>
					<table class="wt-quick-order-table" id="wt-quick-order-table">
						<thead style="<?php echo esc_attr( $wt_quick_table_top ); ?>">
							<tr>
								<th role="wt-quick-order-col"><?php esc_html_e( 'Variant', 'wt-variation-bulk-order' ); ?></th>
								<th role="wt-quick-order-col"><?php esc_html_e( 'Price', 'wt-variation-bulk-order' ); ?></th>
								<th role="wt-quick-order-col"><?php esc_html_e( 'Qty', 'wt-variation-bulk-order' ); ?></th>
								<th role="wt-quick-order-col"><?php esc_html_e( 'Subtotal', 'wt-variation-bulk-order' ); ?></th>
							</tr>
						</thead>
						<tbody>
							<?php wtvbo_variation_bulk_get_template( 'variation-bulk-order-table/wtvbo-tb-body.php', false, array( 'variation_attr' => $variation_attr, 'product_id' => $product_id ) ); ?>
						</tbody>
						<?php if( !empty( $variation_attr ) ) { ?>
							<tfoot>
								<tr class="wt-subtotals">
									<td data-title="<?php esc_html_e( 'Variant', 'wt-variation-bulk-order' ); ?>" colspan="2" ><?php esc_html_e( 'Total', 'wt-variation-bulk-order' ); ?></td>
									<td data-title="<?php esc_html_e( 'Total Qty', 'wt-variation-bulk-order' ); ?>" class="wt-order-total-qty"><?php esc_html_e( '0', 'wt-variation-bulk-order' ); ?></td>
									<td data-title="<?php esc_html_e( 'Total', 'wt-variation-bulk-order' ); ?>" class="wt-order-tolal-price">
										<span class="wt-order-currency"><?php echo esc_html( get_woocommerce_currency_symbol() ); ?></span>
										<span class="wt-order-total"><?php esc_html_e( '0.00', 'wt-variation-bulk-order' ); ?></span>
									</td>
								</tr>
							</tfoot>
						<?php } ?>
					</table>
					<?php
					/**
					* wtvbo_variation_bulk_order_table_after hook.		 
					*/
					do_action( 'wtvbo_variation_bulk_order_table_after' );
					?>
					<?php if( !empty( $variation_attr ) ) { ?>
						<div class="wt-quick-order-cart">
							<a href="javascript:;" class="wt-quick-add-cart"><?php esc_html_e( 'Add to cart', 'wt-variation-bulk-order' ); ?><span class="wt-loader"></span></a>
						</div>
					<?php } ?>
					<?php wp_nonce_field( 'wqatcaddcart', 'wqatcType' ); ?>
				</form>
			</div>
		</li>
	</ul>
	<?php 
	/**
	* wtvbo_variation_bulk_order_table_after_content hook.		 
	*/
	do_action( 'wtvbo_variation_bulk_order_table_after_content' );
	?>
</div>