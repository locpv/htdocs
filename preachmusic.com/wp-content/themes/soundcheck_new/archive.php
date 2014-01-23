<?php
/**
 * The template for displaying Archive pages.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package soundcheck
 * @since soundcheck 2.3.0
 */

get_header(); ?>

<?php if ( 1 == soundcheck_option( 'carousel_multiple' ) ) soundcheck_get_image_carousel( 'multiple' ); ?>
	
<section id="content" class="site-content">
    <?php if ( have_posts() ) : ?>
    	<header id="page-header" class="regular">
        	<h1 class="page-title">
        		<?php
        		if ( is_category() ) {
        		    printf( '%s %s', '<span>' . soundcheck_archive_title_descriptor( 'category', get_queried_object()->slug ) . '</span>', __( single_cat_title( '', false ), 'soundcheck' ) );

        		} elseif ( is_tag() ) {
        		    printf( '%s %s', '<span>' . soundcheck_archive_title_descriptor( 'tag', get_queried_object()->slug ) . '</span>', __( single_tag_title( '', false ), 'soundcheck' ) );

        		} elseif ( is_author() ) {
        		    /* Queue the first post, that way we know
        		     * what author we're dealing with (if that is the case).
        		    */
        		    the_post();
    				printf( '%s %s', '<span>' . soundcheck_archive_title_descriptor( 'author', get_the_author_meta( 'user_nicename' ) ) . '</span>', '<span class="vcard"><a class="url fn n" href="' . get_author_posts_url( get_the_author_meta( 'ID' ) ) . '" title="' . esc_attr( get_the_author() ) . '" rel="me">' . __( get_the_author(), 'soundcheck' ) . '</a></span>' );
        		    /* Since we called the_post() above, we need to
        		     * rewind the loop back to the beginning that way
        		     * we can run the loop properly, in full.
        		     */
        		    rewind_posts();

        		} elseif ( is_day() ) {
        		    printf( '%s %s', '<span>' . soundcheck_archive_title_descriptor( 'day', get_the_date( 'Y-m-d' ) ) . '</span>', __( get_the_date(), 'soundcheck' ) );

        		} elseif ( is_month() ) {
        		    printf( '%s %s', '<span>' . soundcheck_archive_title_descriptor( 'month', get_the_date( 'Y-m' ) ) . '</span>', __( get_the_date( 'F Y' ), 'soundcheck' ) );

        		} elseif ( is_year() ) {
        		    printf( '%s %s', '<span>' . soundcheck_archive_title_descriptor( 'year', get_the_date( 'Y' ) ) . '</span>', __( get_the_date( 'Y' ), 'soundcheck' ) );
    				
    			} elseif ( is_tax( 'post_format' ) ) {
        		    printf( '%s %s', '<span>' . soundcheck_archive_title_descriptor( 'post-format', get_post_format() ) . '</span>', soundcheck_post_format_label() );

        		} else {
        		    print soundcheck_archive_title_descriptor( 'post-type', get_post_type() );
        		}
        		?>
        	</h1><!-- .page-title -->
        </header> <!-- .page-header -->
		
		<div class="customAjaxAddToCartMessage Cart66Success" style="display:none"></div>	
		
		<?php 
		$product_category = soundcheck_option( 'products_category' );
		
		if ( ! empty( $product_category ) && ( is_category( $product_category ) || soundcheck_is_subcategory( $product_category ) ) ) {
		    get_template_part( 'inc/plugins/cart66/loop', 'product' );
		} else {
			while( have_posts() ) : the_post();
				get_template_part( 'content' ); 
			endwhile;
		}
		?>
		
		<?php soundcheck_pagination( 'nav-below' ); ?>

    <?php else : ?>

        <?php get_template_part( 'no-results', 'archive' ); ?>

    <?php endif; ?>
</section> <!-- #content .site-content -->

<?php if ( soundcheck_has_right_sidebar() ) get_sidebar( 'secondary' ); ?>

<?php get_footer(); ?>
