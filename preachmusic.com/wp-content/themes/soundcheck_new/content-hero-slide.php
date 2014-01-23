<?php
$attachment_image_src = ( has_post_thumbnail() ) ? wp_get_attachment_image_src( get_post_thumbnail_id(), 'theme-hero' ) : false;

$post_class = sprintf( 'slide post-%d', get_the_ID() );
?>

<li <?php post_class( $post_class ); ?> style="background: <?php echo get_post_meta( get_the_ID(), 'background_color', true ); ?> url(<?php echo esc_url( $attachment_image_src[0] ); ?>) 50% 0 no-repeat">
    
	<?php
	// Allow users to link the slides background image to another link
	// This requires the post format to be "standard", no content, 
	// and a custom field value set (hero_slide_link). If the user sets
	// the hero_slide_link value to permalink, we will link to the post page.	
	if ( '' == get_post_format() && '' == $post->post_content && ( $hero_slide_link = get_post_meta( get_the_ID(), 'hero_slide_link', true ) ) ) :
		$tag = 'a';
		$href = ( 'permalink' == $hero_slide_link ) ? get_permalink() : $hero_slide_link;
		printf( '<%s class="slide-content-container link" href="%s">', $tag, esc_url( $href ) );
	else :
		$tag = 'div';
		printf( '<%s class="slide-content-container">', $tag );
	endif;
	?>
    
    	<?php if ( '' != $post->post_content || get_post_format() ) : ?>
    		<article class="slide-content">
    			<?php if ( '' != $post->post_content ) : ?>
    				<?php get_template_part( 'partials/post', 'content' ); ?>
    			<?php endif; ?>
    		</article><!-- .slide-content -->
    	<?php endif; ?>
    	
    	<?php edit_post_link( __( 'Edit Slide', 'soundcheck' ), '<div class="edit-link">', '</div>' ); ?>
    
    <?php // Close tag ?>
    <?php printf( '</%s>', $tag ); ?><!-- .slide-content-container -->

</li><!-- .slide -->
