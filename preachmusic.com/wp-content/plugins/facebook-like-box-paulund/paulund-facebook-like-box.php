<?php
/*
 * Plugin Name: Paulund Facebook Like Box
 * Plugin URI: http://www.paulund.co.uk
 * Description: A widget that a facebook like box for your website
 * Version: 1.0
 * Author: Paul Underwood
 * Author URI: http://www.paulund.co.uk
 * License: GPL2 

    Copyright 2012  Paul Underwood

    This program is free software; you can redistribute it and/or
    modify it under the terms of the GNU General Public License,
    version 2, as published by the Free Software Foundation. 

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details. 
*/

/**
 * Register the Widget
 */
add_action( 'widgets_init', create_function( '', 'register_widget("pu_facebook_widget");' ) ); 

/**
 * Create the widget class and extend from the WP_Widget
 */
 class pu_facebook_widget extends WP_Widget {
 	
	/**
	 * Set the widget defaults
	 */
	private $widget_title = "Like me";
	private $facebook_id = "244325275637598";
	private $facebook_username = "paulundcouk";
	private $facebook_width = "292";
	private $facebook_show_faces = "true";
	private	$facebook_stream = "false";
	private	$facebook_header = "true";
	private $facebook_border_color = "#FFF";
 	
	/**
	 * Register widget with WordPress.
	 */
	public function __construct() {
		
		parent::__construct(
			'pu_facebook_widget',		// Base ID
			'Facebook Like Box',		// Name
			array(
				'classname'		=>	'pu_facebook_widget',
				'description'	=>	__('A widget that displays a facebook like box from your facebook page.', 'framework')
			)
		);

		// Load JavaScript and stylesheets
		$this->register_scripts_and_styles();

	} // end constructor
	
	/**
	 * Registers and enqueues stylesheets for the administration panel and the
	 * public facing site.
	 */
	public function register_scripts_and_styles() {
		
		

	} // end register_scripts_and_styles
	
	/**
	 * Add Facebook javascripts
	 */
	public function add_js(){
		echo '<div id="fb-root"></div>
				<script>(function(d, s, id) {
				  var js, fjs = d.getElementsByTagName(s)[0];
				  if (d.getElementById(id)) return;
				  js = d.createElement(s); js.id = id;
				  js.src = "//connect.facebook.net/en_GB/all.js#xfbml=1&appId='.$this->facebook_id.'";
				  fjs.parentNode.insertBefore(js, fjs);
				}(document, \'script\', \'facebook-jssdk\'));</script>';
	}

	
	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget( $args, $instance ) {
		extract( $args );

		/* Our variables from the widget settings. */
		$this->widget_title = apply_filters('widget_title', $instance['title'] );
		
		$this->facebook_id = $instance['app_id'];
		$this->facebook_username = $instance['page_name'];
		$this->facebook_width = $instance['width'];
		$this->facebook_show_faces = ($instance['show_faces'] == "1" ? "true" : "false");
		$this->facebook_stream = ($instance['show_stream'] == "1" ? "true" : "false");
		$this->facebook_header = ($instance['show_header'] == "1" ? "true" : "false");
		$this->facebook_border_color = $instance['border_color'];
		
		add_action('wp_footer', array(&$this,'add_js'));

		/* Before widget (defined by themes). */
		echo $before_widget;

		/* Display the widget title if one was input (before and after defined by themes). */
		if ( $this->widget_title )
			echo $before_title . $this->widget_title . $after_title;

		/* Like Box */
		 ?>
            <div class="fb-like-box" 
            	data-href="http://www.facebook.com/<?php echo $this->facebook_username; ?>" 
            	data-width="<?php echo $this->facebook_width; ?>" 
            	data-show-faces="<?php echo $this->facebook_show_faces; ?>" 
            	data-stream="<?php echo $this->facebook_stream; ?>" 
            	data-header="<?php echo $this->facebook_header; ?>"
            	data-border-color="<?php echo $this->facebook_border_color; ?>"></div>
		<?php 

		/* After widget (defined by themes). */
		echo $after_widget;
	}

	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		/* Strip tags for title and name to remove HTML (important for text inputs). */
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['app_id'] = strip_tags( $new_instance['app_id'] );
		$instance['page_name'] = strip_tags( $new_instance['page_name'] );
		$instance['width'] = strip_tags( $new_instance['width'] );
		$instance['border_color'] = strip_tags( $new_instance['border_color'] );
		
		$instance['show_faces'] = (bool)$new_instance['show_faces'];
		$instance['show_stream'] = (bool)$new_instance['show_stream'];
		$instance['show_header'] = (bool)$new_instance['show_header'];

		return $instance;
	}
	
	/**
	 * Create the form for the Widget admin
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */	 
	function form( $instance ) {

		/* Set up some default widget settings. */
		$defaults = array(
		'title' => $this->widget_title,
		'app_id' => $this->facebook_id,
		'page_name' => $this->facebook_username,
		'width' => $this->facebook_width,
		'show_faces' => $this->facebook_show_faces,
		'show_stream' => $this->facebook_stream,
		'show_header' => $this->facebook_header,
        'border_color' => $this->border_color
		);
		
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<!-- Widget Title: Text Input -->
		<p>


			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'framework') ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" />
		</p>

		<!-- App id: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'app_id' ); ?>"><?php _e('App Id', 'framework') ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'app_id' ); ?>" name="<?php echo $this->get_field_name( 'app_id' ); ?>" value="<?php echo $instance['app_id']; ?>" />
		</p>
		
		<!-- Page name: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'page_name' ); ?>"><?php _e('Page name (http://www.facebook.com/[page_name])', 'framework') ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'page_name' ); ?>" name="<?php echo $this->get_field_name( 'page_name' ); ?>" value="<?php echo $instance['page_name']; ?>" />
		</p>
		
		<!-- Width: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'width' ); ?>"><?php _e('Width', 'framework') ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'width' ); ?>" name="<?php echo $this->get_field_name( 'width' ); ?>" value="<?php echo $instance['width']; ?>" />
		</p>
		
		<!-- Border color: Text Input -->
        <p>
            <label for="<?php echo $this->get_field_id( 'border_color' ); ?>"><?php _e('Border color', 'framework') ?></label>
            <input type="text" class="widefat" id="<?php echo $this->get_field_id( 'border_color' ); ?>" name="<?php echo $this->get_field_name( 'border_color' ); ?>" value="<?php echo $instance['border_color']; ?>" />
        </p>
		
		<!-- Show Faces: Checkbox -->
		<p>
			<label for="<?php echo $this->get_field_id( 'show_faces' ); ?>"><?php _e('Show Faces', 'framework') ?></label>
			<input type="checkbox" class="widefat" id="<?php echo $this->get_field_id( 'show_faces' ); ?>" name="<?php echo $this->get_field_name( 'show_faces' ); ?>" value="1" <?php echo ($instance['show_faces'] == "true" ? "checked='checked'" : ""); ?> />
		</p>
		
		<!-- Show Stream: Checkbox -->
		<p>
			<label for="<?php echo $this->get_field_id( 'show_stream' ); ?>"><?php _e('Show Stream', 'framework') ?></label>
			<input type="checkbox" class="widefat" id="<?php echo $this->get_field_id( 'show_stream' ); ?>" name="<?php echo $this->get_field_name( 'show_stream' ); ?>" value="1" <?php echo ($instance['show_stream'] == "true" ? "checked='checked'" : ""); ?> />
		</p>
		
		<!-- Show Header: Checkbox -->
		<p>
			<label for="<?php echo $this->get_field_id( 'show_header' ); ?>"><?php _e('Show Header', 'framework') ?></label>
			<input type="checkbox" class="widefat" id="<?php echo $this->get_field_id( 'show_header' ); ?>" name="<?php echo $this->get_field_name( 'show_header' ); ?>" value="1" <?php echo ($instance['show_header'] == "true" ? "checked='checked'" : ""); ?> />
		</p>
		
	<?php
	}
 }
?>