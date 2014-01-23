<article id="post-archives" class="<?php echo esc_attr( 'hentry' ); ?>">
    <div class="entry-content">
    	<?php if ( is_404() || is_search() ) : ?>
    		<p><?php _e( 'Sorry, but what you’re searching for could not be found. Maybe try one of the links below.', 'soundcheck' ); ?></p>	
    	<?php endif; ?>
    	
    	<h4><?php _e( 'Last 30 Posts', 'soundcheck' ); ?></h4>
    	<ul>
    		<?php
    		$archives = get_posts( array( 'numberposts' => '30' ) );
    		
    		foreach( $archives as $post ) {
    			printf( '<li><a href="%1$s" title="%2$s">%3$s</a></li>',
    				esc_url( get_permalink() ),
    				soundcheck_the_title_attribute(),
    				esc_html( get_the_title() )
    			);
    		} 
    		?>
    	</ul>
    	
    	<h4><?php _e( 'Archives by Month:', 'soundcheck' ); ?></h4>
    	<ul>
    		<?php wp_get_archives( array( 'type' => 'monthly' ) ); ?>
    	</ul>
    	
    	<h4><?php _e( 'Archives by Subject:', 'soundcheck' ); ?></h4>
    	<ul>
    		<?php wp_list_categories( array( 'title_li' => '' ) ); ?>
    	</ul>
    	
    	<h4><?php _e( 'Maybe a Page:', 'soundcheck' ); ?></h4>
    	<ul>
    		<?php wp_list_pages( array( 'title_li' => '' ) ); ?>
    	</ul>
    </div>
</article>	
