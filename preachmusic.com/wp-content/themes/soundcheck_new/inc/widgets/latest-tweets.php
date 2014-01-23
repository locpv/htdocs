<?php
/**
 * Adds the Latest tweets widget.
 *
 * @package soundcheck
 * @subpackage Widgets
 * @since 2.0.0
 */

add_action( 'widgets_init', 'soundcheck_latest_tweets_widget_load' );

function soundcheck_latest_tweets_widget_load() { 

	register_widget( 'soundcheck_latest_tweets_widget' );
	
}


class Soundcheck_Latest_Tweets_Widget extends WP_Widget {

	function Soundcheck_Latest_Tweets_Widget() {
	
		$widget_ops = array( 
			'classname' => 'soundcheck_latest_tweets_widget', 
			'description' => __( 'Display a list of your latest tweets', 'soundcheck' ) 
		 );
		$control_ops = array( 
			'width' => 200, 
			'height' => 250, 
			'id_base' => 'soundcheck_latest_tweets_widget' 
		 );
		$this->WP_Widget( 'soundcheck_latest_tweets_widget', __( 'Latest Tweets', 'soundcheck' ), $widget_ops, $control_ops );
		
	}
	
	
	function form( $instance ) {

		$instance = wp_parse_args( ( array )$instance, array( 
			'title'                => '',
			'name'                 => '',
			'twitter_id'           => '',
			'twitter_num'          => '',
			'twitter_duration'     => '',
			'twitter_hide_replies' => 0,
			'follow_link_show'     => 0
		 ) );
		 
	    $text_input = '<p><label for="%2$s">%1$s</label><br /><input type="text" class="widefat" id="%2$s" name="%3$s" value="%4$s" /></p>';
	    
		$checkbox_input = '<p><input id="%2$s" name="%3$s" %4$s value="1" class="checkbox" type="checkbox"/> <label for="%2$s">%1$s</label></p>';
		
		$select_input = '<p><label for="%2$s">%1$s</label><br /><select id="%2$s" name="%3$s" class="widefat">%4$s</select></p>';

	    
		// Title
		printf( $text_input,
			esc_html__( 'Title:', 'soundcheck' ),
			esc_attr( $this->get_field_id( 'title' ) ),
			esc_attr( $this->get_field_name( 'title' ) ),
			esc_attr( $instance['title'] )
		);
		
		// Name
		printf( $text_input,
			esc_html__( 'Name:', 'soundcheck' ),
			esc_attr( $this->get_field_id( 'name' ) ),
			esc_attr( $this->get_field_name( 'name' ) ),
			esc_attr( $instance['name'] )
		);
		 
		// Twitter ID
		printf( $text_input,
			esc_html__( 'Twitter Username:', 'soundcheck' ),
			esc_attr( $this->get_field_id( 'twitter_id' ) ),
			esc_attr( $this->get_field_name( 'twitter_id' ) ),
			esc_attr( $instance['twitter_id'] )
		);
		
		// Twitter Number
		printf( $text_input,
			esc_html__( 'Number of Tweets to show:', 'soundcheck' ),
			esc_attr( $this->get_field_id( 'twitter_num' ) ),
			esc_attr( $this->get_field_name( 'twitter_num' ) ),
			esc_attr( $instance['twitter_num'] )
		);
		
		// Duration
		$duration = array( 
			'5'    => __( '5 Minutes', 'soundcheck' ), 
			'15'   => __( '15 Minutes', 'soundcheck' ), 
			'30'   => __( '30 Minutes', 'soundcheck' ), 
			'60'   => __( '1 Hour', 'soundcheck' ), 
			'120'  => __( '2 Hours', 'soundcheck' ), 
			'240'  => __( '4 Hours', 'soundcheck' ), 
			'720'  => __( '12 Hours', 'soundcheck' ),
			'1440' => __( '24 Hours', 'soundcheck' )
		);
		printf( $select_input,
			esc_html__( 'Load new Tweets every:', 'soundcheck' ),
			esc_attr( $this->get_field_id( 'twitter_duration' ) ),
			esc_attr( $this->get_field_name( 'twitter_duration' ) ),
			soundcheck_array_to_select( $duration, $instance['twitter_duration'] )
		);
		
		// Hide Replies
		printf( $checkbox_input,
			esc_html__( 'Hide @ Replies?', 'soundcheck' ),
			esc_attr( $this->get_field_id( 'twitter_hide_replies' ) ),
			esc_attr( $this->get_field_name( 'twitter_hide_replies' ) ),
			checked( 1, $instance['twitter_hide_replies'], false )
		);
		
		// Display Follow Button
		printf( $checkbox_input,
			esc_html__( 'Display follow button?', 'soundcheck' ),
			esc_attr( $this->get_field_id( 'follow_link_show' ) ),
			esc_attr( $this->get_field_name( 'follow_link_show' ) ),
			checked( 1, $instance['follow_link_show'], false )
		);
	}
	
	
	function update( $new_instance, $old_instance ) {
		
		$instance = array();
		
		delete_transient( $old_instance['twitter_id'] . '-' . $old_instance['twitter_num'] . '-' . $old_instance['twitter_duration'] );
		
		$instance['title']                = strip_tags( $new_instance['title'] );
		$instance['name']                 = strip_tags( $new_instance['name'] );
		$instance['twitter_id']           = strip_tags( $new_instance['twitter_id'] );
		$instance['twitter_num']          = absint( $new_instance['twitter_num'] );
		$instance['twitter_duration']     = absint( $new_instance['twitter_duration'] );
		$instance['twitter_hide_replies'] = isset( $new_instance['twitter_hide_replies'] ) ? 1 : 0;
		$instance['follow_link_show']     = isset( $new_instance['follow_link_show'] ) ? 1 : 0;
		
		return $instance;

	}


	function widget( $args, $instance ) {
	
		extract( $args );

		$instance = wp_parse_args( ( array )$instance, array( 
			'title' => '',
			'name' => '',
			'twitter_id' => '',
			'twitter_num' => '',
			'twitter_duration' => '',
			'twitter_hide_replies' => 0,
			'follow_link_show' => 0
		 ) );

		echo $before_widget;

			if ( $instance['title'] ) 
				echo $before_title . apply_filters( 'widget_title', $instance['title'] ) . $after_title;
			?>
			
			<div class="widget-content">
				<header class="user-details">
				    <?php $profile_img = 'https://api.twitter.com/1/users/profile_image/' . urlencode( $instance['twitter_id'] ) . '/'; ?>
				    
  				    <a class="gravatar" href="http://twitter.com/#!/<?php echo urlencode( $instance['twitter_id'] ); ?>" target="_blank">
				    	<img src="<?php echo esc_url( $profile_img ); ?>" width="48" height="48" alt="<?php esc_attr_e( $instance['twitter_id'] ); ?>" />
  				    </a>
  				
				    <span class="name"><?php esc_html( printf( __( '%1$s', 'soundcheck' ), $instance['name'] ) ); ?></span>
				    
				    <a class="username tooltip" href="http://twitter.com/#!/<?php echo urlencode( $instance['twitter_id'] ); ?>" title="<?php esc_attr_e( 'View Profile', 'soundcheck' ); ?>" target="_blank">@<?php echo $instance['twitter_id']; ?></a>
				</header> 
				
				<?php
				echo '<ul>' . "\n";
					
					$tweets = get_transient( $instance['twitter_id'] . '-' . $instance['twitter_num'] . '-'.$instance['twitter_duration'] );
					
					if ( ! $tweets ) {
						
						$count = isset( $instance['twitter_hide_replies'] ) ? (int) $instance['twitter_num'] + 100 : (int) $instance['twitter_num'];
						
						$twitter = wp_remote_retrieve_body( wp_remote_request( sprintf( 'http://api.twitter.com/1/statuses/user_timeline.json?screen_name=%s&count=%s&trim_user=1', $instance['twitter_id'], $count ), array( 'timeout' => 100 ) ) );

						$json = json_decode( $twitter );

						if ( ! $twitter ) {
							$tweets[] = '<li>' . __( 'The Twitter API is taking too long to respond. Please try again later.', 'soundcheck' ) . '</li>' . "\n";
						}
						elseif ( is_wp_error( $twitter ) ) {
							$tweets[] = '<li>' . __( 'There was an error while attempting to contact the Twitter API. Please try again.', 'soundcheck' ) . '</li>' . "\n";
						}
						elseif ( is_object( $json ) && $json->error ) {
							$tweets[] = '<li>' . __( 'The Twitter API returned an error while processing your request. Please try again.', 'soundcheck' ) . '</li>' . "\n";
						}
						else {

							// Build the tweets array
							foreach( (array) $json as $tweet ) {

								// don't include @ replies ( if applicable )
								if ( $instance['twitter_hide_replies'] && $tweet->in_reply_to_user_id )
									continue;

								// stop the loop if we've got enough tweets
								if ( !empty( $tweets[(int) $instance['twitter_num'] - 1] ) )
									break;

								// add tweet to array
								$timeago = sprintf( __( 'about %s ago', 'soundcheck' ), human_time_diff( strtotime( $tweet->created_at ) ) );
								$timeago_link = sprintf( '<a href="%s" rel="nofollow">%s</a>', esc_url( sprintf( 'http://twitter.com/%s/status/%s', $instance['twitter_id'], $tweet->id_str ) ), esc_html( $timeago ) );

								$tweets[] = '<li>' . soundcheck_tweet_linkify( $tweet->text ) . ' <span style="font-size: 85%;">' . $timeago_link . '</span></li>' . "\n";

							}

							// just in case
							$tweets = array_slice( (array) $tweets, 0, (int) $instance['twitter_num'] );

							$time = ( absint( $instance['twitter_duration'] ) * 60 );

							// Save them in transient
							set_transient( $instance['twitter_id'] . '-' . $instance['twitter_num'] . '-' . $instance['twitter_duration'], $tweets, $time );

						}

					}

					foreach( (array) $tweets as $tweet ) {
						echo $tweet;
					}

				echo '</ul>' . "\n";
			echo '</div>' . "\n";
			
			
			if ( 1 == $instance['follow_link_show'] ) {
				echo '<footer class="widget-footer">';
				  	printf( '<a href="%1$s" class="twitter-follow-button" data-button="grey" data-text-color="#FFFFFF" data-link-color="#00AEFF" data-show-count="false">%2$s @%3$s</a>',
				  		esc_url( 'http://twitter.com/#!/' . urlencode( $instance['twitter_id'] ) ),
				  		esc_html__( 'Follow', 'soundcheck' ),
				  		esc_html( $instance['twitter_id'] )
				  	);
					echo '<script src="http://platform.twitter.com/widgets.js" type="text/javascript"></script>';
				echo '</footer>';
			}
			
		echo $after_widget;
		
	}
	
}