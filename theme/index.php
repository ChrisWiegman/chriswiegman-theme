<?php
/**
 * The main template file
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
		printf( '<span class="post-day">%s</span>', get_the_date( 'M j' ) );
		echo '</a>';
		echo '</li>';

	}
}

echo '</div>';

if ( $wp_query->max_num_pages > 1 ) { ?>
		<nav class="prevnext pagination" role="navigation">
			<div class="nav-previous prev"><?php next_posts_link( '&larr; Older posts' ); ?></div>
			<div class="nav-next next"><?php previous_posts_link( 'Newer posts &rarr;' ); ?></div>
		</nav>
	<?php
}

get_footer();
