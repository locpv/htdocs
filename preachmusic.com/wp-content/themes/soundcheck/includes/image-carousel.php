<?php
/**
 * Featured Image Carousel
 *
 */
$image_carousel_args = array(
	'orderby'        => 'date', // To randomize, change "date" to "rand"
	'cat'            => ti_get_option( 'image_carousel_category', null ),
	'posts_per_page' => ti_get_option( 'image_carousel_number', null ),
	'meta_query'     => array ( 
		array (
			'key' => '_thumbnail_id' 
		)
	)
);

$image_carousel_query = new WP_Query( $image_carousel_args ); ?>

<?php if ( $image_carousel_query->have_posts() ) : ?>
	
	<aside class="ti-image-carousel">
		
		<div class="lines">
			<span><!-- nothing to see here, css line --></span>
			<span><!-- nothing to see here, css line --></span>
			<span><!-- nothing to see here, css line --></span>
			<span><!-- nothing to see here, css line --></span>
		</div>
		
		<ul id="image-carousel" class="image-carousel-items jcarousel-skin-tango">
		  
			<?php while ( $image_carousel_query->have_posts() ) : $image_carousel_query->the_post(); ?>
		  	
		  		<?php $format = ( get_post_format() ) ? get_post_format() : 'standard' ?>
		  	
		  		<li class="image-carousel-item">
		  	  
		  	  		<figure class="entry-thumbnail">
		  				
		  				<a class="thumbnail-icon <?php echo esc_attr( $format ) ?>" href="<?php the_permalink() ?>" title="<?php ti_the_title_attribute() ?>"><!-- nothing to see here --></a>
		  	    	
		  	    		<?php the_post_thumbnail( 'theme-carousel' ); ?>
		  	  		
		  	  		</figure><!-- .entry-thumbnail -->
		  	  
		  		</li><!-- .image-carousel-item -->
		  	
			<?php endwhile; // end while loop ?>
		
		</ul><!-- #mycarousel -->
	
	</aside><!-- .ti-image-carousel-container -->
	
<?php else : ?>

	<aside class="default-notice">
	    <div class="entry-content">
	    	<h3>
	    		<?php _e( 'Featured Imgage Carousel', 'theme-it' ); ?>
	    	</h3>
	    	<p>
	    	  <?php echo __( 'The featured image carousel requires at least one post with a featured image.', 'theme-it' ) ?>
	    	</p>
	    </div>
	</aside>

<?php endif; // end image carousel post check ?>

<?php wp_reset_query();?>
