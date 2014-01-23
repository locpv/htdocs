<?php
/**
 * Custom Gravity Forms Styles
 *
 * Apply custom styling set via Theme Options and print in head.
 * This is called via a wp_head() filter.
 *
 * @package Soundcheck
 * @since 2.1.0
 */
function soundcheck_gforms_custom_styles() {

	if ( 'custom' == soundcheck_style( 'color_palette' ) ) : ?>
	
<style type="text/css" id="custom-theme-gform-styles-css">
	
	<?php
	$primary_1 = soundcheck_style( 'primary_1' );
	$primary_2 = soundcheck_style( 'primary_2' );
	?>
	
    body .gform_wrapper .gfield_label {
		<?php if ( isset( $primary_1 ) ) print 'color: ' . $primary_1; ?>; 
    }

	body .gform_wrapper .percentbar_blue {    
		<?php if ( isset( $primary_2 ) ) print 'background-color: ' . $primary_2; ?>; 
    }
    
</style>

	<?php endif;
}
add_action( 'wp_head', 'soundcheck_gforms_custom_styles' );
