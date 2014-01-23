<?php
/**
 * Featured Image Carousel
 *
 * @package Soundcheck
 * @since 1.0
 */
 
$image_carousel_query = soundcheck_get_image_carousel_items();

if ( $image_carousel_query->have_posts() ) : ?>
	
	<aside id="image-carousel-container">
		
		<div class="lines">
			<span class="line"><!-- nothing to see here, css line --></span>
			<span class="line"><!-- nothing to see here, css line --></span>
			<span class="line"><!-- nothing to see here, css line --></span>
			<span class="line"><!-- nothing to see here, css line --></span>
		</div>
		
		<ul id="image-carousel" class="image-carousel-items jcarousel-skin">
		<?php while ( $image_carousel_query->have_posts() ) : $image_carousel_query->the_post(); ?>
		    
		    <?php $format = ( get_post_format() ) ? get_post_format() : 'standard' ?>
		
		    <li class="image-carousel-item">
		  		<figure class="entry-thumbnail">
		    		<a class="thumbnail-icon <?php echo esc_attr( $format ); ?>" href="<?php the_permalink(); ?>" title="<?php echo soundcheck_the_title_attribute(); ?>">
		    			<?php the_post_thumbnail( 'theme-carousel' ); ?>
		    		</a>
		  		</figure><!-- .entry-thumbnail -->
		    </li><!-- .image-carousel-item -->
		
		<?php endwhile; // end while loop ?>
		</ul><!-- #image-carousel -->
	
	</aside><!-- #image-carousel-container -->

<?php else : ?>
	
	<aside class="default-notice">
		<h3><?php _e( 'Featured Image Carousel', 'soundcheck' ); ?></h3>
		<p><?php _e( 'The featured image carousel requires at least one post with a featured image.', 'soundcheck' ); ?></p>
	</aside>

<?php endif; // end image carousel post check ?>

<?php wp_reset_postdata(); ?>
