<?php  
/**
 * The featured sidebar template. Displays featured widgets to show on all pages.
 * This was meant to be for the audio player.
 *
 * @package    WordPress
 * @subpackage Soundcheck
 * @since      1.0
 */

?>
<section id="featured-widgets-container" role="complementary">
  
	<ul id="featured-widgets" class="sidebar">
		
		<li>
		
			<?php get_template_part( 'content', 'jplayer' ); ?>
		
		</li>
	
	</ul><!-- #featured-widgets -->
	
</section><!-- #sidebar-container -->