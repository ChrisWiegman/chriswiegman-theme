<?php
/**
 * The template for the developer page
 *
 * @since   6.0
 *
 * @package CW\Theme\Templates\Page\Developer
 *
 * @author  Chris Wiegman <chris@chriswiegman.com>
 */

namespace CW\Theme\Templates\Page\Developer;

get_header();
?>

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

						<div id="projects">

							<h2><?php esc_html_e( 'Selected Projects', 'chriswiegman' ); ?></h2>

							<!-- begin .archive-projects-->
							<ul class="archive-projects cpt-list">

								<?php
								$args = array( 'post_type' => 'project' );
								$loop = new \WP_Query( $args );
								?>

								<?php
								while ( $loop->have_posts() ) {

									$loop->the_post();

									?>
									<li id="post-<?php esc_attr( the_ID() ); ?>" <?php post_class(); ?>>

										<?php

										$title     = get_the_title();
										$permalink = esc_url( get_permalink() );
										$types     = get_the_terms( get_the_ID(), 'project-type' );
										$statuses  = get_the_terms( get_the_ID(), 'project-status' );

										if ( has_term( 'wordpress-plugin', 'project-type', get_the_ID() ) ) {

											$icon = 'wordpress';

										} elseif ( has_term( 'google-chrome-extension', 'project-type', get_the_ID() ) ) {

											$icon = 'google';

										} else {

											$icon = 'laptop';

										}

										?>

										<i class="list-icon icon-<?php echo esc_attr( $icon ); ?>"></i>

										<div class="entry-header">

											<?php printf( '<h3 class="entry-title"><a href="%s" title="%s" rel="bookmark">%s</a></h3>', esc_url( $permalink ), esc_attr( $title ), sanitize_text_field( $title ) ); ?>

											<div class="entry-meta">
											<span class="project-types">
												<?php esc_html_e( 'Type: ', 'ChrisWiegman' ); ?>
												<?php foreach ( $types as $type ) { ?>
													<?php
													$term_link = get_term_link( $type );

													if ( is_wp_error( $term_link ) ) {
														continue;
													}
													?>
													<span class="project-type"><?php echo esc_html( $type->name ); ?></span>
												<?php } ?>
											</span>
												<span class="project-statuses">
												<?php esc_html_e( 'Status: ', 'ChrisWiegman' ); ?>
													<?php foreach ( $statuses as $status ) { ?>
														<?php
														$term_link = get_term_link( $status );

														if ( is_wp_error( $term_link ) ) {
															continue;
														}
														?>
														<span class="project-status"><?php echo esc_html( $status->name ); ?></span>
													<?php } ?>
											</span>
											</div>
											<!-- .entry-meta -->

										</div>
										<div class="entry-description">
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

							<p class="projects-note"><?php esc_html_e( 'Note that "archived" projects are projects I am no longer involved in for
						one reason or another.', 'chriswiegman' ); ?></p>

						</div>

					</div>

				<?php } // End of the loop.
				?>
			</article><!-- #post-## -->
		</main>
		<!-- #main -->
	</div><!-- #primary -->

	<?php
get_sidebar();
get_footer();
