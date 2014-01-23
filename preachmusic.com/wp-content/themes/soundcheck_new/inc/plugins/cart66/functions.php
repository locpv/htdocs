<?php
define( 'SOUNDCHECK_CART66_DIR', get_template_directory() . '/inc/plugins/cart66'  );
define( 'SOUNDCHECK_CART66_DIR_URI', get_template_directory_uri() . '/inc/plugins/cart66'  );


if ( ! function_exists( 'soundcheck_cart66_setup' ) ) :
/**
 * Setup Cart66 theme functionality
 *
 * @since 2.1.0
 */
function soundcheck_cart66_setup() {

	/**
	 * Cart66 template tags
	 */
	require( SOUNDCHECK_CART66_DIR . '/inc/template-tags.php' );
	
	/**
	 * Cart66 custom styles
	 */
	require( SOUNDCHECK_CART66_DIR . '/inc/custom-styles.php' );
	
	/**
	 * Cart66 theme options
	 */
	soundcheck_add_cart66_theme_options();
	
}
endif;
add_action( 'after_setup_theme', 'soundcheck_cart66_setup' );


if ( ! function_exists( 'soundcheck_cart66_admin_init' ) ) :
/**
 * Sets up theme admin specific functions and features.
 *
 * Note that this function is hooked into the admin_init hook, which runs
 * after the theme setup hook and is for admin only functionality
 *
 * @since 2.4.0
 */
function soundcheck_cart66_admin_init() {
	
	/**
	 * Implement custom meta boxes
	 */
	require( SOUNDCHECK_CART66_DIR . '/inc/metabox.php' );
	
}
endif;
add_action( 'admin_init', 'soundcheck_cart66_admin_init' );


if ( ! function_exists( 'soundcheck_cart66_scripts' ) ) :
/**
 * Enqueue scripts
 *
 * @since 2.1.0
 */
function soundcheck_cart66_scripts() {
	
	wp_enqueue_style( 'soundcheck-cart66', SOUNDCHECK_CART66_DIR_URI . '/css/theme-cart66.css', false, soundcheck_version_id() );

}
endif;
add_action( 'wp_enqueue_scripts', 'soundcheck_cart66_scripts' );


if ( ! function_exists( 'soundcheck_add_cart66_theme_options' ) ) :
/**
 * Cart66 Theme Options
 *
 * @since 2.1.0
 */
function soundcheck_add_cart66_theme_options() {
	
	global $theme_options;
	
	$theme_options->add_section( 'cart66_section', __( 'Store (Cart66)', 'soundcheck' ) );
	
	if ( soundcheck_plugin_active( 'cart66' ) ) {
		$theme_options->add_option( 'products_category', 'select', 'cart66_section' )
	    	->label( __( 'Store Category', 'soundcheck' ) )
	    	->description( __( 'Select which category should be used for the Products display.', 'soundcheck' ) )
	    	->valid_values( soundcheck_get_category_list() );
	}
	
	/* Initialize Options */
	$theme_options->initialize();
	
}
endif;


if ( ! function_exists( 'soundcheck_cart66_register_sidebars' ) ) :
/**
 * Register Sidebars
 *
 * @since 2.1.0
 */
function soundcheck_cart66_register_sidebars() {
	
	register_sidebar( array(
		'id'            => 'sidebar-primary-products',
		'name'          => __( 'Primary Sidebar - Products', 'soundcheck' ),
		'description'   => __( 'Shown on product pages in left sidebar.', 'soundcheck' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>'
	));
	
	register_sidebar( array(
		'id'            => 'sidebar-secondary-products',
		'name'          => __( 'Secondary Sidebar - Products', 'soundcheck' ),
		'description'   => __( 'Shown on single product pages.', 'soundcheck' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>'
	));
			
}
endif;
add_action( 'widgets_init', 'soundcheck_cart66_register_sidebars', 11 );
