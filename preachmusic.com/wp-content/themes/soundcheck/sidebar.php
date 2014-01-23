<?php  
/**
 * The primary sidebar. Shown on all pages except the home page.	
 *
 * @package    WordPress
 * @subpackage Soundcheck
 * @since      1.0
 */
?>

<section id="primary-widgets-container" role="complementary">

  <ul id="primary-widgets" class="sidebar">
	
		<?php 
		/**
		 * Sidebar Top
		 *
		 */
		dynamic_sidebar( 'sidebar-primary' ); ?>
	
	</ul><!-- #primary-widgets -->

</section><!-- #primary-sidebar-container -->
