<?php
/**
 * Custom Cart66 styles
 *
 * Apply custom styling set via Theme Options and print in head.
 * This is called via a wp_head() filter.
 *
 * @package Soundcheck
 * @since 2.1.0
 */
function soundcheck_cart66_custom_styles() {

	if ( 'custom' == soundcheck_style( 'color_palette' ) ) : ?>
	
<!-- custom cart66 theme styles -->	
<style type="text/css">
	
	<?php
	$primary_1 = soundcheck_style( 'primary_1' );
	$primary_2 = soundcheck_style( 'primary_2' );
	$text_color = soundcheck_style( 'text_primary' );
	?>
	
	body #viewCartTable .subtotal .alignRight.strong,
	body #viewCartTable .shipping .alignRight.strong,
	body #viewCartTable .total .alignRight.strong {
		<?php if ( isset( $primary_1 ) ) print 'color: ' . $primary_1; ?>; 
	}
	
	body .phorm2,
	body #viewCartNav #Cart66SubtotalRow,
	body .Cart66CartWidget .Cart66CartSubTotalLabel,
	body .Cart66CartWidget .Cart66ProductTitle,
	body .Cart66CartWidget .Cart66CartSubTotalLabel,
	body .Cart66CartWidget .Cart66ProductTitle,
	body .soundcheck_product_purchase_widget .product-price .price-label,
	body .soundcheck_product_purchase_widget .Cart66ButtonPrimary {
		<?php if ( isset( $text_color ) ) print 'color: ' . $text_color; ?> !important; 
	}
	
	body .Cart66WidgetViewCart,
	body .Cart66WidgetViewCheckout,
	body .Cart66ButtonPrimary,
	body .Cart66ButtonSecondary,
	body #content .Cart66ButtonPrimary,
	body #content .Cart66ButtonSecondary,
	body .Cart66CartButton .purAddToCart {
		<?php if ( isset( $primary_1 ) ) print 'color: ' . $primary_1; ?> !important; 
		<?php if ( isset( $primary_2 ) ) print 'background: ' . $primary_2; ?> !important; 
	}

</style>

	<?php endif; // end custom cart66 styles
}
add_action( 'wp_head', 'soundcheck_cart66_custom_styles' );


