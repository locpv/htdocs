<?php  
/**
 * The secondary sidebar. This page determines the page type and shows the appropriate widgets.	
 *
 * @package Soundcheck
 * @since 1.0
 */
?>

<section id="secondary-sidebar" class="sidebar" role="complementary">
	<?php
	if ( is_single() ) :
	    
	    if ( soundcheck_product_type_page() ) {
	    	get_template_part( 'inc/plugins/cart66/content', 'product-purchase' );
	    	dynamic_sidebar( 'sidebar-secondary-products' );
	    } else {
	    	dynamic_sidebar( 'sidebar-secondary-single' );
	    }
	    
	elseif ( soundcheck_is_multiple() ) :
	    
	    dynamic_sidebar( 'sidebar-secondary-multiple' );
	
	elseif ( is_page() || is_404() ) :
	   
	    dynamic_sidebar( 'sidebar-secondary-page' );
	
	endif; 
	?>
</section><!-- #secondary-sidebar -->
