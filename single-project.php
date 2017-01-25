<?php
/**
 * The template for all single projects
 *
 * @since   5.0.0
 *
 * @package CW\Theme\Templates\Single\Project
 *
 * @author  Chris Wiegman <chris@chriswiegman.com>
 */

namespace CW\Theme\Templates\Single\Project;

use CW\Theme\Functions\Template_Tags;

get_header(); ?>

<div id="primary" class="content-area">
	<main id="main" class="site-main" role="main">

		<?php while ( have_posts() ) : the_post(); ?>

			<?php get_template_part( 'template-parts/content', 'project' ); ?>

			<?php Template_Tags\post_nav(); ?>

		<?php endwhile; // End of the loop.
		?>

	</main>
	<!-- #main -->
</div><!-- #primary -->

<?php get_footer(); ?>
