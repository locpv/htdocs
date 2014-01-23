<?php
$args = array(
    'cat'   => soundcheck_option( 'blog_category', null ),
    'paged' => soundcheck_get_paged_query_var()
);

$blog_query = new WP_Query( apply_filters( 'soundcheck_blog_query_args', $args ) );

// Set $wp_query->max_num_pages to the number of the new WP_Query for pagination purposes.
$wp_query->max_num_pages = $blog_query->max_num_pages;

if ( $blog_query->have_posts() ) : 
	while ( $blog_query->have_posts() ) : 
		$blog_query->the_post();
		get_template_part( 'content' ); 
	endwhile;
else : 
	get_template_part( 'no-results', 'blog' ); 
endif;
?>