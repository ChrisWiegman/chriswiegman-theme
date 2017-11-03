<?php
/**
 * The template for displaying the homepage
 *
 * @since   5.0.0
 *
 * @package CW\Theme\Templates\Home
 *
 * @author  Chris Wiegman <chris@chriswiegman.com>
 */

namespace CW\Theme\Templates\Home;

use CW\Theme\Functions\Template_Tags;

get_header();
?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

			<?php
			if ( have_posts() ) {

				/* Start the Loop */
				while ( have_posts() ) {

					the_post();

					get_template_part( 'template-parts/content', get_post_format() );

				}

				Template_Tags\paging_nav();

			} else {

				get_template_part( 'template-parts/content', 'none' );

			}
			?>

		</main><!-- #main -->
	</div><!-- #primary -->

	<?php
get_sidebar();
get_footer();
