<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package chriswiegman-theme
 */

get_header();

if ( is_home() || is_front_page() ) {
	dynamic_sidebar( 'home-intro' );
}

echo '<div class="content home">';

if ( have_posts() ) {

	echo '<!-- Group by year. -->';

	$current_year = false;

	/* Start the Loop */
	while ( have_posts() ) {
		the_post();

		$post_year = get_the_date( 'Y' );

		if ( $post_year !== $current_year ) {

			if ( false !== $current_year ) {
				echo '</ul>';
				echo '</div>';
			}

			echo '<div class="posts-group">';
			printf( '<div class="post-year" id="%d">%d</div>', intval( $post_year ), intval( $post_year ) );
			echo '<ul class="posts-list">';

		}

		$current_year = $post_year;

		echo '<li class="post-item">';
		printf( '<a href="%s">', esc_url( get_the_permalink() ) );
		the_title( '<span class="post-title">', '</span>' );
		the_date( 'M j', '<span class="post-day">', '</span>' );
		echo '</a>';
		echo '</li>';

	}
}

echo '</div>';

get_footer();
