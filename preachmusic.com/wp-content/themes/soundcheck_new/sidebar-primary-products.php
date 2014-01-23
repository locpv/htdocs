<?php  
/**
 * The products sidebar. Shown on Cart66 product pages.	
 *
 * @package Soundcheck
 * @since 1.0
 */
?>
<?php if ( is_active_sidebar( 'sidebar-primary-products' ) ) : ?>
	
	<section id="products-sidebar" class="sidebar" role="complementary">
		<?php dynamic_sidebar( 'sidebar-primary-products' ); ?>
	</section><!-- #products-sidebar -->
	
<?php endif; ?>
