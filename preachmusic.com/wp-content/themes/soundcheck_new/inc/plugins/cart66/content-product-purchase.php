<aside id="soundcheck_product_purchase" class="widget soundcheck_product_purchase_widget">
	<h3 class="widget-title"><?php _e( 'Product Info', 'soundcheck' ); ?></h3>
	
    <div class="product-content">
		<?php the_excerpt(); ?>
    </div>
    
    <div class="product-price">
        <span class="price-label"><?php _e( 'Price: ', 'soundcheck' ); ?></span> 
        <?php soundcheck_cart66_product_price_link(); ?>
    </div>
    	
    <div class="widget-footer">
    	<?php
    	print do_shortcode( sprintf( '[add_to_cart item="%1$s"]', 
    	    soundcheck_get_cart66_product( array( 
    	    	'id' => get_the_ID(), 
    	    	'option' => 'itemnumber', 
    	    	'echo' => 0
    	    ) )
    	));
    	?>
    </div>
</aside>