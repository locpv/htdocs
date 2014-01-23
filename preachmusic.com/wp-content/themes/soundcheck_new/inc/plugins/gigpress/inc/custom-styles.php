<?php
/**
 * Custom GigPress Styles
 *
 * Apply custom styling set via Theme Options and print in head.
 * This is called via a wp_head() filter.
 *
 * @package Soundcheck
 * @since 2.1.0
 */
function soundcheck_gigpress_custom_styles() {

	if ( 'custom' == soundcheck_style( 'color_palette' ) ) : ?>
	
<!-- custom gigpress theme styles -->	
<style type="text/css" id="custom-theme-gigpress-styles-css">
	
	<?php
	$primary_1 = soundcheck_style( 'primary_1' );
	$text_color = soundcheck_style( 'text_primary' );
	?>
	
	.widget_gigpress .gigpress-listing .gigpress-sidebar-date,
	.widget_gigpress .gigpress-listing .gigpress-sidebar-venue a {
		<?php if ( isset( $primary_1 ) ) print 'color: ' . $primary_1; ?>; 
	}
	
	.widget_gigpress .gigpress-listing .gigpress-sidebar-city,
	body .gigpress-table .gigpress-info td,
	body .gigpress-table .gigpress-row .gigpress-date
	 {
		<?php if ( isset( $text_color ) ) print 'color: ' . $text_color; ?>; 
	}
	
	body .gigpress-table .gigpress-info-label {
		<?php if ( isset( $primary_1 ) ) print 'color: ' . $primary_1; ?>; 
	}

</style>

	<?php endif; // end custom cart66 styles
}
add_action( 'wp_head', 'soundcheck_gigpress_custom_styles' );
