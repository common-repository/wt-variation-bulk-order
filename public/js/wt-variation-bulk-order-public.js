(function($) {
	'use strict';

	/**
	 * All of the code for your public-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */

	/*==========================================================================================================
	..........................................|| Table Header ||.........................................
	============================================================================================================*/

	jQuery(document).on('click', '.wt-order-list .wt-order-header:not(.off_table)', function(e) {
		e.preventDefault();
		var wt_this = jQuery('.wt-order-table-wrap');
		if( wt_this.hasClass("active") ) {
			jQuery(this).removeClass('active');
			wt_this.removeClass("active").slideUp();
			wt_this.parents('.wt-quick-order-main-wrap').find('.variations_form.cart .variations').show();
			wt_this.parents('.wt-quick-order-main-wrap').find('.variations_form.cart .single_variation_wrap').show();
		} else {
			jQuery(this).addClass('active');
			wt_this.addClass("active").slideDown();
			wt_this.parents('.wt-quick-order-main-wrap').find('.variations_form.cart .variations').hide();
			wt_this.parents('.wt-quick-order-main-wrap').find('.variations_form.cart .single_variation_wrap').hide();
		}
		return false;
	});


	/*=========================================================================================================================================================
	......................................................|| WT Woo Quantity Pluse OR Minus ||.........................................................
	=========================================================================================================================================================*/

	jQuery(document).on( 'click', '.wt-order-quantity .wt-order-quantity-wrap .wt_plus, .wt-order-quantity .wt-order-quantity-wrap .wt_minus', function(e) {
		e.preventDefault();

		var wt_this = jQuery(this);
		var wt_input_qty = wt_this.parents('.wt-order-quantity').find('.wt-order-quantity-wrap .quantity .qty');
		var wt_val = parseFloat( wt_input_qty.val() );
		var wt_max = parseFloat( wt_input_qty.attr('max') );
		var wt_min = parseFloat( wt_input_qty.attr('min') );
		var wt_step = parseFloat( wt_input_qty.attr('step') );

		if( isNaN( wt_val )|| wt_val == '' || wt_val == undefined ||  wt_val == null ){
			wt_val = 0;
		}

		if ( wt_this.is( '.wt_plus' ) ) {
			if ( wt_max && ( wt_max <= wt_val ) ) {
				wt_input_qty.val( wt_max ).change();
			} else {
				wt_input_qty.val( wt_val + wt_step ).change();
			}
		} else {
			if ( wt_min && ( wt_min >= wt_val ) ) {
				wt_input_qty.val( wt_min ).change();
			} else if ( wt_val >= 1 ) {
				wt_input_qty.val( wt_val - wt_step ).change();
			}
		}

	});


	/*=========================================================================================================================================
	................................................|| WT Woo Quantity Chnage ||.............................................................
	=========================================================================================================================================*/
	jQuery(document).on('keyup keydown keypress change', '.wt-quick-order-table .wt_product_rows .wt-order-quantity .input-text', function(e) {
		var wt_this = jQuery(this);
		wt_variation_bulk_order_calculate_price( wt_this );
	});

	/*=========================================================================================================================================
	................................................|| WT Add TO Cart ||.............................................................
	=========================================================================================================================================*/
	jQuery(document).on( 'click', '.wt-quick-variations-form .wt-quick-order-cart .wt-quick-add-cart', function( e ) {
		e.preventDefault();
		var wqatcaddcart = jQuery(this);
		var wqatcType = jQuery('.wt-quick-variations-form input[name="wqatcType"]').val();
		var wt_currency = jQuery('.wt-quick-order-table tbody tr').attr('wt-currency');
		var wt_cart_data = [];
		var wt_flag = 0;

		jQuery('.wt-quick-order-table tbody tr').each(function( wt_key, wt_val ) {

			var tr_this = jQuery(this);
			var wt_pro_id = tr_this.attr('wt-pro-id');
			var wt_var_id = tr_this.attr('wt-var-id');
			var wt_quantity = tr_this.find('.input-text').val();
			
			if( wt_quantity > 0  ) {
				var wt_cart_obj = {
					'wt_pro_id'   : wt_pro_id,
					'wt_var_id'   : wt_var_id,
					'wt_quantity' : wt_quantity
				}

				wt_cart_data.push( wt_cart_obj );
				wt_flag = 1;
			}

		});

		if( wt_flag == 0 ){
			if( jQuery('.wt-quick-order-wrap  .wt-notice .wt-error.wt-qty-error').length == 0 ) {
				jQuery('.wt-order-list').before('<div class="wt-notice"><span class="wt-error wt-qty-error">Please enter a quantity</span></div>');
			}
		} else {
			jQuery('.wt-quick-order-wrap  .wt-notice').remove();
		}

		if( wt_cart_data.length > 0 ) {

			wqatcaddcart.addClass('wt-active');

			jQuery.ajax({
				type : "post",
				dataType : "json",
				url : wtqoAjax.ajaxurl,
				data : { action: "wtvbo_variation_bulk_order_add_to_cart", wt_cart_data : wt_cart_data, wqatcType : wqatcType },
				success: function( response ) {
					if( response ){
						wqatcaddcart.removeClass('wt-active');
						jQuery(response).each(function( wt_key, wt_val ) {

							if( wt_val.success == true ){
								jQuery('.wt-quick-variations-form').trigger("reset");
								jQuery('.wt-quick-order-table tbody tr .wt-order-subtotal').html( wt_currency+''+'0.00' );
								jQuery('.wt-quick-order-table tfoot tr .wt-order-total-qty').html( '0' );
								jQuery('.wt-quick-order-table tfoot tr .wt-order-tolal-price .wt-order-total').html( '0.00' );
								jQuery('.wt-order-list').before('<div class="wt-notice"><span class="wt-success">'+ wt_val.cart_url +'</span></div>');
								jQuery( document.body ).trigger( 'wc_fragment_refresh' );
							} 

							if( wt_val.error == true ){
								jQuery('.wt-order-list').before('<div class="wt-notice"><span class="wt-error">'+wt_val.error_msg+'</span></div>');	
								jQuery( document.body ).trigger( 'wc_fragment_refresh' );
							}

							setTimeout( function(){
								jQuery('.wt-quick-order-wrap .wt-notice').remove();
							}, 10000 );

						});
					}
				}
			});
		}

	});

})(jQuery);

/*===================================================================================
....................|| WT Qucik Order Chnage Price Filter Function ||...............
/*===================================================================================*/
function wt_variation_bulk_order_calculate_price( wt_this ){

	var wt_sub_total = 0;
	var wt_sub_qty = 0;


	wt_this.closest('table').find('tbody tr').each(function( key, val ) {

		var tr_this = jQuery(this);
		var wt_quantity = tr_this.find('.input-text').val();
		var wt_total = 0;
		var wt_price = tr_this.attr( 'wt-price' );
		var wt_currency = tr_this.attr( 'wt-currency' );

		if( wt_quantity ){
			wt_total = parseFloat( wt_price ) * parseFloat(wt_quantity);
			if( isNaN( wt_total ) ){
				wt_total = 0;
			}
			wt_total = parseFloat(wt_total).toFixed(2);
			tr_this.find('.wt-order-subtotal').html(  wt_currency +''+ wt_total );
			wt_sub_total = wt_sub_total + parseFloat( wt_total );
			wt_sub_qty = wt_sub_qty + parseFloat( wt_quantity );

		}

	});

	wt_this.parents('.wt-quick-order-table').find('tfoot .wt-subtotals .wt-order-total-qty').html( wt_sub_qty );
	wt_this.parents('.wt-quick-order-table').find('tfoot .wt-subtotals .wt-order-total').html( parseFloat(wt_sub_total).toFixed(2) );

}

/* Set here function use to initialize quick reorder layout. */