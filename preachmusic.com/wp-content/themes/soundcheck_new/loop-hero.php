<?php
$args = array(
    'ignore_sticky_posts' => 1,
    'cat'                 => ( $hero_category = soundcheck_option( 'hero_category', null ) ),
    'posts_per_page'      => soundcheck_option( 'hero_count', 5 ),
    'orderby'             => ( soundcheck_option( 'hero_randomize', 0 ) == 1 ) ? 'rand' : 'date'
);

$hero_query = new WP_Query( apply_filters( 'soundcheck_hero_query_args', $args ) );
?>

<?php if ( $hero_category && $hero_query->have_posts() ) : ?>
    
    <?php while ( $hero_query->have_posts() ) : $hero_query->the_post(); ?>
    	
		<?php get_template_part( 'content', 'hero-slide' ); ?>
		
    <?php endwhile; ?>

<?php else : ?>
	
	<li class="slide" style="background: url(<?php echo esc_url( get_template_directory_uri() . '/images/default-hero-image.jpg' ); ?>) 50% 0 no-repeat;">
		<?php echo soundcheck_get_default_notice( 'hero' ); ?>
    </li>

<?php endif; // end hero slides check ?>

<?php wp_reset_postdata(); ?>
