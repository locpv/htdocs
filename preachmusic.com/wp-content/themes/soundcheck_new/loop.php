<?php
if ( have_posts() ) : 
	while( have_posts() ) : 
		the_post();
		get_template_part( 'content' ); 
	endwhile;
else : 
	get_template_part( 'no-results', 'index' ); 
endif;
?>