<?php  
/**
 * The home sidebar template. Displays widgets to show only on the home page.
 *
 * @package Soundcheck
 * @since 1.0
 */
?>
<section id="home-sidebar" role="complementary">
	
	<div id="col-1" class="grid-3">
		<?php if ( is_active_sidebar( 'home-column-1' ) ) : ?>
			<?php dynamic_sidebar( 'home-column-1' ); ?>
		<?php else : ?>
			<?php echo soundcheck_get_default_notice( 'home-widgets' ); ?>
		<?php endif; ?>			
	</div>
	
	<div id="col-2" class="grid-6">
		<?php if ( is_active_sidebar( 'home-column-2' ) ) : ?>
			<?php dynamic_sidebar( 'home-column-2' ); ?>
		<?php else : ?>
			<?php echo soundcheck_get_default_notice( 'home-widgets' ); ?>
		<?php endif; ?>			
	</div>
	
	<div id="col-3" class="grid-3">
		<?php if ( is_active_sidebar( 'home-column-3' ) ) : ?>
			<?php dynamic_sidebar( 'home-column-3' ); ?>
		<?php else : ?>
			<?php echo soundcheck_get_default_notice( 'home-widgets' ); ?>
		<?php endif; ?>			
	</div>
	
</section><!-- #homebar-sidebar -->