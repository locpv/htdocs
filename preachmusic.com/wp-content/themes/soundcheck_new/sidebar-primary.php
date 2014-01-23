<?php  
/**
 * The primary sidebar. Shown on all pages except the home page.	
 *
 * @package Soundcheck
 * @since 1.0
 */
?>
<?php if ( is_active_sidebar( 'sidebar-primary' ) ) : ?>
	
	<section id="primary-sidebar" class="sidebar" role="complementary">
		<?php dynamic_sidebar( 'sidebar-primary' ); ?>
	</section><!-- #primary-sidebar -->

<?php endif; ?>
