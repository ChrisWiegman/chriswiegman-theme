<?php
/**
 * The template for the search results page
 *
 * @since   5.0.0
 *
 * @package CW\Theme\Templates\Search
 *
 * @author  Chris Wiegman <chris@chriswiegman.com>
 */

namespace CW\Theme\Templates\Search;

use CW\Theme\Functions\Template_Tags;

get_header();
?>

	<section id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

			<?php
			if ( have_posts() ) {
				?>

				<header class="page-header">

					<?php // translators: search query. ?>
					<h1 class="page-title"><?php printf( esc_html__( 'Search Results for: %s', 'chriswiegman' ), '<span>' . esc_html( get_search_query() ) . '</span>' ); ?></h1>
				</header><!-- .page-header -->

				<?php
				/* Start the Loop */
				while ( have_posts() ) {
					the_post();

					get_template_part( 'template-parts/content' );

				}

				Template_Tags\paging_nav();

			} else {

				get_template_part( 'template-parts/content', 'none' );

			}

			?>

		</main><!-- #main -->
	</section><!-- #primary -->

	<?php
	get_sidebar();
	get_footer();
