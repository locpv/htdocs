<?php  
/**
 * The home sidebar template. Displays widgets to show only on the home page.
 *
 * @package    WordPress
 * @subpackage Soundcheck
 * @since      1.0
 */
?>
<section id="homebar-widgets-container" role="complementary">

	<ul id="homebar" class="sidebar">
		
		<?php 
		/**
		 * Home Page Widgets
		 *
		 */
		if ( is_active_sidebar( 'sidebar-home' ) ) : ?>
		
			<?php dynamic_sidebar( 'sidebar-home' ); ?>
			
		<?php else : ?>
		
			<li>
				<aside class="default-notice">
					<div class="entry-content">
						<h3>
							<?php _e( 'Home Widgets Setup', 'theme-it' ); ?>
						</h3>
						<p>
						  <?php echo __( 'It looks like there have not been any widgets setup for the ', 'theme-it' ) . '<a href="' . get_admin_url() . '/widgets.php">' . __( 'Home Page Widgets', 'theme-it' ) . '</a> ' . __( 'area.', 'theme-it' ); ?>
						</p>
					</div>
				</aside>
			</li>
		
		<?php endif; ?> 
	
	</ul><!-- #homebar -->

</section><!-- #homebar-widgets-container -->