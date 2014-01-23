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
	
	<?php
	/**
	 * Page Header
	 *
	 */
	locate_template( 'includes/page-header.php', true ); ?>
	
	<section id="entry-container" role="contentinfo">
	
		<?php while( have_posts() ) : the_post(); ?>
	
			<article id="post-<?php the_ID(); ?>" <?php post_class( 'entry' ) ?>>
				
				<?php
				/**
				 * Entry Header
				 *
				 */
				locate_template( 'includes/entry-header.php', true, false ); ?>
				
				<ul class="entry-meta">
				  
				  <li class="date"><time pubdate="<?php echo get_the_date( 'Y-m-d' ) ?>"><?php echo get_the_date( 'm/d/y' ) ?></time></li>
				  
				  <li class="author">
				  	
				  	<?php the_author() ?>
				  	
				  </li>
				  
				  <?php $cats_list = get_the_category_list( ' &middot; ' );
				 
				  if ( ! empty( $cats_list ) ) { ?>
				  	
				  	<li class="categories">&middot; <?php echo $cats_list ?></li>
				  
				  <?php } ?>
				
				</ul><!-- .entry-meta -->			
				
				<?php
				/**
				 * Entry Formats
				 *
				 */
				locate_template( 'includes/entry-format.php', true, false ); ?>
				
				
				<?php
				/**
				 * Entry Content/Summary
				 *
				 */
				if ( is_search() ) : // Check if this is an Archives and Search page ?>
	  	  
					<div class="entry-content">
						
						<?php the_excerpt(); ?>
					
					</div><!-- .entry-content -->
	  	  
				<?php elseif ( $post->post_content != '' ) : // If not Archives or Search page ?>
	  		
					<div class="entry-content">
	  	  		
						<?php global $more; $more = 0; // Needed for more tag to work ?>
						
						<?php the_content( ' &hellip; ' . ti_continue_reading_link() ); // Show content ?>
						
						<?php do_action( 'get_page_links' ); // Show page links (custom function to wp_link_pages() - functions/theme-helpers.php ?>
	  	  		
					</div><!-- .entry-content -->
	  		
				<?php endif; // End Archive and Search page check ?>

				
				<?php 
				/**
				 * Entry Comments
				 *
				 */
				comments_template( '', true ); ?>
		
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