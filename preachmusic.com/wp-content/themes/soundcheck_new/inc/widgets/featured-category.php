<?php
/**
 * Adds the Featured Category widget.
 *
 * @package soundcheck
 * @subpackage Widgets
 * @since 1.0.0
 */

add_action( 'widgets_init', 'soundcheck_featured_category_widget_load' );

function soundcheck_featured_category_widget_load() { 
	register_widget( 'soundcheck_featured_category_widget' );
}


class soundcheck_featured_category_widget extends WP_Widget {

	function soundcheck_featured_category_widget() {
		
		$widget_ops = array( 
			'classname' => 'soundcheck_featured_category_widget', 
			'description' => __( 'Show latest posts from a category.', 'soundcheck' )
		);

		$control_ops = array( 
			'width' => 250, 
			'height' => 250, 
			'id_base' => 'soundcheck_featured_category_widget' 
		);

		$this->WP_Widget( 'soundcheck_featured_category_widget', __( 'Featured Category', 'soundcheck' ), $widget_ops, $control_ops ); 
	
	}
	
	
    function form( $instance ) {
    
	    $defaults = array(
			'title' => __( 'Latest Posts', 'soundcheck' ),
			'category' => '',
			'count' => 3,
			'date' => 0,
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
		
		// Category
		printf( '<p><label for="%2$s">%1$s</label><br />%3$s</p>',
			esc_html__( 'Category:', 'soundcheck' ),
			esc_attr( $this->get_field_id( 'category' ) ),
			wp_dropdown_categories( array( 
				'name' => $this->get_field_name( 'category' ), 
				'selected' => $instance['category'],
				'show_count' => 1,
				'class' => 'widefat',
				'echo' => 0
			) )
		);
		
		// Post Count
		printf( $text_option,
			esc_html__( 'Post Count:', 'soundcheck' ),
			esc_attr( $this->get_field_id( 'count' ) ),
			esc_attr( $this->get_field_name( 'count' ) ),
			esc_attr( absint( $instance['count'] ) )
		);
		
		// Excerpt Length
		printf( $text_option,
			esc_html__( 'Excerpt Length: (# of characters)', 'soundcheck' ),
			esc_attr( $this->get_field_id( 'excerpt' ) ),
			esc_attr( $this->get_field_name( 'excerpt' ) ),
			esc_attr( absint( $instance['excerpt'] ) )
		);
		
		// Post Excerpt
		printf( $checkbox_option, 
			esc_html__( 'Show post date?', 'soundcheck' ),
			esc_attr( $this->get_field_id( 'date' ) ),
			esc_attr( $this->get_field_name( 'date' ) ),
			checked( absint( $instance['date'] ), 1, false )
		);
		
		// Post Thumnbails
		printf( $checkbox_option, 
			esc_html__( 'Show post thumbnails?', 'soundcheck' ),
			esc_attr( $this->get_field_id( 'thumbnail' ) ),
			esc_attr( $this->get_field_name( 'thumbnail' ) ),
			checked( absint( $instance['thumbnail'] ), 1, false )
		);
		
    }
    
    
    function update( $new_instance, $old_instance ) {
		
		$instance = array();
		
		$instance['title']     = strip_tags( $new_instance['title'] );
		$instance['category']  = absint( $new_instance['category'] );
		$instance['count']     = absint( $new_instance['count'] );
		$instance['excerpt']   = absint( $new_instance['excerpt'] );
		$instance['date']      = isset( $new_instance['date'] ) ? 1 : 0;
		$instance['thumbnail'] = isset( $new_instance['thumbnail'] ) ? 1 : 0;

        return $instance;
        
    }
	
	
    function widget( $args, $instance ) {
    
		extract( $args );
		extract( $instance );
		
		$date = ( isset( $date ) ) ? $date : false;
		$thumbnail = ( isset( $thumbnail ) ) ? $thumbnail : false;
				
		if ( $title && ( isset( $category ) && $category != 0 ) ) {
			
			$category_info = get_category( $category );
			$category_link = get_category_link( $category_info->term_id );
			
			$title .= sprintf( '<span class="category"><a href="%1$s" title="%2$s">%3$s</a></span>',
				esc_url( $category_link ),
				esc_attr( __( 'View ', 'soundcheck' ) . $category_info->name ),
				sprintf(  __( '%s', 'soundcheck' ), $category_info->name )
			);
			
		}
		
		/* Get array of post info. */
		$cat_args = array(
			'cat' => $category,
			'posts_per_page' => $count
		);
		
		$cat_posts = new WP_Query( $cat_args );
		
		print $before_widget; 
		
		if ( $title ) {
			print $before_title;
			print $title;
			print $after_title;
		}
		?>
		
		<ul class="widget-content">
			<?php while ( $cat_posts->have_posts() ) : $cat_posts->the_post(); ?>
				<li>
					<article>
						<?php if ( $thumbnail && has_post_thumbnail() ) : ?>
						    <?php  
						    printf( '<figure><a href="%1$s" title="%2$s" class="entry-thumbnail %4$s">%3$s</a></figure>',
						    	esc_url( get_permalink() ),
						    	soundcheck_the_title_attribute(),
						    	get_the_post_thumbnail( get_the_ID(), 'theme-icon' ),
						    	$date ? 'alignright' : 'alignleft'
						    );
						    ?>
				  		<?php endif; ?>
				  		
						<?php if ( $date ) : ?>
							<time class="entry-date" datetime="<?php echo get_the_date(); ?>"><?php echo get_the_date(); ?></time>
						<?php endif;?>
						
						<div class="entry-content">
				  		
				  			<h4 class="entry-title">
				  				<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a>
				  			</h4>
				  			
							<?php if ( $excerpt ) : ?>
							<p>
				  				<?php echo soundcheck_limit_string( get_the_excerpt(), absint( $excerpt ) ); ?>
				  			</p>
				  			<?php endif; ?>
						</div><!-- .entry-content -->
					</article><!-- .entry -->
				</li>
			<?php endwhile; ?>
			
			<?php wp_reset_postdata(); ?>
			
		</ul><!-- .widget-content -->
		
		<footer class="widget-footer">
			<?php 
			printf( '<a href="%1$s" title="%2$s" class="button">%3$s</a>',
				esc_url( get_category_link( $category ) ),
				esc_attr__( 'View More', 'soundcheck' ),
				esc_html__( 'View More', 'soundcheck' )
			);
			?>
		</footer>
		
		<?php
		print $after_widget;
		
    }
    
}

?>