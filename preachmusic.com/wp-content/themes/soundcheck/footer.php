<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the id=main-container div and all content after
 *
 * @package    WordPress
 * @subpackage Soundcheck
 * @since      1.0
 */
?>
		<div class="clearfix"><!-- nothing to see here (footer) --></div>

	</div><!-- #main-container -->
	
	<div id="footer-container">
		
		<footer id="footer">

			<?php
			/**
			 * Copyright
			 *
			 */
			$of_footer_copyright_default = 'Your Band Name - All Rights Reserved';
			$of_footer_copyright = stripslashes( ti_get_option( 'footer_copyright', $of_footer_copyright_default ) ); ?>
			
			<p id="copyright" role="contentinfo"><?php echo __( '&copy; ', 'theme-it' ) . '<time datetime="' . date( 'Y-m-d' ) . '">'  . date( 'Y ' ) . '</time>' . esc_html__( $of_footer_copyright ); ?></p>
			
			<ul id="media-icons">
				
				<?php
				/**
				 * Social Networking Menu Items
				 *
				 */
				$sites = array(
					'amazon'     => array( 'label' => 'Amazon',	    'host' => '' ),
					'itunes'     => array( 'label' => 'iTunes',     'host' => '' ),
					'soundcloud' => array( 'label' => 'SoundCloud', 'host' => 'soundcloud.com' ),
					'bandcamp'   => array( 'label' => 'Bandcamp',   'host' => 'bandcamp.com' ),
					'myspace'    => array( 'label' => 'MySpace',    'host' => 'myspace.com' ),
					'lastfm'     => array( 'label' => 'Last.fm',    'host' => 'lastfm.com' ),
					'twitter'    => array( 'label' => 'Twitter',    'host' => 'twitter.com' ),
					'facebook'   => array( 'label' => 'Facebook',   'host' => 'facebook.com' ),
					'vimeo'      => array( 'label' => 'Vimeo',      'host' => 'vimeo.com' ),
					'youtube'    => array( 'label' => 'YouTube',    'host' => 'youtube.com' ),
					'flickr'     => array( 'label' => 'Flickr',     'host' => 'flickr.com' ),
					'rss'        => array( 'label' => 'RSS',        'host' => 'feeds.feedburner.com' )
				);

				// Loop through $sites
				foreach( $sites as $social => $site ) { ?>
				
					<?php 
					// Get theme option, false if blank 
					$username = ti_get_option( 'social_' .  $social );
					
					// Continue if username theme option is provided
					if( ! $username ) 
						continue;
					
					// Check for RSS is up to bat in loop and set its value accordingly					
					if( 'rss' === $social ) {
						if( ti_get_option( 'feedburner_url' ) ) {
							$username = ti_get_option( 'feedburner_url' );
						} else {
							$rss2_url = get_bloginfo( 'rss2_url' );
						}
					}
					
					// Create some variables
					$class = $social;
					$url = ( isset( $rss2_url ) ) ? $rss2_url : 'http://' . $site['host'] . '/' . $username;
					$title = $site['label'];
					
					// Bandcamp uses a different structure, so set it up that way if Bandcamp is up to bat
					if( 'bandcamp' === $social ) {
						$url = 'http://' . $username . '.' . $site['host'];
					}
					
					if( 'amazon' === $social || 'itunes' === $social )
						$url = $username;
					
					?>
					
					<li class="<?php echo esc_attr( $class ) ?> ir">
					    
					    <a href="<?php echo esc_url( $url ) ?>" class="tooltip" title="<?php esc_attr_e( 'Link to ', 'theme-it' ) . esc_attr_e( $title, 'theme-it' ); ?>" target="_blank"><?php _e( $title, 'theme-it' ); ?></a>
					    
					</li>
								
				<?php } // End $sites foreach loop ?>
			
			</ul><!-- .media-icons -->
			
			<p id="role-credits"><?php _e( 'Designed by ', 'theme-it' ); ?><a href="http://lukemcdonald.com"><?php _e( 'Luke McDonald', 'theme-it' ); ?></a> &amp; <?php _e( 'Powered by', 'theme-it' ); ?> <a href="http://wordpress.org"><?php _e( 'WordPress', 'theme-it' ); ?></a></p>
		
		</footer><!-- #footer -->
		
	</div><!-- #footer-container -->
	
	<?php wp_footer(); ?>
	
	<!--[if lt IE 8 ]>
	  <script src="http://ajax.googleapis.com/ajax/libs/chrome-frame/1.0.3/CFInstall.min.js"></script>
	  <script>window.attachEvent('onload',function(){CFInstall.check({mode:'overlay'})})</script>
	<![endif]-->
	
</body>
</html>