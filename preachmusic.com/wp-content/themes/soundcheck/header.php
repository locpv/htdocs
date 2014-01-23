<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package WordPress
 * @subpackage Soundcheck
 * @since 1.0
 */
?><!doctype html>  

<!--[if lt IE 7 ]> <html <?php language_attributes(); ?> class="no-js ie6"> <![endif]-->
<!--[if IE 7 ]><html <?php language_attributes(); ?> class="no-js ie7"> <![endif]-->
<!--[if IE 8 ]><html <?php language_attributes(); ?> class="no-js ie8"> <![endif]-->
<!--[if IE 9 ]><html <?php language_attributes(); ?> class="no-js ie9"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> <html class="no-js" <?php language_attributes(); ?>> <!--<![endif]-->

<head>
<!--
**********************************************************************************************
	
Soundcheck (<?php echo VERSION ?>) - Designed and Built by Luke McDonald
	
**********************************************************************************************
-->

	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1,<?php bloginfo( 'html_type' ); ?>">
	
	<title><?php wp_title() ?></title>
	
 	<link rel="stylesheet" href="<?php echo get_stylesheet_uri() . '?ver=' . ti_version_id(); ?>">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
	
	<?php wp_head(); ?>
	<script type="text/javascript">

  		var _gaq = _gaq || [];
  		_gaq.push(['_setAccount', 'UA-37701786-1']);
  		_gaq.push(['_setDomainName', 'preachmusic.com']);
  		_gaq.push(['_setAllowLinker', true]);
  		_gaq.push(['_trackPageview']);

  		(function() {
    			var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
			ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    			var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  			})();

	</script>
</head>

<body id="top" <?php body_class(); ?> >
	
	<div id="header-container">
		
		<header id="header" class="hfeed">
			
  			<div id="header-content">
					
				<div class="top-border"><!-- nothing to see here --></div>
  			
				<div id="site-info" role="banner">
  				
				    <?php 
				    /**
				     * Site Info. Tag changes depending upon page.
				     *
				     */
				    $heading_tag = ( is_home() || is_front_page() ) ? 'h1' : 'div'; ?>
				    
				    <<?php echo $heading_tag; ?> class="site-title">
  				
				    	<?php
				    	/**
				    	 * Logo
				    	 *
				    	 */
				    	// Get theme options. (multicheck)
				    	$logo_options = ti_get_option( 'logo_options', 0 );
				    	
				    	if ( 1 == $logo_options['logo_text'] ) : ?>
				    	
				    		<a href="<?php echo esc_url( home_url() ); ?>"><?php bloginfo( 'name' ); ?></a>
				    	
				    	<?php else : // Not a text based logo ?>
    			
				    		<a class="fade" href="<?php echo esc_url( home_url() ); ?>" title="Home" >
				    			<?php
				    			$logo_default = get_template_directory_uri() . '/images/logo.png'; // Set default logo 
				    			$logo = ti_get_option( 'logo_image', $logo_default ); // Get image based logo set in theme options or set as default
				    			?>
				    			<img src="<?php echo $logo ?>" alt="<?php bloginfo( 'name' ); ?>" />
				    		</a>
				    	
				    	<?php endif; // end text logo check ?>
				    
				    </<?php echo $heading_tag; ?>><!-- #site-title -->
				    
				    
				    <?php
				    /**
				     * Site Description
				     *
				     * Check if site description is enabled in theme options.
				     * If not enabled, apply a "hidden" class.
				     *
				     */
				    $hide_site_description = ( $logo_options['site_description'] == 1 ) ? 'hidden' : 'site-description'; ?>
						
					<p class="<?php echo $hide_site_description; ?>"><?php bloginfo( 'description' ); ?></p>
  				
				</div><!-- .site-info -->
  				
				<div class="bottom-border clearfix"><!-- nothing to see here --></div>
  			
			</div><!-- .#header-content -->
			
			
			<?php 
			/**
			 * Hero Slider
			 *
			 */
			get_template_part( 'content', 'hero' ) ?>
			
			
			<?php 
			/**
			 * Primary Nav
			 *
			 */
			?>
			<nav id="primary-nav" role="navigation">
			    <ul class="sf-menu">
			    	<?php 
			    	if ( has_nav_menu( 'primary' ) ) : // Check if primary menu has been set in WP menu options
			    		wp_nav_menu( array(
			    			'theme_location' => 'primary',
			    			'container'      => '',
			    			'items_wrap'     => '%3$s',
			    			'sort_column'    => 'menu_order' 
			    		));
			    	else :
			    		wp_list_pages( array( 
			    			'title_li'	=>	'' 
			    		));
			    	endif;
			    	?>
			    </ul>
			</nav><!-- #primary-nav -->
  		
		</header><!-- #header -->
	
	</div><!-- #header-container -->

	<div id="main-container" role="main">
		
		<div id="main-widgets-container">
		
			<?php 
			/**
			 * Featured Sidebar Widgets
			 *
			 */
			get_sidebar( 'featured' );?>
			
			<?php 
			/**
			 * Primary Sidebar Widgets
			 *
			 */
			if ( ! is_home() ) 
				get_sidebar(); ?>
		
		</div><!-- #main-widgets-container -->