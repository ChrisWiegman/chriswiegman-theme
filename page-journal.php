<?php
/**
 * The template for displaying the speaking page.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package ChrisWiegman
 */

add_filter( 'body_class', 'multisite_body_classes' );

function multisite_body_classes( $classes ) {

	$page          = array_search( 'page', $classes );
	$page_template = array_search( 'page-template-default', $classes );

	if ( false !== $page ) {
		unset( $classes[ $page ] );
	}

	if ( false !== $page_template ) {
		unset( $classes[ $page_template ] );
	}

	$classes[] = 'journal';

	return $classes;

}

get_header(); ?>

<div id="primary" class="content-area">
	<main id="main" class="site-main" role="main">

		<?php

		$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;

		$args = array(
			'post_type'      => array( 'morning-journal', 'evening-journal' ),
			'order'          => 'DESC',
			'orderby'        => 'date',
			'posts_per_page' => 6,
			'paged'          => $paged,
		);

		$loop = new WP_Query( $args );

		while ( $loop->have_posts() ) {

			$loop->the_post();

			get_template_part( 'content', 'journal' );

		} // end of the loop.

		chriswiegman_paging_nav( $loop );

		?>

	</main>

	<!-- #main -->
</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
