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

use CW\Theme\Functions\Template_Tags;

get_header(); ?>

	<section id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

			<section class="no-results not-found hentry">
				<header class="page-header">
					<h1 class="page-title"><?php esc_html_e( 'Oops! That page can&rsquo;t be found.', 'chriswiegman' ); ?></h1>
				</header><!-- .page-header -->

				<p><?php esc_html_e( 'It looks like nothing was found at this location. Maybe try a search?', 'chriswiegman' ); ?></p>

				<?php get_search_form(); ?>

			</section>

		</main><!-- #main -->
	</section><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>