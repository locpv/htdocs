<?php  
/** 
 * Get Category nice names to be set as class values.
 * We are doing this so we can use a JS Filter
 */
$category_names = array(); // clear names from previous post

foreach ( ( get_the_category() ) as $category ) { 
    $category_names[] = sprintf( ' %s', $category->category_nicename ); 
}

$class = implode( ' ', $category_names );
?>

<li id="post-<?php the_ID(); ?>" class="event <?php echo esc_attr( $class ); ?> clearfix">
    <time class="event-date" datetime="<?php echo get_the_date(); ?>">
    	<?php echo get_the_date(); ?>
    </time>

    <div class="event-content">
    	<h4 class="event-title">
        	<a class="tooltip" href="javascript:;" title="<?php esc_attr_e( 'View Details', 'soundcheck' ); ?>">
        		<?php the_title(); ?>
        	</a>
    	</h4>
    	
    	<?php edit_post_link( __( '(Edit)', 'soundcheck' ) ); ?>
        
        <?php if ( $post->post_excerpt ) : ?>
        	<p class="event-excerpt"><?php echo get_the_excerpt(); ?></p>
        <?php endif; ?>
        
        <?php if ( $post->post_content ) : ?>
        	<div class="event-description"><?php the_content(); ?></div>
        <?php endif; ?>
    </div>
</li>
