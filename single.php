<?php
/**
 * The template for displaying all single posts.
 *
 * @package ChrisWiegman
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

			<?php while ( have_posts() ) : the_post(); ?>

				<?php get_template_part( 'content', 'single' ); ?>

				<?php

				do_action( 'cw_before_author' );

				$links = array(
					'facebook' => get_the_author_meta( 'facebook' ),
					'github' => get_the_author_meta( 'github' ),
					'wordpress' => get_the_author_meta( 'wordpress' ),
					'twitter'  => get_the_author_meta( 'twitter' ),
					'google'   => get_the_author_meta( 'googleplus' ),
				);

				$profiles = array();

				foreach ( $links as $link => $url ) {

					if ( strstr( $url, 'http' ) ) {

						$url = parse_url( $url, PHP_URL_PATH );
						$url = substr( $url, 1 );

					}

					$profiles[ $link ]['url']    = $url;
					$profiles[ $link ]['length'] = strlen( $url );

				}

				echo '<div class="author-box">' . PHP_EOL;

				echo get_avatar( get_the_author_meta( 'ID' ), 100 );

				if ( strlen( get_the_author_meta( 'url' ) ) > 1 ) {
					echo '<strong>About <a href="' . get_the_author_meta( 'url' ) . '" target="_blank" title="' . get_the_author_meta( 'website_title' ) . '">' . get_the_author_meta( 'display_name' ) . '</a></strong>' . PHP_EOL;
				} else {
					echo '<strong>About ' . get_the_author_meta( 'display_name' ) . '</strong>' . PHP_EOL;
				}

				echo '<p>' . get_the_author_meta( 'description' ) . '</p>' . PHP_EOL;

				if ( $profiles['facebook']['length'] > 1 || $profiles['linkedin']['length'] > 1 || $profiles['twitter']['length'] > 1 || $profiles['google']['length'] > 1 ) {

					if ( ( $profiles['facebook']['length'] <= 1 && $profiles['google']['length'] <= 1 && $profiles['linkedin']['length'] <= 1 ) && $profiles['twitter']['length'] > 1 ) {
						echo '<p id="authcontact">Follow ' . get_the_author_meta( 'first_name' ) . ' on <a href="http://twitter.com/' . $profiles['twitter']['url'] . '" target="_blank" title="' . get_the_author_meta( 'display_name' ) . ' on Twitter">Twitter</a></p>' . PHP_EOL;
					} else {

						echo '<p id="authcontact">Find ' . get_the_author_meta( 'first_name' ) . ' on ';

						if ( $profiles['facebook']['length'] > 1 ) {

							echo ' <a href="https://facebook.com/' . $profiles['facebook']['url'] . '" target="_blank" title="' . get_the_author_meta( 'display_name' ) . ' on Facebook">Facebook</a>';

						}

						if ( $profiles['google']['length'] > 1 ) {

							$comma = $profiles['facebook']['length'] > 1 ? ',' : '';
							$and   = $profiles['facebook']['length'] > 1 && ( $profiles['github']['length'] <= 1 || $profiles['twitter']['length'] <= 1 ) ? ' and' : '';
							echo $comma . $and . ' <a href="https://plus.google.com/' . $profiles['google']['url'] . '?rel=author" rel="author" target="_blank" title="' . get_the_author_meta( 'display_name' ) . ' on Google+">Google+</a>';

						}

						if ( $profiles['github']['length'] > 1 ) {

							$comma = $profiles['facebook']['length'] > 1 || $profiles['google']['length'] > 1 ? ',' : '';
							$and   = ( $profiles['facebook']['length'] > 1 || $profiles['google']['length'] > 1 ) && $profiles['twitter']['length'] <= 1 ? ' and' : '';
							echo $comma . $and . ' <a href="https://github.com/' . $profiles['github']['url'] . '" target="_blank" title="' . get_the_author_meta( 'display_name' ) . ' on GitHub">GitHub</a>';

						}

						if ( $profiles['wordpress']['length'] > 1 ) {

							$comma = $profiles['facebook']['length'] > 1 || $profiles['google']['length'] > 1  || $profiles['github']['length'] > 1 ? ',' : '';
							$and   = ( $profiles['facebook']['length'] > 1 || $profiles['google']['length'] > 1 || $profiles['github']['length'] > 1 ) && $profiles['twitter']['length'] <= 1 ? ' and' : '';
							echo $comma . $and . ' <a href="https://profiles.wordpress.org/' . $profiles['wordpress']['url'] . '" target="_blank" title="' . get_the_author_meta( 'display_name' ) . ' on WordPress.org">WordPress.org</a>';

						}

						if ( $profiles['twitter']['length'] > 1 ) {
							echo ', and <a href="https://twitter.com/' . $profiles['twitter']['url'] . '" target="_blank" title="' . get_the_author_meta( 'display_name' ) . ' on Twitter">Twitter</a>';
						}

						echo '.</p>' . PHP_EOL;

					}

				}

				echo '</div>' . PHP_EOL;

				?>

				<?php
				// If comments are open or we have at least one comment, load up the comment template
				if ( comments_open() || '0' != get_comments_number() ) :
					comments_template();
				endif;
				?>

				<?php chriswiegman_post_nav(); ?>

			<?php endwhile; // end of the loop. ?>

		</main>
		<!-- #main -->
	</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>