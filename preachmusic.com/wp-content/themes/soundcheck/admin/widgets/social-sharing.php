<?php
/**
 * Plugin Name: Featured Image Carousel
 * Plugin URI: http://www.celtic7.com
 * Description: Shows latest posts for a category
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
add_action( 'widgets_init', 'c7s_social_sharing_load_widgets' );

/**
 * Register widget.
 *
 * @since 0.1
 */
function c7s_social_sharing_load_widgets() {
	register_widget( 'c7s_Social_Sharing' );
}

/**
 * Widget class.
 *
 * This class handles everything that needs to be handled with the widget:
 * the settings, form, display, and update.  Nice!
 *
 * @since 0.1
 */
class c7s_Social_Sharing extends WP_Widget {

	/**
	 * Widget setup.
	 */
	function c7s_Social_Sharing() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'ti-social-sharing', 'description' => __( 'Facebook, Twitter, Google +1, and Email sharing links.', 'theme-it' ) );

		/* Widget control settings. */
		$control_ops = array( 'width' => 250, 'height' => 300, 'id_base' => 'c7s-social-sharing' );

		/* Create the widget. */
		$this->WP_Widget( 'c7s-social-sharing', __( 'Social Sharing', 'theme-it' ), $widget_ops, $control_ops );
	}
	
	/**
	 * How to display the widget on the screen.
	 */
	function widget( $args, $instance ) {
		
		extract( $args );
		
		/* Before widget ( defined by themes ). */
		echo $before_widget; ?>
		
		<ul class="sharing-buttons">
		  
		  <li class="facebook-send">
		    <div id="fb-root"></div>
		    	<script>(function(d){
		    	  var js, id = 'facebook-jssdk'; if (d.getElementById(id)) {return;}
		    	  js = d.createElement('script'); js.id = id; js.async = true;
		    	  js.src = "//connect.facebook.net/en_US/all.js#appId=231736140209773&xfbml=1";
		    	  d.getElementsByTagName('head')[0].appendChild(js);
		    	}(document));</script>
		    	<div class="fb-like" data-href="<?php the_permalink() ?>" data-send="false" data-layout="button_count" data-width="450" data-show-faces="true"></div>
		  </li><!-- .facebook-send -->
		  
		  <li class="twitter-button">
		    <a href="http://twitter.com/share" class="twitter-share-button" data-count="none" data-via="<?php esc_attr( ti_get_option( 'social_twitter' ) ) ?>"><?php _e( 'Tweet', 'theme-it' ); ?></a>
		    <script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>
		  </li><!-- .twitter-button -->
		  
		  <li class="google-plus">
		    <!-- <script type="text/javascript" src="https://apis.google.com/js/plusone.js"></script>
		    <g:plusone size="medium"></g:plusone>
		    Place this tag where you want the +1 button to render -->
		      <g:plusone size="medium"></g:plusone>
		      
		      <!--  Place this tag after the last plusone tag -->
		      <script type="text/javascript">
		        (function() {
		          var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
		          po.src = 'https://apis.google.com/js/plusone.js';
		          var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
		        })();
		      </script>
		  </li><!-- .google-plus -->

		  <li class="email-this">
		    <a href="mailto:?subject=<?php echo rawurlencode( get_the_title() ) . '&amp;body=' . rawurlencode( 'In regards to: ' ) . rawurlencode( get_the_title() ) . ' &ndash; ' . get_permalink(); ?>" title="<?php esc_attr_e( 'Email ', 'theme-it' ) . esc_attr__( the_title_attribute() ); ?>"><!-- nothing to see here, email this --></a>
		  </li><!-- .email-this -->
		
		</ul><!-- .sharing-buttons -->
		
		<div class="clearfix"><!-- nothing to see here --></div>
		
		<?php echo $after_widget; /* After widget ( defined by themes ). */
		
	}
}

?>