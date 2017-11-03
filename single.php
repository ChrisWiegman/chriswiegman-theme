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

get_header();
?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

			<?php
			while ( have_posts() ) {
				the_post();
				?>

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

						$url = wp_parse_url( $url, PHP_URL_PATH );
						$url = substr( $url, 1 );

					}

					$profiles[ $link ]['url']    = $url;
					$profiles[ $link ]['length'] = strlen( $url );

				}

				echo '<div class="author-box">';

				echo get_avatar( get_the_author_meta( 'ID' ), 100 );

				if ( strlen( get_the_author_meta( 'url' ) ) > 1 ) {
					echo '<strong>About <a href="' . esc_url( get_the_author_meta( 'url' ) ) . '" target="_blank" title="' . esc_attr( get_the_author_meta( 'website_title' ) ) . '">' . esc_html( get_the_author_meta( 'display_name' ) ) . '</a></strong>';
				} else {
					echo '<strong>About ' . esc_html( get_the_author_meta( 'display_name' ) ) . '</strong>';
				}

				echo '<p>' . wp_kses_post( get_the_author_meta( 'description' ) ) . '</p>';

				if (
					(
						isset( $profiles['facebook'] ) &&
						isset( $profiles['facebook']['length'] ) &&
						1 < $profiles['facebook']['length']
					) ||
					(
						isset( $profiles['linkedin'] ) &&
						isset( $profiles['linkedin']['length'] ) &&
						1 < $profiles['linkedin']['length']
					) ||
					(
						isset( $profiles['google'] ) &&
						isset( $profiles['google']['length'] ) &&
						1 < $profiles['google']['length']
					) ||
					(
						isset( $profiles['twitter'] ) &&
						isset( $profiles['twitter']['length'] ) &&
						1 < $profiles['twitter']['length']
					) ||
					(
						isset( $profiles['wordpress'] ) &&
						isset( $profiles['wordpress']['length'] ) &&
						1 < $profiles['wordpress']['length']
					) ||
					(
						isset( $profiles['github'] ) &&
						isset( $profiles['github']['length'] ) &&
						1 < $profiles['github']['length']
					)

				) {

					if (
						(
							isset( $profiles['facebook'] ) &&
							isset( $profiles['facebook']['length'] ) &&
							1 >= $profiles['facebook']['length']
						) &&
						(
							isset( $profiles['linkedin'] ) &&
							isset( $profiles['linkedin']['length'] ) &&
							1 >= $profiles['linkedin']['length']
						) &&
						(
							isset( $profiles['google'] ) &&
							isset( $profiles['google']['length'] ) &&
							1 >= $profiles['google']['length']
						) &&
						(
							isset( $profiles['twitter'] ) &&
							isset( $profiles['twitter']['length'] ) &&
							1 >= $profiles['twitter']['length']
						) &&
						(
							isset( $profiles['wordpress'] ) &&
							isset( $profiles['wordpress']['length'] ) &&
							1 >= $profiles['wordpress']['length']
						) &&
						(
							isset( $profiles['github'] ) &&
							isset( $profiles['github']['length'] ) &&
							1 >= $profiles['github']['length']
						)
					) {

						echo '<p id="authcontact">Follow ' . esc_attr( get_the_author_meta( 'first_name' ) ) . ' on <a href="http://twitter.com/' . $profiles['twitter']['url'] . '" target="_blank" title="' . esc_attr( get_the_author_meta( 'display_name' ) ) . ' on Twitter">Twitter</a></p>';

					} else {

						echo '<p id="authcontact">Find ' . esc_html( get_the_author_meta( 'first_name' ) ) . ' on ';

						$links = array();

						if (
							isset( $profiles['facebook'] ) &&
							isset( $profiles['facebook']['length'] ) &&
							1 < $profiles['facebook']['length']
						) {

							$links[] = '<a href="https://facebook.com/' . esc_attr( $profiles['facebook']['url'] ) . '" target="_blank" title="' . esc_attr( get_the_author_meta( 'display_name' ) ) . ' on Facebook">Facebook</a>';

						}

						if (
							isset( $profiles['google'] ) &&
							isset( $profiles['google']['length'] ) &&
							1 < $profiles['google']['length']
						) {

							$links[] = '<a href="https://plus.google.com/' . esc_attr( $profiles['google']['url'] ) . '?rel=author" rel="author" target="_blank" title="' . esc_attr( get_the_author_meta( 'display_name' ) ) . ' on Google+">Google+</a>';

						}

						if (
							isset( $profiles['github'] ) &&
							isset( $profiles['github']['length'] ) &&
							1 < $profiles['github']['length']
						) {

							$links[] = '<a href="https://github.com/' . esc_attr( $profiles['github']['url'] ) . '" target="_blank" title="' . esc_attr( get_the_author_meta( 'display_name' ) ) . ' on GitHub">GitHub</a>';

						}

						if (
							isset( $profiles['wordpress'] ) &&
							isset( $profiles['wordpress']['length'] ) &&
							1 < $profiles['wordpress']['length']
						) {

							$links[] = '<a href="https://profiles.wordpress.org/' . esc_attr( $profiles['wordpress']['url'] ) . '" target="_blank" title="' . esc_attr( get_the_author_meta( 'display_name' ) ) . ' on WordPress.org">WordPress.org</a>';

						}

						if (
							isset( $profiles['linkedin'] ) &&
							isset( $profiles['linkedin']['length'] ) &&
							1 < $profiles['linkedin']['length']
						) {

							$links[] = '<a href="https://www.linkedin.com/in/' . esc_attr( $profiles['linkedin']['url'] ) . '/" target="_blank" title="' . esc_attr( get_the_author_meta( 'display_name' ) ) . ' on LinkedIn">LinkedIn</a>';

						}

						if (
							isset( $profiles['twitter'] ) &&
							isset( $profiles['twitter']['length'] ) &&
							1 < $profiles['twitter']['length']
						) {

							$links[] = '<a href="https://twitter.com/' . esc_attr( $profiles['twitter']['url'] ) . '" target="_blank" title="' . esc_attr( get_the_author_meta( 'display_name' ) ) . ' on Twitter">Twitter</a>';

						}

						$link_count = count( $links );

						for ( $i = 0; $i < $link_count; $i ++ ) {

							// @codingStandardsIgnoreStart
							if ( 1 <= $i ) {
								echo ', ';
							}

							if ( $i === ( $link_count - 1 ) ) {
								echo 'and ';
							}

							echo $links[ $i ];
							// @codingStandardsIgnoreEnd

						}

						echo '.</p>';

					} // End if().
				} // End if().

				echo '</div>';

				// If comments are open or we have at least one comment, load up the comment template.
				if ( comments_open() || 0 !== get_comments_number() ) {
					comments_template();
				}

				Template_Tags\post_nav();

			} // End of the loop.
			?>

		</main>
		<!-- #main -->
	</div><!-- #primary -->

	<?php
get_sidebar();
get_footer();
