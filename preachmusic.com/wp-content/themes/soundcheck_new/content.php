<?php 
/**
 * The loop for displaying singular page content (single, page, attachements)
 *
 * @package Soundcheck
 * @since 1.0
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'entry' ); ?>>
    
    <?php get_template_part( 'partials/post', 'header' ); ?>
    <?php get_template_part( 'partials/post', 'meta' ); ?>
    <?php get_template_part( 'partials/post', 'format' ); ?>
    
    <?php if ( is_search() ) :  ?>
    
    	<div class="entry-content">
    		<?php the_excerpt(); ?>
    	</div><!-- .entry-content -->
    	
    <?php elseif ( $post->post_content != '' ) : ?>
    
    	<div class="entry-content">
			<?php
			// Allow for more tag on all pages other than singular pages but including the Blog page template. 
			if ( is_page_template( 'template-blog.php' ) || ! is_singular() ) { 
				global $more; $more = 0; 
			} 
			?>
			
    		<?php the_content( __( ' &hellip; Continue Reading', 'soundcheck' ) ); ?>
    	</div>
    	
    <?php endif; // if ( is_search() ); ?>
    
</article><!-- #post-## -->