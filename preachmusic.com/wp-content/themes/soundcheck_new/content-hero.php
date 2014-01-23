<?php 
/**
 * @package Soundcheck
 * @since 1.0
 */
?>

<section id="hero">
    <ul class="slides">
    	<?php get_template_part( 'loop', 'hero' ); ?>
    </ul><!-- .slides -->
    
    <div class="controls">
    	<a href="#" class="prev ir" title="<?php esc_attr_e( 'Previous', 'soundcheck' ); ?>"><?php _e( 'Previous', 'soundcheck' ); ?></a>
    	<a href="#" class="next ir" title="<?php esc_attr_e( 'Next', 'soundcheck' ); ?>"><?php _e( 'Next', 'soundcheck' ); ?></a>
    </div>
</section><!-- #hero -->

