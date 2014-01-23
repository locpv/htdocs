<?php 
/**
 * The loop for displaying singular page content (single, page, attachements)
 *
 * @package    WordPress
 * @subpackage Soundcheck
 * @since      1.0
 */

/**
 * The Loop
 *
 */
if ( have_posts() ) : ?>
	
	<section id="entry-container" role="contentinfo">
	
		<?php while( have_posts() ) : the_post(); ?>
	
			<article id="post-<?php the_ID(); ?>" <?php post_class( 'entry' ) ?>>
			
				<?php
				/**
				 * Entry Header
				 *
				 */
				locate_template( 'includes/entry-header.php', true, false ); ?>
				
				
				<?php
				/**
				 * Entry Formats Media
				 *
				 */
				locate_template( 'includes/entry-format.php', true, false ); ?>
				
			</article><!-- #post-## -->
		
		<?php endwhile; ?>
		
		<?php
		/**
		 * Page Navigation
		 *
		 */
		locate_template( 'includes/page-navigation.php', true ); ?>
		
	</section><!-- #entry-container -->

<?php endif; // end of the loop ?>