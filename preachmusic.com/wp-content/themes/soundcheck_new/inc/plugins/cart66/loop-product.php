<?php if ( ! soundcheck_plugin_active( 'cart66' ) ) { ?>
	
	<aside class="default-notice">
	    <div class="notice-content">
	    	<h3><?php _e( 'Cart66 Plugin Required', 'soundcheck' ); ?></h3>
	    	<p>
	    		<?php 
	    		printf( __( 'The Cart66 plugin is required and needs to be %1$s. Learn more about %2$s.', 'soundcheck' ),
    				sprintf( '<a href="%1$s" title="%2$s">%3$s</a>',
    				    esc_url( get_admin_url() . 'plugins.php' ),
    				    esc_attr( 'Activate Cart66 Plugin' ),
    				    esc_html( 'activated' )
    				),
    				sprintf( '<a href="%1$s" title="%2$s">%3$s</a>',
    				    esc_url( 'http://cart66.com/229.html' ),
    				    esc_attr( 'Learn more about Cart66' ),
    				    esc_html( 'Cart66' )
    				)
	    		);
	    		?>
	    	</p>
	    </div>
	</aside>
	
<?php } elseif ( soundcheck_product_type_page() && ! ( $products_category = soundcheck_option( 'products_category', null ) ) ) {
	?>
	
	<aside class="default-notice">
	    <div class="notice-content">
	    	<h3><?php _e( 'Product Category Required', 'soundcheck' ); ?></h3>
	    	<p>
	    		<?php 
	    		printf( __( 'The Cart66 Products page template requires that you %1$s.', 'soundcheck' ),
    				sprintf( '<a href="%1$s" title="%2$s">%3$s</a>',
    				    esc_url( get_admin_url() . 'themes.php?page=soundcheck_options&section=cart66_section' ),
    				    esc_attr__( 'Set a Store Category', 'soundcheck' ),
    				    esc_html__( 'set a Store Category', 'soundcheck' )
    				)
	    		);
	    		?>
	    	</p>
	    </div>
	</aside>

<?php } else {

	$posts_per_page = is_page_template( 'template-cart.php' ) ? 3 : -1;
	
	$args = array(
	    'posts_per_page' => $posts_per_page,
	    'paged'          => soundcheck_get_paged_query_var(),
		'meta_query'     => array(
			array(
				'key'     => '_product',
				'compare' => '!=',
				'value'   => ''
			),
	    	array(
	    		'key' => '_thumbnail_id' 
	    	)
		)
	);
	
	if ( is_category( $products_category ) || ! is_category() )
		$args['category__in'] = $products_category;
	else
		$args['cat'] = get_query_var( 'cat' );

	$products_query = new WP_Query( $args );
	
	if ( $products_query->have_posts() ) :
	    
	    while ( $products_query->have_posts() ) :
	    	$products_query->the_post();
			get_template_part( 'inc/plugins/cart66/content', 'product' );
	    endwhile;
	    
	    wp_reset_postdata();
	    
	else :
	?>
		
		<aside class="default-notice">
		    <div class="notice-content">
		    	<h3><?php _e( 'Store is empty.', 'soundcheck' ); ?></h3>

				<p><?php __( 'It appears you do not have any posts setup as Cart66 products. Be sure to check the following:', 'soundcheck' ); ?></p>
				
				<ul>
					<li><?php _e( 'Be sure at least one product post is in the Store category set via Appearance > Theme Options > Store (section).', 'soundcheck' ); ?></li>
					<li><?php _e( 'Be sure your product post has a Featured Image set.', 'soundcheck' ); ?></li>
					<li><?php _e( 'Be sure your product post has a product set in the "Product Details" meta box.', 'soundcheck' ); ?></li>
				</ul>
		    </div>
		</aside>
		
		<?php
	endif;
	
};

?>