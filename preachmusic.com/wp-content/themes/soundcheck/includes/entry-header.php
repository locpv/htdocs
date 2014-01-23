<?php  
/**
 * This template file determines how to display entries header tag,
 * link, and meta information. Used across multiple files.
 *
 * @package    WordPress
 * @subpackage Soundcheck
 * @since      1.0
 */

global $is_page;
?>

<header class="entry-header">
  
	<?php 
	/**
	 * Entry Title
	 *
	 */
	if( is_singular() ) : // Show h1 heading tag without a link if singular page ?>
	
		<h1 class="entry-title"><?php the_title(); ?></h1>
	
	<?php else : // Show h2 tag with link ?>
	
		<h2 class="entry-title">
		  
			<a href="<?php the_permalink(); ?>" title="<?php ti_the_title_attribute(); ?>" rel="bookmark">
				
				<?php if ( comments_open() && ( isset( $is_page ) && $is_page != 'template-post-gallery' ) ) : ?>
					
					<span class="comments"><?php echo get_comments_number() ?></span>
				
				<?php endif; ?>
				
				<?php if ( isset( $is_page ) && $is_page == 'template-post-gallery' ) : ?>
					
					<?php apply_filters( 'limit_string', the_title( '', '', 0 ), 20, true ) ?>
					
				<?php else : ?>
				
					<?php the_title(); ?>
					
				<?php endif; ?>
				
			</a>
				
		</h2><!-- .entry-title -->
	
	<?php endif; // end singular check ?> <!-- .entry-title -->
	
	
	<?php
	/**
	 * Entry Excerpt
	 *
	 */
	 
	global $page_excerpt_mb; // Get custom global metabox info
	
	if( $page_excerpt_mb->get_the_value( 'page_excerpt' ) && $is_page != 'template-discography' ) : // Check if page excerpt exists in page excerpt metabox option  ?>
	
		<p class="entry-excerpt">
			
			<span><?php echo $page_excerpt_mb->the_value( 'page_excerpt' ); ?></span>
		
		</p><!-- .entry-excerpt -->
	
	<?php endif; // end page excerpt check ?>
	
	
</header><!-- .entry-header -->
