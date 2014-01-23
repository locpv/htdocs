<article id="post-<?php the_ID(); ?>" <?php post_class() ?>>
    <?php get_template_part( 'partials/post', 'header' ); ?>
    <?php get_template_part( 'partials/post', 'image' ); ?>
    
    <div class="entry-footer">    	
    	<a class="button" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php _e( 'Details' ); ?></a>
    	<?php soundcheck_cart66_product_price_link(); ?>
    </div>
</article><!-- #post-## -->
