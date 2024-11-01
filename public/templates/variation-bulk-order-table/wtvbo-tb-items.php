<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly 
$product_id = isset( $args['product_id'] ) ? $args['product_id'] : '';
$variation_id = isset( $args['variation_id'] ) ? $args['variation_id'] : '';

$variation_product = wc_get_product( $variation_id );
$stock_quantity = $variation_product->get_stock_quantity();
$variation_variations = $variation_product->get_variation_attributes(); 
?>
<tr class="wt_product_rows" wt-pro-id="<?php echo esc_attr( $product_id ); ?>" wt-var-id="<?php echo esc_attr( $variation_id ); ?>" wt-price="<?php echo esc_attr( $variation_product->get_price() ); ?>" wt-currency="<?php echo esc_attr( get_woocommerce_currency_symbol() ); ?>">
	<td data-title="<?php esc_html_e( 'Variant', 'wt-variation-bulk-order' ); ?>" class="wt-order-title"><?php echo esc_html( $variation_product->get_name() ); ?></td>
	<td data-title="<?php esc_html_e( 'Price', 'wt-variation-bulk-order' ); ?>" class="wt-order-priec"><?php echo esc_html( get_woocommerce_currency_symbol().''.$variation_product->get_price() ); ?></td>
	<?php if( !empty( $stock_quantity ) && $stock_quantity != 0 && $stock_quantity > 0 ) { ?>
		<td data-title="<?php esc_html_e( 'Qty', 'wt-variation-bulk-order' ); ?>" class="wt-order-quantity">
			<div class="wt-order-quantity-wrap">
				<a href="javascript:;" class="wt_minus">-</a>
				<?php
				do_action( 'woocommerce_before_add_to_cart_quantity' );
				$input_qty_value = 0;
				if ( isset( $_POST['woocommerce-cart-nonce'] ) && wp_verify_nonce( sanitize_text_field ( wp_unslash( $_POST['woocommerce-cart-nonce'] ) ), 'cart-more-nonce' ) && ! empty( $_POST['quantity'] ) && !empty( $variation_product->get_id() )) {
					$input_qty_value = isset( $_POST['quantity'][ $variation_product->get_id() ] ) ? wc_stock_amount( wc_clean( sanitize_text_field( wp_unslash( $_POST['quantity'][ $variation_product->get_id() ] ) ) ) ) : '0';
				}
				woocommerce_quantity_input(
					array(
						'input_name'  => 'quantity[' . $variation_product->get_id() . ']',
						'input_value' => esc_attr( $input_qty_value ), 
						'min_value'   => apply_filters( 'woocommerce_quantity_input_min', 0, $variation_product ),
						'max_value'   => apply_filters( 'woocommerce_quantity_input_max', $variation_product->get_max_purchase_quantity(), $variation_product ),
						'placeholder' => '0',
					)
				);

				do_action( 'woocommerce_after_add_to_cart_quantity' );
				?>
				<a href="javascript:;" class="wt_plus">+</a>
			</div>
		</td>
		<td data-title="<?php esc_html_e( 'Subtotal', 'wt-variation-bulk-order' ); ?>" class="wt-order-subtotal"><?php echo esc_html( get_woocommerce_currency_symbol().'0.00' ); ?></td>
	<?php } else { ?>
		<td class="wt-not-stock-data" colspan="2">
			<?php esc_html_e( 'This product is not in stock', 'wt-variation-bulk-order' ); ?>
		</td>
	<?php } ?>
</tr>