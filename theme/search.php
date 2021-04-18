<?php
/**
 * The main template file
 *
 * @package chriswiegman-theme
 */

get_header();

echo '<div class="content search">';

printf( '<h1>Search results for: %s</h1>', get_search_query() );

if ( have_posts() ) {

	echo '<div class="posts-group">';
	echo '<ul class="posts-list">';

	/* Start the Loop */
	while ( have_posts() ) {
		the_post();

		echo '<li class="post-item">';
		printf( '<a href="%s">', esc_url( get_the_permalink() ) );
		the_title( '<span class="post-title">', '</span>' );
		printf( '<span class="post-day">%s</span>', get_the_date( 'M j, Y' ) );
		echo '</a>';
		the_excerpt();
		echo '</li>';

	}

	echo '</ul>';
	echo '</div>';
}

echo '</div>';

get_footer();
