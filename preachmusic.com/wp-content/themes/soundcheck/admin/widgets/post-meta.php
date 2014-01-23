<?php
/**
 * Plugin Name: Post Meta
 * Plugin URI: http://www.celtic7.com
 * Description: Display post/page meta information
 * Version: 0.1
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
add_action( 'widgets_init', 'ti_post_meta_load_widgets' );

/**
 * Register widget.
 *
 * @since 0.1
 */
function ti_post_meta_load_widgets() {
	register_widget( 'Post_Meta_Details' );
}

/**
 * Widget class.
 *
 * This class handles everything that needs to be handled with the widget:
 * the settings, form, display, and update. Nice!
 *
 * @since 0.1
 */
class Post_Meta_Details extends WP_Widget {

	/**
	 * Widget setup.
	 */
	function Post_Meta_Details() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'ti-post-meta-widget', 'description' => __( 'Display post/page meta information.', 'theme-it' ) );

		/* Widget control settings. */
		$control_ops = array( 'width' => 250, 'height' => 300, 'id_base' => 'c7s-post-meta-widget' );

		/* Create the widget. */
		$this->WP_Widget( 'c7s-post-meta-widget', __( 'Meta: Post &amp; Page ', 'theme-it' ), $widget_ops, $control_ops );
	}


	/**
	 * How to display the widget on the screen.
	 */
	function widget( $args, $instance ) {

		if ( is_singular() && ! is_page_template() ) {
			
			global $post, $media_embed;
			
			extract( $args );
			
			/* Our variables from the widget settings. */
			$title = $instance['title'];
			$image = $instance['image'];
			$date = $instance['date'];
			$author = $instance['author'];
			$comments = $instance['comments'];
			$cats = $instance['categories'];
			$tags = $instance['tags'];
	
			$format = get_post_format();
		
			$cats_list = get_the_category_list( ', ' );
			$tags_list = get_the_tag_list( '', ', ' );
			
			$toggle_class = ( $image && ( has_post_thumbnail() || has_media_embed() ) ) ? ' active' : '';
			
			if ( has_post_thumbnail() && ! $format )
				$title .= '<span class="thumbnail-trigger' . $toggle_class . '"><a class="tooltip" href="#" title="Thumbnail"></a></span>';
			
			/* Before widget ( defined by themes ). */
			echo $before_widget; 
			
			/* Display the widget title if one was input ( before and after defined by themes ). */
			if ( $title )
				echo $before_title . $title . $after_title; ?>
			
			<?php if ( has_post_thumbnail() && ! $format ) : ?>

			  <figure class="entry-thumbnail">
			  
			    <?php the_post_thumbnail() ?>

			  </figure><!-- .entry-thumbnail -->
			  
			  <script type="text/javascript">
			  //<![CDATA[
			  	jQuery(function($)
			  	{
			  		<?php if ( ! $image ) : ?>
			  			$('.c7s-post-meta-widget .entry-thumbnail').hide();
			  		<?php endif; ?>
			  		
			  		$('.thumbnail-trigger').click(function() {
			  			$(this).toggleClass('active');
			  			$('.c7s-post-meta-widget .entry-thumbnail').slideToggle('fast');
			  			return false;
			  		});
			  	})
			  //]]>
			  </script>
			  
			<?php endif; // end thumbnail and media check ?>
			  
			<div class="widget-content">
				
			  <ul class="entry-meta">
			  	
			  	<?php if ( $date || $author || $comments ) :  ?>
			  		<li>
			  			<?php if ( $date ) : ?>
			  				<time class="date" pubdate="<?php echo get_the_date( 'Y-m-d' ) ?>"><?php echo get_the_date( 'm/d/y' ) ?></time>
			  			<?php endif; ?>
			  			
			  			<div class="meta-content">
			  				<?php if ( $author ) : ?>
			  					<span class="author"><?php echo esc_html( get_the_author() ) ?></span>
			  				<?php endif; ?>
			  					
			  				<?php if ( $comments && comments_open() ) : ?>
			  					<a class="comments" href="#comments" title="Go to start of comments"><?php comments_number(); ?></a>
			  				<?php endif; ?>
			  			</div><!-- .meta-content -->
			  			
			  			<div class="clearfix"><!-- nothing to see here --></div>
			  		</li>
			  	<?php endif; ?>
			  	
			  	<?php if ( $cats && ! empty( $cats_list ) || $tags && ! empty( $tags_list ) ) : ?>
			  		<li>
			  			<span class="utility-title">Type</span>
			  			<div class="meta-content">
			  				<?php if ( $cats && ! empty( $cats_list ) ) : ?>
			  					<span class="categories"><?php echo $cats_list ?></span>
			  				<?php endif; ?>
			  				
			  				<?php if ( $tags && ! empty( $tags_list ) ) : ?>
			  					<span class="tags"><?php echo $tags_list ?></span>
			  				<?php endif; ?>
			  			</div><!-- .meta-content -->
			  		</li>
			  	<?php endif; ?>
			  </ul><!-- .entry-meta -->
			</div><!-- .entry-content -->
				
			<?php /* After widget ( defined by themes ). */
			
			echo $after_widget;
		
		} else {
			function ti_entry_header_post_meta( $output ) {
				$cats_list = get_the_category_list( ' / ' );
				$tags_list = get_the_tag_list( '', ' / ' );
				
			  $output .= '<ul class="entry-meta">';
					
					//if ( $date )
						$output .= '<li class="date">' . get_the_date( 'm/d/y' ) . '</li>';
			  	
					//if ( $author )
						$output .= '<li class="author">' . esc_html( get_the_author() ) . '</li>';
					
					//if ( $cats && ! empty( $cats_list ) )
			  		$output .= '<li class="categories"> / ' . $cats_list . '</li>';
			  	
					//if ( $tags && ! empty( $tags_list ) )
			  		$output .= '<li class="tags"> / ' . $tags_list . '</li>';

			  $output .= '</ul>';
			  
			  echo $output;
			}
			add_filter( 'ti_entry_header', 'ti_entry_header_post_meta' );
		}
	}

	/**
	 * Update the widget settings.
	 */
	function update( $new_instance, $old_instance ) {
		
		$instance = $old_instance;
		
		$instance['title'] = esc_html( $new_instance['title'] );
		$instance['image'] = $new_instance['image'];
		$instance['date'] = $new_instance['date'];
		$instance['author'] = $new_instance['author'];
		$instance['comments'] = $new_instance['comments'];
		$instance['categories'] = $new_instance['categories'];
		$instance['tags'] = $new_instance['tags'];

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
			'title' => __( 'Post Details', 'theme-it' ),
			'image' => 1,
			'date' => 1,
			'author' => 1,
			'comments' => 1,
			'categories' => 1,
			'tags' => 1
		 );
		
		$instance = wp_parse_args( ( array ) $instance, $defaults ); ?>
		
		
		<!-- Title: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'theme-it' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" type="text" />
		</p>
		
		<!-- Images: Checkbox -->
		<p>
			<label for="<?php echo $this->get_field_id( 'image' ); ?>">
				<input type='checkbox' class='checkbox' id='<?php echo $this->get_field_id( 'image' ); ?>' name='<?php echo $this->get_field_name( 'image' ); ?>'<?php checked( ( bool ) $instance['image'], true ); ?> /> <?php _e( 'Show thumbnail?', 'theme-it' ); ?>
			</label> 
		</p>

		<!-- Date: Checkbox -->
		<p>
			<label for="<?php echo $this->get_field_id( 'date' ); ?>">
				<input type='checkbox' class='checkbox' id='<?php echo $this->get_field_id( 'date' ); ?>' name='<?php echo $this->get_field_name( 'date' ); ?>'<?php checked( ( bool ) $instance['date'], true ); ?> /> <?php _e( 'Show date?', 'theme-it' ); ?>
			</label> 
		</p>

		<!-- Author: Checkbox -->
		<p>
			<label for="<?php echo $this->get_field_id( 'author' ); ?>">
				<input type='checkbox' class='checkbox' id='<?php echo $this->get_field_id( 'author' ); ?>' name='<?php echo $this->get_field_name( 'author' ); ?>'<?php checked( ( bool ) $instance['author'], true ); ?> /> <?php _e( 'Show author?', 'theme-it' ); ?>
			</label> 
		</p>

		<!-- Comments: Checkbox -->
		<p>
			<label for="<?php echo $this->get_field_id( 'comments' ); ?>">
				<input type='checkbox' class='checkbox' id='<?php echo $this->get_field_id( 'comments' ); ?>' name='<?php echo $this->get_field_name( 'comments' ); ?>'<?php checked( ( bool ) $instance['comments'], true ); ?> /> <?php _e( 'Show comment count?', 'theme-it' ); ?>
			</label> 
		</p>

		<!-- Categories: Checkbox -->
		<p>
			<label for="<?php echo $this->get_field_id( 'categories' ); ?>">
				<input type='checkbox' class='checkbox' id='<?php echo $this->get_field_id( 'categories' ); ?>' name='<?php echo $this->get_field_name( 'categories' ); ?>'<?php checked( ( bool ) $instance['categories'], true ); ?> /> <?php _e( 'Show categories?', 'theme-it' ); ?>
			</label> 
		</p>

		<!-- Tags: Checkbox -->
		<p>
			<label for="<?php echo $this->get_field_id( 'tags' ); ?>">
				<input type='checkbox' class='checkbox' id='<?php echo $this->get_field_id( 'tags' ); ?>' name='<?php echo $this->get_field_name( 'tags' ); ?>'<?php checked( ( bool ) $instance['tags'], true ); ?> /> <?php _e( 'Show tags?', 'theme-it' ); ?>
			</label> 
		</p>

	<?php
	}
}

?>