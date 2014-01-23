<?php
/**
 * Adds the Events widget.
 *
 * @package soundcheck
 * @subpackage Widgets
 * @since 2.0.0
 */

add_action( 'widgets_init', 'soundcheck_events_widget_load' );

function soundcheck_events_widget_load() { 
	register_widget( 'soundcheck_events_widget' );
}


class soundcheck_events_widget extends WP_Widget {

	function soundcheck_events_widget() {
		
		$widget_ops = array( 
			'classname'   => 'soundcheck_events_widget', 
			'description' => __( 'Show latest posts from a category.', 'soundcheck' )
		);

		$control_ops = array( 
			'width'   => 250, 
			'height'  => 250, 
			'id_base' => 'soundcheck_events_widget' 
		);

		$this->WP_Widget( 'soundcheck_events_widget', __( 'Events', 'soundcheck' ), $widget_ops, $control_ops ); 
	
	}
	
	
    function form( $instance ) {
    
	    $defaults = array(
			'title'   => __( 'Upcoming Events', 'soundcheck' ),
			'count'   => 3,
			'excerpt' => 0,
			'page'    => '',
			'button'  => ''
	    );
	
	    $instance = wp_parse_args( (array) $instance, $defaults );
	    
	    if ( ! $events_cat = soundcheck_option( 'events_category' ) ) {
	    
		    echo soundcheck_get_default_notice( 'events' );

	    } else {
	   
			$text_option = '<p><label for="%2$s">%1$s</label><br /><input type="text" class="widefat" id="%2$s" name="%3$s" value="%4$s" /></p>';
			$checkbox_option = '<p><input class="checkbox" type="checkbox" id="%2$s" name="%3$s" %4$s value="1" /> <label for="%2$s">%1$s</label></p>';
			
			// Title
			printf( $text_option,
			    esc_html__( 'Title:', 'soundcheck' ),
			    esc_attr( $this->get_field_id( 'title' ) ),
			    esc_attr( $this->get_field_name( 'title' ) ),
			    esc_attr( $instance['title'] )
			);
			
			// Event Count
			printf( $text_option,
			    esc_html__( 'Event Count:', 'soundcheck' ),
			    esc_attr( $this->get_field_id( 'count' ) ),
			    esc_attr( $this->get_field_name( 'count' ) ),
			    esc_attr( absint( $instance['count'] ) )
			);
			
			// Event Excerpt
			printf( $checkbox_option, 
			    esc_html__( 'Show event excerpt?', 'soundcheck' ),
			    esc_attr( $this->get_field_id( 'excerpt' ) ),
			    esc_attr( $this->get_field_name( 'excerpt' ) ),
			    checked( absint( $instance['excerpt'] ), 1, false )
			);
			
			// Events Page
			printf( '<p><label for="%2$s">%1$s</label><br />%3$s</p>',
			    esc_html__( 'Should the events link to an events page?', 'soundcheck' ),
			    esc_attr( $this->get_field_id( 'page' ) ),
			    wp_dropdown_pages( array( 
			    	'name' => $this->get_field_name( 'page' ), 
			    	'selected' => $instance['page'],
			    	'class' => 'widefat',
			    	'echo' => 0,
			    	'show_option_none' => 'None'
			    ) )
			);
			
			// More Button
			printf( $checkbox_option, 
			    esc_html__( 'Show "View More" button?', 'soundcheck' ),
			    esc_attr( $this->get_field_id( 'button' ) ),
			    esc_attr( $this->get_field_name( 'button' ) ),
			    checked( absint( $instance['button'] ), 1, false )
			);
		}
		
    }
    
    
    function update( $new_instance, $old_instance ) {
		
		$instance = array();
		
		$instance['title']   = strip_tags( $new_instance['title'] );
		$instance['count']   = absint( $new_instance['count'] );
		$instance['excerpt'] = isset( $new_instance['excerpt'] ) ? 1 : 0;
		$instance['page']    = absint( $new_instance['page'] );
		$instance['button']  = isset( $new_instance['button'] ) ? 1 : 0;
       
        return $instance;
        
    }
	
	
    function widget( $args, $instance ) {
		
		extract( $args );
		
		print $before_widget; 
		
		if ( $instance['title'] ) {
			print $before_title;
			print $instance['title'];
			print $after_title;
		}
		?>
		
		<div class="widget-content">

		    <?php if ( $events_cat = soundcheck_option( 'events_category' ) ) : ?>
		    
		        <?php
				$events = soundcheck_get_events( array( 
					'cat' => $events_cat,
					'posts_per_page' => $instance['count'] > 0 ? $instance['count'] : 1,
				) );
		        ?>
		        
		        <?php if ( ! $events->have_posts() ) : ?>
		        
		        	<?php 
		        	printf( '<p class="no event">%s</p>',
		        	    esc_html( sprintf( __( 'There are not any %s scheduled at this time.', 'soundcheck' ), get_cat_name( $events_cat ) ) )
		        	);
		        	?>
		        	
		        <?php else : ?>
		        
		        	<ul id="events-date-list" class="clearfix">
		        	<?php while ( $events->have_posts() ) : $events->the_post(); ?>
		        	    <li class="event clearfix">
		        	        <time class="event-date" datetime="<?php echo get_the_date(); ?>">
		        	        	<?php echo get_the_date(); ?>
		        	        </time>
		        	    
		        	        <div class="event-content">
		        	        	<h4 class="event-title">
		        	        	<?php if ( $instance['page'] ) : ?>
		        	            	<a href="<?php echo get_permalink( $instance['page'] ); ?>?event_id=<?php the_ID(); ?>" title="">
		        	            		<?php the_title(); ?>
		        	            	</a>
		        	            <?php else : ?>
		        	            	<?php the_title(); ?>
		        	            <?php endif; ?>
		        	        	</h4>
		        	        	
								<?php if ( $instance['excerpt'] ) : ?>
		        	        		<?php global $post; ?>
		        	            	<?php if ( $post->post_excerpt ) : ?>
		        	            		<p class="event-excerpt"><?php echo get_the_excerpt(); ?></p>
		        	            	<?php endif; ?>
		        	            <?php endif; ?>
		        	        </div>
		        	    </li>
		        	<?php endwhile; // end while have_posts(); ?>
		        	<?php wp_reset_postdata(); ?>
		        	</ul>
		        	
		        <?php endif; // end if have_posts(); ?>
		        
		    <?php else : // Event cat not set, so display a notice ?>
		    
		        <?php echo soundcheck_get_default_notice( 'events' ); ?>
		        
		    <?php endif; // end events_cat check ?>
		</div>
		
		<?php if ( $instance['page'] && $instance['button'] ) : ?>
		<footer class="widget-footer">
			
			<?php 
			printf( '<a href="%1$s" title="%2$s" class="button">%3$s</a>',
				esc_url( get_permalink( $instance['page'] ) ),
				soundcheck_the_title_attribute(),
				esc_html__( 'View More', 'soundcheck' )
			);
			?>
			
		</footer>
		<?php endif; ?>
		
		<?php
		print $after_widget;
		
    }
}