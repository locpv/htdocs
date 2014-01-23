<?php  
/**
 * The secondary sidebar. This page determines the page type and shows the appropriate widgets.	
 *
 * @package    WordPress
 * @subpackage Soundcheck
 * @since      1.0
 */
?>

<section id="secondary-widgets-container" role="complementary">

  <ul id="secondary-widgets" class="sidebar">
	
	  <?php
		/**
		 * Sidebar Multiple
		 *
		 */
	  if ( is_category() || is_search() || is_archive() || is_404() || is_page_template( 'template-post-page.php' ) ) :
	  	dynamic_sidebar( 'sidebar-multiple' ); ?>
	  
	  
	  <?php
		/**
		 * Sidebar Single
		 *
		 */
	  elseif ( is_single() ) :
	  	dynamic_sidebar( 'sidebar-single' ); ?>
	  
	  
	  <?php
		/**
		 * Sidebar Page
		 *
		 */
	  elseif ( is_page() && ! is_page_template('template-post-page.php') ) :
	  	dynamic_sidebar( 'sidebar-page' ); ?>
	  	
		<?php endif; ?>
	
	</ul><!-- #secondary-widgets -->

</section><!-- #secondary-sidebar-container -->
