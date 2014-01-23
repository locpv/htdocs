<ul class="entry-meta">
	<?php  
	printf( '<li class="date"><a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date" pubdate="%3$s">%4$s</time></a></li>',
		esc_url( get_permalink() ),
		esc_attr( get_the_time() ),
		esc_attr( get_the_date( 'Y-m-d' ) ),
		esc_html( get_the_date() )
	);
	
	printf( '<li class="author"><span class="author vcard"><a class="url fn n" href="%1$s" title="%2$s">%3$s</a></span></li>',
		esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
		esc_attr( sprintf( __( 'View all posts by %s', 'soundcheck' ), get_the_author() ) ),
		get_the_author()
	);
	
	$cats_list = get_the_category_list( ' &middot; ' );
	
	if ( ! empty( $cats_list ) ) :
		printf( '<li class="categories"> &middot; %1$s</li>',
			$cats_list
		);
	endif;
	?>
</ul><!-- .entry-meta -->