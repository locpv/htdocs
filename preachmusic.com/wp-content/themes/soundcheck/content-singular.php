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
				locate_template( 'includes/entry-header.php', true ); ?>
				
				<?php
				/**
				 * Entry Formats
				 *
				 */
				locate_template( 'includes/entry-format.php', true ); ?>
				
				<?php if ( $post->post_content != '' ) : ?>
				
					<div class="entry-content">
					
						<?php 
						/**
						 * Entry Content
						 *
						 */
						the_content(); ?>
						
						
						<?php
						/**
						 * Page Links
						 *
						 */
						do_action( 'get_page_links' ); // Show page links (custom function to wp_link_pages() - functions/theme-helpers.php ?>
						
					</div><!-- .entry-content -->
				
				<?php endif; // end page content check ?>
				
				<?php 
				/**
				 * Entry Comments
				 *
				 */
				comments_template( '', true ); ?>
			
			</article><!-- #post-## -->
		
		<?php endwhile; ?>
		
	</section><!-- #entry-container -->

<?php endif; // end of the loop ?>