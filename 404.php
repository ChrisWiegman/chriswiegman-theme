<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @since   5.0.0
 *
 * @package CW\Theme\Templates\Four_Oh_Four
 *
 * @author  Chris Wiegman <chris@chriswiegman.com>
 */

namespace CW\Theme\Templates\Four_Oh_Four;

get_header(); ?>

	<section id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

			<section class="no-results not-found hentry">
				<header class="entry-header">
					<h1 class="entry-title"><?php esc_html_e( 'Oops! That page can&rsquo;t be found.', 'chriswiegman' ); ?></h1>
				</header><!-- .page-header -->

				<div class="entry-content">

					<p><?php esc_html_e( 'It looks like nothing was found at this location. Maybe try a search?', 'chriswiegman' ); ?></p>

					<?php get_search_form(); ?>

				</div>

			</section>

		</main><!-- #main -->
	</section><!-- #primary -->

<?php get_footer(); ?>
