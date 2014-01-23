<?php
/**
 * Custom Theme Styles
 *
 * Apply custom styling set via Theme Options and print in head.
 *
 * @since     1.0
 */
function ti_custom_theme_styles() {
	$of_enable_styles = ti_get_option( 'enable_styles', 0 );
	
	if ( $of_enable_styles == 1  ) : ?>
	
		<!-- Custom theme styles -->	
		<style type="text/css">
		
			<?php
			$of_body_background = ti_get_option( 'body_background' );
			$of_primary_1 = ti_get_option( 'primary_1' );
			$of_primary_2 = ti_get_option( 'primary_2' );
			$of_primary_3 = ti_get_option( 'primary_3' );
			$of_primary_4 = ti_get_option( 'primary_4' );
			$of_text_color_site_info = ti_get_option( 'text_color_site_info' );
			$of_text_color_primary = ti_get_option( 'text_color_primary' );
			$of_text_shadows = ti_get_option( 'text_shadows' );
			?>
			
			body {
				<?php
				$of_body_background_style  = ( isset( $of_body_background['color'] ) ) ? 'background-color: ' . $of_body_background['color'] . ' !important; ' : null;
				$of_body_background_style .= ( isset( $of_body_background['image'] ) && !empty( $of_body_background['image'] ) ) ? 'background-image: url(' . esc_url( $of_body_background['image'] ) . ') !important;' : 'background-image: none; ';
				$of_body_background_style .= ( isset( $of_body_background['repeat'] ) ) ? 'background-repeat: ' . $of_body_background['repeat'] . ' !important; ' : null;
				$of_body_background_style .= ( isset( $of_body_background['position'] ) ) ? 'background-position: ' . $of_body_background['position'] . ' !important; ' : null;
				$of_body_background_style .= ( isset( $of_body_background['attachment'] ) ) ? 'background-attachment: ' . $of_body_background['attachment'] . ' !important; ' : null;
				
				print $of_body_background_style;
				?>
			}
			
			/* TEXT: Text Logo and description */
			#site-info .site-title a, #site-info p
			{	<?php if ( isset( $of_text_color_site_info ) ) print 'color: ' . $of_text_color_site_info; ?> !important; }
			

			/* TEXT: Primary */
			body, select, input, textarea, h1, h2, h3, h4, h5, h6, #entry-container .entry-title a, .ti-latest-tweet .name,	#main-container .search-submit:hover, .gigpress-date, .gigpress-sidebar-date, .ti-post-meta-widget .date, .ti-post-meta-widget .utility-title, .ti-media-player .jp-current-track, .purchase, blockquote cite,  .ti-featured-category .entry-title a:hover
			{	<?php if ( isset( $of_text_color_primary ) ) print 'color: ' . $of_text_color_primary; ?> !important; }
			
			/* TEXT: Secondary */
			blockquote, .widget, #footer, .ti-latest-tweet .username, .ti-media-player .jp-current-artist, .ti-media-player .jp-current-album, #main-container .search-submit, .gigpress-row, .respond-title-wrap .respond-caption, .ti-post-meta-widget .author, .ti-post-meta-widget .categories, .entry-meta .author, .comment-meta, .ti-featured-category .entry-title a
			{ <?php if ( isset( $of_primary_1 ) ) print 'color: ' . $of_primary_1; ?> !important; }
			
			/* TEXT: Shadow */
			#primary-nav, #main, .widget, #search input, .jp-audio, #hero .edit-link, #site-info, #entry-container span.comments a, #footer
			{ <?php if ( isset( $of_text_shadows ) && $of_text_shadows == 1 ) print 'text-shadow: none ' ?> !important; }

			
			/* LINK: Color */
			#main-container a, #commentform #submit:hover, .ti-featured-category .entry-title a 
			{	<?php if ( isset( $of_primary_1 ) ) print 'color: ' . $of_primary_1; ?> !important; }
			
			/* LINK: Other Color */
			#main-container a:hover, #entry-container a:hover, .ti-featured-category .entry-title a:hover, .entry-date, .ti-latest-tweets .name
			{ <?php if ( isset( $of_text_color_primary ) ) print 'color: ' . $of_text_color_primary; ?> !important;
			  <?php if ( isset( $of_text_color_primary ) ) print 'border-color: ' . $of_text_color_primary; ?> !important; }
			
			
			/* NAVIGATION */
			#primary-nav li:hover 
			{ <?php if ( isset( $of_primary_4 ) ) print 'border-color: ' . $of_primary_4; ?>;
				<?php if ( isset( $of_primary_4 ) ) print 'background-color: ' . $of_primary_4; ?>; }
				
			#primary-nav ul ul
			{ <?php if ( isset( $of_primary_4 ) ) print 'background-color: ' . $of_primary_4; ?>;	}
			
			#primary-nav li li:hover 
			{ <?php if ( isset( $of_primary_3 ) ) print 'background-color: ' . $of_primary_3; ?>;	}
			
			#primary-nav a 
			{ <?php if ( isset( $of_primary_1 ) ) print 'color: ' . $of_primary_1; ?>; }
			
			#primary-nav a:hover,	#primary-nav .sfHover > a, #primary-nav .current_page_item a, #primary-nav .current-menu-item a
			{ <?php if ( isset( $of_text_color_primary ) ) print 'color: ' . $of_text_color_primary; ?>; }
			
			
			/* BUTTONS: */
			a.button, .widget_gigpress .gigpress-subscribe a, a.purchase-link, .wp-pagenavi a
			{ <?php if ( isset( $of_primary_1 ) ) print 'color: ' . $of_primary_1; ?> !important;
			  <?php if ( isset( $of_primary_2 ) ) print 'background-color: ' . $of_primary_2; ?> !important; }
			  
			a.button:hover, .widget_gigpress .gigpress-subscribe a:hover, a.purchase-link:hover, .wp-pagenavi a:hover
			{ <?php if ( isset( $of_text_color_primary ) ) print 'color: ' . $of_text_color_primary; ?> !important;
			  <?php if ( isset( $of_primary_2 ) ) print 'background-color: ' . $of_primary_2; ?> !important; }
			
			
			/* BORDERS: primary_2 */
			.widget .widget-footer, .widget .widget-title, .widget ul li, .page-header .category-description,  .page-header .entry-content, #entry-container .entry-title, #entry-container .entry-thumbnail, #entry-container .entry-media, .widget_gigpress .gigpress-subscribe, #entry-container .entry-header .entry-excerpt, .gigpress-header, .gigpress-heading, .jp-type-playlist .jp-playlist li, .album-details, .comment-title-wrap, .comment
			{	<?php if ( isset( $of_primary_2 ) ) print 'border-color: ' . $of_primary_2; ?> !important; }
			
			/* BORDERS: primary_3 */
			.widget .widget-title + *, .jp-audio, .widget .widget-content, .page-header p, #entry-container .entry-content, .vevent, .ti-image-carousel .lines span
			{	<?php if ( isset( $of_primary_3 ) ) print 'border-color: ' . $of_primary_3; ?> !important; }
			
			/* BORDERS: primary_4 */
			.top-border, .bottom-border 
			{	<?php if ( isset( $of_primary_4 ) ) print 'border-color: ' . $of_primary_4; ?> !important; }
			

			/* BACKGROUND: primary_3 */
			.jp-audio, .ti-image-carousel .jcarousel-prev, .ti-image-carousel .jcarousel-next, .ti-image-carousel .entry-thumbnail, .widget, .page-header, #entry-container .entry, #footer
			{ <?php if ( isset( $of_primary_3 ) ) print 'background-color: ' . $of_primary_3; ?> !important; }
			
			.top-border, .bottom-border
			{ <?php if ( isset( $of_primary_3 ) ) print 'background: ' . $of_primary_3; ?> !important; }
			
			/* BACKGROUND: primary_4 */
			#entry-container .entry-header .entry-excerpt, .gigpress-heading, #entry-container .entry-meta, #main .entry-gallery, #main .entry-media, #entry-container .entry-thumbnail, .widget .entry-thumbnail, .jp-type-playlist, 
			.wp-caption, .wp-pagenavi .current
			{ <?php if ( isset( $of_primary_4 ) ) print 'background-color: ' . $of_primary_4; ?> !important;}


			/* Forms */
			body form textarea,	body .gform_wrapper textarea,
			body form input[type=url], body .gform_wrapper input[type=url],
			body form input[type=file], body .gform_wrapper input[type=file],
			body form input[type=text], body .gform_wrapper input[type=text],
			body form input[type=email], body .gform_wrapper input[type=email],
			body form input[type=phone], body .gform_wrapper input[type=phone],
			body form input[type=number], body .gform_wrapper input[type=number],
			body form input[type=password], body .gform_wrapper input[type=password] 
			{ <?php if ( isset( $of_text_color_primary ) ) print 'color: ' . $of_text_color_primary; ?>;
			  <?php if ( isset( $of_primary_2 ) ) print 'background: ' . $of_primary_2; ?>;	}
				
			body form textarea:hover,	body .gform_wrapper textarea:hover,
			body form input[type=url]:hover, body .gform_wrapper input[type=url]:hover,
			body form input[type=file]:hover, body .gform_wrapper input[type=file]:hover,
			body form input[type=text]:hover, body .gform_wrapper input[type=text]:hover,
			body form input[type=email]:hover, body .gform_wrapper input[type=email]:hover,
			body form input[type=phone]:hover, body .gform_wrapper input[type=phone]:hover,
			body form input[type=number]:hover, body .gform_wrapper input[type=number]:hover,
			body form input[type=password]:hover, body .gform_wrapper input[type=password]:hover 
			{	<?php if ( isset( $of_primary_1 ) ) print 'background: ' . $of_primary_1; ?>;	}					
		
		</style>
		
	<?php endif; // end custom theme styles
}
?>