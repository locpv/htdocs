<?php 
/**
 * The loop for displaying singular page content (single, page, attachements)
 *
 * @package Soundcheck
 * @since 1.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <?php get_template_part( 'partials/post', 'header' ); ?>
    <?php get_template_part( 'partials/post', 'format' ); ?>
</article><!-- #post-## -->
