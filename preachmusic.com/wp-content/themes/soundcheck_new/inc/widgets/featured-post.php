<?php
/**
 * Adds the Featured Post widget.
 *
 * @package soundcheck
 * @subpackage Widgets
 * @since 1.0.0
 */
 
add_action( 'widgets_init', 'soundcheck_featured_post_widget_load' );

function soundcheck_featured_post_widget_load() { 
	register_widget( 'soundcheck_featured_post_widget' );
}


class soundcheck_featured_post_widget extends WP_Widget {

	function soundcheck_featured_post_widget() {
	
		$widget_ops = array( 
			'classname' => 'soundcheck_featured_post_widget', 
			'description' => __( 'Show a specific post to feature.', 'soundcheck' )
		);

		$control_ops = array( 
			'width' => 250, 
			'height' => 250, 
			'id_base' => 'soundcheck_featured_post_widget' 
		);

		$this->WP_Widget( 'soundcheck_featured_post_widget', __( 'Featured Post', 'soundcheck' ), $widget_ops, $control_ops );
		 
	}
	
    function form( $instance ) {
    
	    $defaults = array(
			'title' => __( '', 'soundcheck' ),
			'id' => '',
			'excerpt' => 24,
			'thumbnail' => ''
	    );
	
	    $instance = wp_parse_args( (array) $instance, $defaults );
	   
	    $text_option = '<p><label for="%2$s">%1$s</label><br /><input type="text" class="widefat" id="%2$s" name="%3$s" value="%4$s" /></p>';
	    $checkbox_option = '<p><input class="checkbox" type="checkbox" id="%2$s" name="%3$s" %4$s value="1" /> <label for="%2$s">%1$s</label></p>';
	    
		// Title
		printf( $text_option,
			esc_html__( 'Title:', 'soundcheck' ),
			esc_attr( $this->get_field_id( 'title' ) ),
			esc_attr( $this->get_field_name( 'title' ) ),
			esc_attr( $instance['title'] )
		);
		
		// Post Count
		printf( $text_option,
			esc_html__( 'Post ID:', 'soundcheck' ),
			esc_attr( $this->get_field_id( 'id' ) ),
			esc_attr( $this->get_field_name( 'id' ) ),
			esc_attr( $instance['id'] )
		);
		
		// Excerpt Length
		printf( $text_option,
			esc_html__( 'Excerpt Length: (# of characters)', 'soundcheck' ),
			esc_attr( $this->get_field_id( 'excerpt' ) ),
			esc_attr( $this->get_field_name( 'excerpt' ) ),
			esc_attr( absint( $instance['excerpt'] ) )
		);
		
		// Post Thumnbails
		printf( $checkbox_option, 
			esc_html__( 'Show featured Image?', 'soundcheck' ),
			esc_attr( $this->get_field_id( 'thumbnail' ) ),
			esc_attr( $this->get_field_name( 'thumbnail' ) ),
			checked( absint( $instance['thumbnail'] ), 1, false )
		);
		
    }
    
    
    function update( $new_instance, $old_instance ) {
    
    	$instance = array();
		
		$instance['title']     = strip_tags( $new_instance['title'] );
		$instance['id']        = ( isset( $new_instance['id'] ) && 0 != $new_instance['id'] ) ? absint( $new_instance['id'] ) : '';
		$instance['excerpt']   = absint( $new_instance['excerpt'] );
		$instance['thumbnail'] = isset( $new_instance['thumbnail'] ) ? 1 : 0;
       
		return $instance;
        
    }
	
	
    function widget( $args, $instance ) {
    
		extract( $args );
		extract( $instance );
		
		$thumbnail = ( isset( $thumbnail ) ) ? $thumbnail : false;
		
		print $before_widget; 
		
		if ( ! isset( $id ) || empty( $id ) || 0 == $id ) :
		    
		    echo '<h3 class="widget-title">Error</h3>';
		    echo '<div class="widget-content">A featured post ID was not set.</div>';
		
		else :
		
			$featured_post = get_post( $id ); 
			
			if ( $title ) {
				print $before_title;
				printf( '<a href="%1$s" title="%2$s">%3$s</a>',
					esc_url( get_permalink( $id ) ),
					soundcheck_the_title_attribute(),
					esc_html( $title )
				);
				print $after_title;
			}
			?>
			
			<?php if ( $thumbnail && has_post_thumbnail( $id ) ) : ?>
			<figure>
				<a href="<?php echo esc_url( get_permalink( $id ) ); ?>" title="<?php echo soundcheck_the_title_attribute(); ?>">
					<?php echo get_the_post_thumbnail( $id, 'post-thumbnail' ); ?>
				</a>
			</figure>
			<?php endif; ?>
			
			<div class="widget-content">
			
				<h4>
				<?php
				printf( '<a href="%1$s" title="%2$s">%3$s</a>',
				    esc_url( get_permalink( $id ) ),
				    soundcheck_the_title_attribute(),
				    esc_html( $featured_post->post_title )
				);
				?>
				</h4>
				
				<?php if ( $excerpt ) : ?>
					<?php $text = ! empty( $featured_post->post_excerpt ) ? $featured_post->post_excerpt : $featured_post->post_content; ?>
				    <p>
				        <?php echo soundcheck_limit_string( strip_tags( $text ), absint( $excerpt ) ); ?>
				    </p>
				<?php endif; ?>
					
			</div>
		
		<?php endif; ?>
		
		<?php
		print $after_widget;
		
    }
    
}

?>