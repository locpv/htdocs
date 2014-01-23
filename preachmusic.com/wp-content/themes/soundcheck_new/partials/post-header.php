<?php  
/**
 * This template file determines how to display entries header tag,
 * link, and meta information. Used across multiple files.
 *
 * @package Soundcheck
 * @since 1.0
 */
?>

<header class="entry-header">
	
	<?php 
	if ( is_singular() && ! soundcheck_page_template( 'gallery' ) ) {
		edit_post_link( __( 'Edit', 'soundcheck' ) );
	}
	?>
	
	<?php if ( is_singular() && ! soundcheck_page_template() ) : ?>
		<h1 class="entry-title"><?php the_title(); ?></h1>
	<?php else : ?>
		<h2 class="entry-title">
			<a href="<?php the_permalink(); ?>" title="<?php echo soundcheck_the_title_attribute(); ?>" rel="bookmark">
				<?php if ( comments_open() && ( ! soundcheck_page_template( 'gallery' ) && ! soundcheck_product_type_page() ) ) : ?>
					<span class="comments"><?php echo get_comments_number() ?></span>
				<?php endif; ?>
				
				<?php the_title(); ?>
			</a>
		</h2>
	<?php endif; ?>
	
	
    <?php if ( $post->post_excerpt ) : ?>
    	<p class="entry-excerpt"><span><?php echo get_the_excerpt() ?></span></p>
    <?php endif; ?>
	
</header><!-- .entry-header -->
