<?php
/**
 * The template for the speaker page
 *
 * @since   6.0
 *
 * @package CW\Theme\Templates\Page\Speaker
 *
 * @author  Chris Wiegman <chris@chriswiegman.com>
 */

namespace CW\Theme\Templates\Page\Speaker;

get_header(); ?>

<div id="primary" class="content-area">
	<main id="main" class="site-main" role="main">
		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

			<?php
			while ( have_posts() ) {

				the_post();
				?>

				<header class="entry-header">
					<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
				</header>

				<div class="entry-content">

					<?php the_content(); ?>

					<div id="speaking">

						<h2><?php esc_html_e( 'Selected Talks', 'chriswiegman' ); ?></h2>

						<!-- begin .archive-projects-->
						<ul class="archive-speaking cpt-list">

							<?php
							$args = array(
								'post_type' => 'speaking',
								'order'     => 'DESC',
								'orderby'   => 'meta_value_num',
								'meta_key'  => '_presentation_date',
								'nopaging'  => true,
							);
							$loop = new \WP_Query( $args );
							?>

							<?php
							while ( $loop->have_posts() ) {

								$loop->the_post();

								?>
								<li id="post-<?php esc_attr( the_ID() ); ?>" <?php post_class(); ?>>

									<?php

									$title                 = get_the_title();
									$conference_name       = get_post_meta( get_the_ID(), '_conference_name', true );
									$slide_url             = get_post_meta( get_the_ID(), '_slide_url', true );
									$conference_url        = get_post_meta( get_the_ID(), '_conference_url', true );
									$raw_presentation_date = get_post_meta( get_the_ID(), '_presentation_date', true );
									$conference_location   = get_post_meta( get_the_ID(), '_conference_location', true );
									$presentation_date     = empty( $raw_presentation_date ) ? '' : date( 'F Y', $raw_presentation_date );

									?>

									<div class="entry-header">

										<?php
										if ( empty( $slide_url ) ) {

											printf( '<h2 class="entry-title">%s</h2>', esc_html( $title ) );

										} else {

											printf( '<h2 class="entry-title"><a href="%s" title="%s" rel="bookmark">%s</a></h2>', esc_url( $slide_url ), esc_attr( 'View slides from: ' . $title ), sanitize_text_field( $title ) );

										}
										?>

										<div class="entry-meta">

											<?php

											if ( ! empty( $conference_name ) ) {

												echo '<span class="speaking-conference" >';

												if ( empty( $conference_url ) ) {

													echo esc_html( $conference_name );

												} else {

													printf( '<a href="%s" title="%s" target="_blank">%s</a>', esc_url( $conference_url ), esc_attr( $conference_name ), esc_html( $conference_name ) );

												}

												echo '</span >';

											}

											if ( ! empty( $presentation_date ) ) {

												echo ' - <span class="speaking-date" >';

												echo esc_html( $presentation_date );

												echo '</span >';
											}

											if ( ! empty( $conference_location ) ) {

												echo ' - <span class="speaking-location" >';

												echo esc_html( $conference_location );

												echo '</span >';
											}

											?>

										</div>
										<!-- .entry-meta -->

									</div>
									<!-- .entry-header -->
									<div class="divider"></div>
								</li><!-- #post-## -->

								<?php

							}
							wp_reset_postdata();
							?>

						</ul>
						<!-- end .archive-projects-->

					</div>

				</div>

			<?php } // End of the loop.
			?>
		</article><!-- #post-## -->
	</main>
	<!-- #main -->
</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
