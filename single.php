<?php
/**
 * The template for all single posts
 *
 * @since   5.0.0
 *
 * @package CW\Theme\Templates\Single
 *
 * @author  Chris Wiegman <chris@chriswiegman.com>
 */

namespace CW\Theme\Templates\Single;

use CW\Theme\Functions\Template_Tags;

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

			<?php while ( have_posts() ) : the_post(); ?>

				<article id="post-<?php esc_attr( the_ID() ); ?>" <?php post_class(); ?>>
					<?php

					$title     = get_the_title();
					$permalink = esc_url( get_permalink() );

					if ( has_post_thumbnail() && ! has_post_format( 'image' ) ) {
						printf( '<div class="featured-image"><a class="post-header-image" href="%s" rel="bookmark" title="%s">%s</a></div>', esc_url( $permalink ), esc_attr( $title ), get_the_post_thumbnail() );
					}

					?>

					<header class="entry-header">
						<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>

						<div class="entry-meta">
							<?php Template_Tags\posted_on(); ?>
						</div>
						<!-- .entry-meta -->
					</header>
					<!-- .entry-header -->

					<div class="entry-content">
						<?php the_content(); ?>
						<?php
						wp_link_pages(
							array(
								'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'chriswiegman' ),
								'after'  => '</div>',
							)
						);
						?>
					</div>
					<!-- .entry-content -->

				</article><!-- #post-## -->

				<?php

				do_action( 'cw_before_author' );

				$links = array(
					'facebook'  => get_the_author_meta( 'facebook' ),
					'github'    => get_the_author_meta( 'github' ),
					'wordpress' => get_the_author_meta( 'wordpress' ),
					'twitter'   => get_the_author_meta( 'twitter' ),
					'google'    => get_the_author_meta( 'googleplus' ),
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
					echo '<strong>About <a href="' . esc_url( get_the_author_meta( 'url' ) ) . '" target="_blank" title="' . esc_attr( get_the_author_meta( 'website_title' ) ) . '">' . esc_html( get_the_author_meta( 'display_name' ) ) . '</a></strong>' . PHP_EOL;
				} else {
					echo '<strong>About ' . esc_html( get_the_author_meta( 'display_name' ) ) . '</strong>' . PHP_EOL;
				}

				echo '<p>' . wp_kses_post( get_the_author_meta( 'description' ) ) . '</p>' . PHP_EOL;

				if ( 1 < $profiles['facebook']['length'] || 1 < $profiles['linkedin']['length'] || 1 < $profiles['twitter']['length'] || 1 < $profiles['google']['length'] ) {

					if ( ( 1 >= $profiles['facebook']['length'] && 1 >= $profiles['google']['length'] && 1 >= $profiles['linkedin']['length'] ) && 1 < $profiles['twitter']['length'] ) {
						echo '<p id="authcontact">Follow ' . esc_attr( get_the_author_meta( 'first_name' ) ) . ' on <a href="http://twitter.com/' . $profiles['twitter']['url'] . '" target="_blank" title="' . esc_attr( get_the_author_meta( 'display_name' ) ) . ' on Twitter">Twitter</a></p>' . PHP_EOL;
					} else {

						echo '<p id="authcontact">Find ' . esc_html( get_the_author_meta( 'first_name' ) ) . ' on ';

						if ( 1 < $profiles['facebook']['length'] ) {

							echo ' <a href="https://facebook.com/' . $profiles['facebook']['url'] . '" target="_blank" title="' . esc_attr( get_the_author_meta( 'display_name' ) ) . ' on Facebook">Facebook</a>';

						}

						if ( 1 < $profiles['google']['length'] ) {

							$comma = $profiles['facebook']['length'] > 1 ? ',' : '';
							$and   = $profiles['facebook']['length'] > 1 && ( $profiles['github']['length'] <= 1 || $profiles['twitter']['length'] <= 1 ) ? ' and' : '';
							echo $comma . $and . ' <a href="https://plus.google.com/' . $profiles['google']['url'] . '?rel=author" rel="author" target="_blank" title="' . get_the_author_meta( 'display_name' ) . ' on Google+">Google+</a>';

						}

						if ( 1 < $profiles['github']['length'] ) {

							$comma = $profiles['facebook']['length'] > 1 || $profiles['google']['length'] > 1 ? ',' : '';
							$and   = ( $profiles['facebook']['length'] > 1 || $profiles['google']['length'] > 1 ) && $profiles['twitter']['length'] <= 1 ? ' and' : '';
							echo $comma . $and . ' <a href="https://github.com/' . $profiles['github']['url'] . '" target="_blank" title="' . get_the_author_meta( 'display_name' ) . ' on GitHub">GitHub</a>';

						}

						if ( 1 < $profiles['wordpress']['length'] ) {

							$comma = $profiles['facebook']['length'] > 1 || $profiles['google']['length'] > 1 || $profiles['github']['length'] > 1 ? ',' : '';
							$and   = ( $profiles['facebook']['length'] > 1 || $profiles['google']['length'] > 1 || $profiles['github']['length'] > 1 ) && $profiles['twitter']['length'] <= 1 ? ' and' : '';
							echo $comma . $and . ' <a href="https://profiles.wordpress.org/' . $profiles['wordpress']['url'] . '" target="_blank" title="' . get_the_author_meta( 'display_name' ) . ' on WordPress.org">WordPress.org</a>';

						}

						if ( 1 < $profiles['twitter']['length'] ) {
							echo ', and <a href="https://twitter.com/' . $profiles['twitter']['url'] . '" target="_blank" title="' . get_the_author_meta( 'display_name' ) . ' on Twitter">Twitter</a>';
						}

						echo '.</p>' . PHP_EOL;

					}
				}

				echo '</div>' . PHP_EOL;

				?>

				<?php
				// If comments are open or we have at least one comment, load up the comment template.
				if ( comments_open() || 0 !== get_comments_number() ) :
					comments_template();
				endif;
				?>

				<?php Template_Tags\post_nav(); ?>

			<?php endwhile; // End of the loop.
			?>

		</main>
		<!-- #main -->
	</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>