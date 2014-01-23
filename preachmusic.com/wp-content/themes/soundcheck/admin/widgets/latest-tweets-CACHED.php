<?php
/**
 * Plugin Name: Latest Tweets
 * Plugin URI: http://www.celtic7.com
 * Description: Display latest tweet
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
add_action( 'widgets_init', 'ti_latest_tweets_load_widgets' );

/**
 * Register widget.
 *
 * @since 0.1
 */
function ti_latest_tweets_load_widgets() {
	register_widget( 'Latest_Tweets' );
}

/**
 * Widget class.
 *
 * This class handles everything that needs to be handled with the widget:
 * the settings, form, display, and update.  Nice!
 *
 * @since 0.1
 */
class Latest_Tweets extends WP_Widget {

	/**
	 * Widget setup.
	 */
	function Latest_Tweets() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'ti-latest-tweets', 'description' => __( 'Display latest tweet.', 'theme-it' ) );

		/* Widget control settings. */
		$control_ops = array( 'width' => 250, 'height' => 300, 'id_base' => 'c7s-latest-tweets' );

		/* Create the widget. */
		$this->WP_Widget( 'c7s-latest-tweets', __( 'Latest Tweet', 'theme-it' ), $widget_ops, $control_ops );
	}
	
	/**
	 * How to display the widget on the screen.
	 */
	function widget( $args, $instance ) {
	
		extract( $args );

		/* Our variables from the widget settings. */
		$title = $instance['title'];
		$twitter_name = $instance['name'];
		$username = $instance['usernames'];
		$twitter_id = $instance['usernames'];
		$transient_name = 'list_tweets_' . $twitter_id; // Name of value in database.
		$count = 1;
		$cache_time = $instance['cache_mins']; // Time in minutes between updates.
		
		
		/**
		 * JSON list of tweets using: 
		 * http://dev.twitter.com/doc/get/statuses/user_timeline
		 *         
		 * Cached using WP transient API:
		 * http://www.problogdesign.com/wordpress/use-the-transients-api-to-list-the-latest-commenter/
		 */
		if( ! empty( $twitter_id ) ) :
			
			// Do we already have saved tweet data? If not, lets get it.
			if( false === ( $tweets = get_transient( $transient_name ) ) ) :    
			
				// Get the tweets from Twitter.
				$json = wp_remote_get( 'http://api.twitter.com/1/statuses/user_timeline.json?screen_name=' . $twitter_id . '&count=' . $count );
				
				if ( ! is_wp_error( $json ) ) :
					// Get tweets into an array.
					$twitter_data = json_decode( $json['body'], true );
					
					// Now update the array to store just what we need.
					// (Done here instead of PHP doing this for every page load)
					foreach ( $twitter_data as $tweet ) :
						// Core info.
						$twitter_id = $tweet['user']['name'];
						$permalink = 'http://twitter.com/#!/'. $twitter_id .'/status/'. $tweet['id_str'];
						
						/* Alternative image sizes method: http://dev.twitter.com/doc/get/users/profile_image/:screen_name */
						$image = $tweet['user']['profile_image_url'];
						
						// Message. Convert links to real links.
						$pattern = '/http:(\S)+/';
						$replace = '<a href="${0}" target="_blank" rel="nofollow">${0}</a>';
						$text = preg_replace( $pattern, $replace, $tweet['text'] );
						
						// Need to get time in Unix format.
						$time = $tweet['created_at'];
						$time = date_parse( $time );
						$uTime = mktime( $time['hour'], $time['minute'], $time['second'], $time['month'], $time['day'], $time['year'] );
						
						// Now make the new array.
						$tweets[] = array(
							'text' => $text,
							'name' => $twitter_id,
							'permalink' => $permalink,
							'image' => $image,
							'time' => $uTime
						);
					endforeach; // end $twitter_data foreach loop
				endif; // end is_wp_error() check
			    
				// Save our new transient.
				set_transient( $transient_name, $tweets, 60 * absint( $cache_time ) );
			endif; // end get_transient check


			/* Before widget ( defined by themes ). */
			echo $before_widget; 
			
			/* Display the widget title if one was input ( before and after defined by themes ). */
			if ( $title )
				echo $before_title . $title . $after_title; ?>
			
			<div class="widget-content">
			
				<header class="user-details">
					<?php $profile_img = 'https://api.twitter.com/1/users/profile_image/' . urlencode( $username ) . '/'; ?>
					
  				<a class="gravatar" href="http://twitter.com/#!/<?php echo urlencode( $username ) ?>" target="_blank">
  				  <img src="<?php echo esc_url( $profile_img ); ?>" width="48" height="48" alt="<?php esc_attr_e( $username ) ?>" />
  				</a>
  				
					<span class="name"><?php echo esc_html__( $twitter_name, 'theme-it' ) ?></span>
					
					<a class="username tooltip" href="http://twitter.com/#!/<?php echo urlencode( $username ) ?>" title="<?php _e( 'View Profile', 'theme-it' ) ?>" target="_blank">
					  @<?php echo $username ?>
					</a>
				</header>  
				
				<ul class="tweets">
					<?php
					if( ! empty( $tweets ) ) :
						// Now display the tweets.
						foreach( $tweets as $t ) : ?>
							<li>
								<p class="tweet">
								  <?php 
								  $tweet_text = $t['text'];
									$tweet_text = preg_replace( '#@([\\d\\w]+)#', '<a href="http://twitter.com/$1">$0</a>', $tweet_text );
									$tweet_text = preg_replace( '/#([\\d\\w]+)/', '<a href="http://twitter.com/#search?q=%23$1">$0</a>', $tweet_text );
								  echo $tweet_text; 
								  ?>
								  <small class="tweet-time"><?php echo human_time_diff( $t['time'], current_time( 'timestamp' ) ); ?> <?php _e( 'ago', 'theme-it' ); ?></small>
								</p>
							</li>
						<?php endforeach; ?>
					
					<?php else : ?>
						
						<p><?php _e( 'Tweets are empty.', 'theme-it' ); ?></p>
					
					<?php endif; ?>
				</ul>
				
			</div><!-- .widget-content -->
			
			<footer class="widget-footer">
			  
			  <a href="http://twitter.com/#!/<?php echo urlencode( $username ) ?>" class="twitter-follow-button" data-button="grey" data-text-color="#FFFFFF" data-link-color="#00AEFF" data-show-count="false"><?php _e( 'Follow', 'theme-it' ); ?> @<?php echo esc_html( $username ) ?></a>
			  
			  <script src="http://platform.twitter.com/widgets.js" type="text/javascript"></script>
			
			</footer><!-- .widget-footer -->
			
			<?php /* After widget ( defined by themes ). */

			echo $after_widget;
		
		else: // no $twitter_id entered ?>
			
			<h3><?php _e( 'Latest Tweet Widget', 'theme-it' ); ?></h3>
			<p><?php _e( 'A username must be set for this widget.', 'theme-it' ); ?></p>
			
		<?php
		endif; // end $twitter_id check
	}

	/**
	 * Update the widget settings.
	 */
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['name'] = strip_tags( $new_instance['name'] );
		$instance['usernames'] = strip_tags( $new_instance['usernames'] );
		$instance['cache_mins'] = absint( $new_instance['cache_mins'] );
		
		return $instance;
	}

	/**
	 * Displays the widget settings controls on the widget panel.
	 * Make use of the get_field_id() and get_field_name() function
	 * when creating your form elements. This handles the confusing stuff.
	 */
	function form( $instance ) {
		
		global $current_user;
		get_currentuserinfo();
		
		$current_user_displayname = ( $current_user->display_name ) ? $current_user->display_name : 'Luke McDonald';
		
		/* Set up some default widget settings. */
		$defaults = array( 
			'title' => __( 'Latest Tweet', 'theme-it' ),
			'name' => $current_user_displayname,
			'usernames' => '',
			'cache_mins' => 5
		 );
		
		$instance = wp_parse_args( ( array ) $instance, $defaults ); ?>
		
		
		<!-- Title: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'theme-it' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" type="text" />
		</p>
		
		<!-- Name: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'name' ); ?>"><?php _e( 'Name:', 'theme-it' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'name' ); ?>" name="<?php echo $this->get_field_name( 'name' ); ?>" value="<?php echo $instance['name']; ?>" type="text" />
		</p>

		<!-- Username: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'usernames' ); ?>"><?php _e( 'Twitter Username', 'theme-it' ); ?>:</label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'usernames' ); ?>" name="<?php echo $this->get_field_name( 'usernames' ); ?>" value="<?php echo $instance['usernames']; ?>" type="text" />
		</p>
		
		<!-- Cache Time: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'cache_mins' ); ?>"><?php _e( 'Cache Time:', 'theme-it' ); ?></label>
			<input id="<?php echo $this->get_field_id( 'cache_mins' ); ?>" name="<?php echo $this->get_field_name( 'cache_mins' ); ?>" value="<?php echo $instance['cache_mins']; ?>" type="text" size="3" style="text-align: center" /> <?php _e( 'minutes', 'theme-it' ); ?>
		</p>
		
		
	<?php
	}
}

?>