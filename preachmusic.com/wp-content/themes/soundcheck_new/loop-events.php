<?php
/**
 * If the page template is in use, this file gets called. However,
 * the page template is not that useful unless the user defines
 * a category to use as events. We will do a check for this option,
 * and if it's not set, we will notify the user of what they need
 * to do and then exit the page to avoid the rest of the script
 * from being ran.
 */
if ( $events_cat = soundcheck_option( 'events_category' ) ) : ?>

	<?php
	// Get main events category name
	$events_cat_name = get_cat_name( $events_cat );
	
	// Get soundcheck events
	$events = soundcheck_get_events( array( 
		'cat' => $events_cat,
		'paged' => soundcheck_get_paged_query_var(),
	) );
	
	// Set $wp_query->max_num_pages to the number of the new WP_Query for pagination purposes.
	$wp_query->max_num_pages = $events->max_num_pages;
	?>

	<?php if ( ! $events->have_posts() ) : ?>

		<?php
		printf( '<p class="no event">%s</p>',
		    esc_html( sprintf( __( 'There are not any %s scheduled at this time.', 'soundcheck' ), $events_cat_name ) )
		);
		?>

	<?php else : ?>

		<?php $cats = soundcheck_get_events_category_filter( array( 'cat' => $events_cat ) ); ?>
		<?php if ( count( $cats ) > 0 ) : ?>
			<div id="events-filter-list" class="clearfix">
			    <span class="filter-title"><?php _e( 'Filter:', 'soundcheck' ); ?></span>
			    <div id="filter">
			        <ul>
				    	<li><a class="active" href="#<?php echo esc_attr( $events_cat_name ); ?>"><?php echo esc_html( $events_cat_name ); ?></a></li>

				    	<?php foreach ( $cats as $cat ) : ?>
				    		<li>
				    			<a href="#<?php echo esc_attr( $cat->category_nicename ); ?>">
				    				<?php echo esc_html( $cat->cat_name ); ?>
				    			</a>
				    		</li>
				    	<?php endforeach; ?>
			        </ul>
			    </div><!-- #filter -->
			</div><!-- #events-filter-list -->
		<?php endif; // end if ( count( $cats ) > 0 ); ?>

		<ul id="events-date-list" class="clearfix">
			<?php while ( $events->have_posts() ) : ?>
				<?php $events->the_post(); ?>
				<?php get_template_part( 'content', 'events' ); ?>
			<?php endwhile; // end while have_posts(); ?>
			<?php wp_reset_postdata(); ?>
		</ul>

	<?php endif; // end if ( ! $events->have_posts() ); ?>

<?php else : // Event cat not set, so display a notice ?>

	<?php echo soundcheck_get_default_notice( 'events' ); ?>

<?php endif; // end events_cat check ?>