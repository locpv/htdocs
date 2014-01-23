<?php
/**
 * Plugin Name: Featured Category
 * Plugin URI: http://www.celtic7.com
 * Description: Shows latest posts for a category
 * Version: 0.2
 * Author: Luke McDonald
 * Author URI: http://lukemcdonald.com
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 */

/**
 * Add function to widgets_init that'll load our widget.
 *
 * @since 0.1
 */
add_action( 'widgets_init', 'ti_featured_category_load_widgets' );

/**
 * Register widget.
 *
 * @since 0.1
 */
function ti_featured_category_load_widgets() {
	register_widget( 'c7s_Featured_Category' );
}

/**
 * Widget class.
 *
 * This class handles everything that needs to be handled with the widget:
 * the settings, form, display, and update. Nice!
 *
 * @since 0.1
 */
class c7s_Featured_Category extends WP_Widget {

	/**
	 * Widget setup.
	 */
	function c7s_Featured_Category() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'ti-featured-category', 'description' => __( '(2 Col) Show latest posts from a category.', 'theme-it' ) );

		/* Widget control settings. */
		$control_ops = array( 'width' => 250, 'height' => 300, 'id_base' => 'c7s-featured-category' );

		/* Create the widget. */
		$this->WP_Widget( 'c7s-featured-category', __( 'Featured Category', 'theme-it' ), $widget_ops, $control_ops );
	}

	/**
	 * How to display the widget on the screen.
	 */
	function widget( $args, $instance ) {
		
		extract( $args );

		/* Our variables from the widget settings. */
		$title = $instance['title'];
		$cat = $instance['cat'];
		$page = $instance['page'];
		$num = $instance['num'];
		$image = $instance['image'];
		
		if ( $title && ( isset( $cat ) && $cat != 0 ) ) {
			$category_info = get_category( $cat );
			$category_link = get_category_link( $category_info->term_id );
			$title .= '<span class="category"><a href="' . esc_url( $category_link ) . '">' . __( $category_info->name, 'theme-it' ) . '</a></span>';
		}
		
		/* Get array of post info. */
		$cat_args = array(
			'cat' => $cat,
			'posts_per_page' => $num,
		);
		
		$cat_posts = new WP_Query( $cat_args );
		
		/* Before widget ( defined by themes ). */
		echo $before_widget; 
		
		/* Display the widget title if one was input ( before and after defined by themes ). */
		if ( $title )
			echo $before_title . $title . $after_title; ?>
		
		<ul class="widget-content">
		
		<?php while ( $cat_posts->have_posts() ) : $cat_posts->the_post(); ?>
			
			<li>
				<article id="post-<?php the_ID(); ?>" <?php post_class() ?>>
					<time class="entry-date" datetime="<?php the_time( 'm-d-Y') ?>"><?php the_time( 'm/d/y') ?></time>
					
					<div class="entry-content">
						<?php if ( $image && has_post_thumbnail() ) :
							$title_length = 45;
							$excerpt_length = 50; ?>
							
			  			<figure>
			  				<a class="entry-thumbnail" href="<?php the_permalink() ?>">
			  					<?php the_post_thumbnail( 'theme-icon' ); ?>
			  				</a>
			  			</figure><!-- .entry-thumbnail -->
			  		
			  		<?php else :
							$title_length = 55;
			  			$excerpt_length = 60;
			  		endif; // end $image and post thumbnail check ?>
			  		
			  		<span class="entry-title">
			  			<a href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>"><?php do_action( 'limit_string', get_the_title(), $title_length, true ) ?></a>
			  		</span>
			  		
			  		<p><?php apply_filters( 'limit_string', get_the_excerpt(), $excerpt_length, true ) ?></p>
					</div><!-- .entry-content -->
				</article><!-- .entry -->
			</li>
			
		<?php endwhile; // end loop 
		
		wp_reset_query();?>
		
		</ul><!-- .widget-content -->
		
		<footer class="widget-footer">
			<?php 
			if ( $cat )
				$all_post_link = get_category_link( $cat );
			else
				$all_post_link = get_page_link( $page );
			?>
		  <a href="<?php echo esc_url( $all_post_link ) ?>" class="button"><?php _e( 'View All Posts', 'theme-it' ); ?></a>
		</footer>

		<?php /* After widget ( defined by themes ). */
		echo $after_widget;
	}

	/**
	 * Update the widget settings.
	 */
	function update( $new_instance, $old_instance ) {
		
		$instance = $old_instance;
		
		$instance['title'] = esc_html( $new_instance['title'] );
		$instance['cat'] = esc_html( $new_instance['cat'] );
		$instance['page'] = esc_html( $new_instance['page'] );
		$instance['num'] = absint( $new_instance['num'] );
		$instance['image'] = strip_tags( $new_instance['image'] );

		return $instance;
	}

	/**
	 * Displays the widget settings controls on the widget panel.
	 * Make use of the get_field_id() and get_field_name() function
	 * when creating your form elements. This handles the confusing stuff.
	 */
	function form( $instance ) {

		/* Set up some default widget settings. */
		$defaults = array(
			'title' => __( 'Latest Posts', 'theme-it' ),
			'cat' => '',
			'page' => '',
			'image' => '',
			'num' => absint( 3 ) 
		 );
		
		$instance = wp_parse_args( ( array ) $instance, $defaults ); ?>
		
		
		<!-- Title: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'theme-it' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" type="text" />
		</p>
		
		<p><?php _e( 'Choose a category to feature. If a category is not chosen, all posts will be shown.', 'theme-it' ); ?></p>
		<!-- Categories: Select Box -->
		<p>
			<label for="<?php echo $this->get_field_id( 'cat' ); ?>"><?php _e( 'Category:', 'theme-it' ); ?></label> 
			<?php wp_dropdown_categories( array( 
				'name' => $this->get_field_name( 'cat' ), 
				'selected' => $instance['cat'],
				'show_option_all' => 'All Categories'
			) ); ?>
		</p>
		
		<p><?php _e( 'If a category is not chosen above, we need to link the "View all Posts" button to a blog page. Select a page below.', 'theme-it' ); ?></p>
		<!-- Page: Select Box -->
		<p>
			<label for="<?php echo $this->get_field_id( 'page' ); ?>"><?php _e( 'Page:', 'theme-it' ); ?></label> 
			<?php wp_dropdown_pages( array( 
				'name' => $this->get_field_name( 'page' ), 
				'selected' => $instance['page'] 
			) ); ?>
		</p>

		
		<!-- Number Of Posts: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'num' ); ?>"><?php _e( 'Number of posts to show', 'theme-it' ); ?>:</label>
			<input id="<?php echo $this->get_field_id( 'num' ); ?>" name="<?php echo $this->get_field_name( 'num' ); ?>" value="<?php echo absint( $instance['num'] ); ?>" type="text" size="3" style="text-align: center" />
		</p>
		
		<!-- Images: Checkbox -->
		<p>
			<label for="<?php echo $this->get_field_id( 'image' ); ?>">
				<input type='checkbox' class='checkbox' id='<?php echo $this->get_field_id( 'image' ); ?>' name='<?php echo $this->get_field_name( 'image' ); ?>'<?php checked( ( bool ) $instance['image'], true ); ?> /> <?php _e( 'Show post thumbnails?', 'theme-it' ); ?>
			</label> 
		</p>

	<?php
	}
}

?>