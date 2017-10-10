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
							$args  = array(
								'post_type' => 'speaking',
								'order'     => 'ASC',
								'orderby'   => 'title',
								'nopaging'  => true,
							);
							$loop  = new \WP_Query( $args );
							$count = 0;
							$icons = array(
								'megaphone',
								'comment',
								'user',
								'sitemap',
								'laptop',
								'fork',
								'info',
								'bank',
								'server',
								'television',
							);
							?>

							<?php
							while ( $loop->have_posts() ) {

								$count ++;
								$loop->the_post();

								?>
								<li id="post-<?php esc_attr( the_ID() ); ?>" <?php post_class(); ?>>

									<?php

									$title                 = get_the_title();
									$conference_names      = get_post_meta( get_the_ID(), '_conference_name' );
									$slide_url             = get_post_meta( get_the_ID(), '_slide_url' );
									$presentation_url      = get_post_meta( get_the_ID(), '_presentation_url' );
									$conference_url        = get_post_meta( get_the_ID(), '_conference_url' );
									$raw_presentation_date = get_post_meta( get_the_ID(), '_presentation_date' );
									$conference_location   = get_post_meta( get_the_ID(), '_conference_location' );
									$icon                  = $icons[ $count % 6 ];

									?>

									<div class="entry-header">

										<i class="list-icon icon-<?php echo esc_attr( $icon ); ?>"></i>

										<h3 class="entry-title"><?php echo esc_html( $title ); ?></h3>

										<?php foreach ( $conference_names as $index => $conference_name ) { ?>
											<div class="entry-meta">

												<?php

												if ( ! empty( $conference_name ) ) {

													echo '<span class="speaking-conference" >';

													if ( empty( $conference_url ) ) {

														echo esc_html( $conference_name );

													} else {

														printf( '<a href="%s" title="%s" target="_blank">%s</a>', esc_url( $conference_url[ $index ] ), esc_attr( $conference_name[ $index ] ), esc_html( $conference_name ) );

													}

													echo '</span >';

												}

												if ( ! empty( $raw_presentation_date[ $index ] ) ) {

													echo ' - <span class="speaking-date" >';

													echo esc_html( date( 'F Y', $raw_presentation_date[ $index ] ) );

													echo '</span >';
												}

												if ( ! empty( $conference_location[ $index ] ) ) {

													echo ' - <span class="speaking-location" >';

													echo esc_html( $conference_location[ $index ] );

													echo '</span >';
												}

												if ( ! empty( $slide_url[ $index ] ) || ! empty( $presentation_url[ $index ] ) ) {

													echo '<span class="presentation-links">';

													if ( ! empty( $slide_url[ $index ] ) ) {

														printf( '<span class="slide-link" ><a href="%s" title="%s" rel="bookmark">%s</a></span>', esc_url( $slide_url[ $index ] ), esc_attr( 'View slides from: ' . $title ), esc_attr__( 'View Slides', 'chriswiegman' ) );

													}

													if ( ! empty( $presentation_url[ $index ] ) ) {

														printf( '<span class="presentation-link" ><a href="%s" title="%s" rel="bookmark">%s</a></span>', esc_url( $presentation_url[ $index ] ), esc_attr( 'Watch presentation: ' . $title ), esc_attr__( 'Watch Talk', 'chriswiegman' ) );

													}

													echo '</span>';

												}

												?>

											</div>
										<?php } ?>
										<!-- .entry-meta -->

									</div>

									<?php the_post_thumbnail( 'medium_large' ); ?>

									<div class="entry-content">
										<?php the_content(); ?>
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
