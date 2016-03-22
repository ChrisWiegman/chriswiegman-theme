<?php
/**
 * The template for the speaking page
 *
 * @since   5.0.0
 *
 * @package CW\Theme\Templates\Page\Speaking
 *
 * @author  Chris Wiegman <chris@chriswiegman.com>
 */

namespace CW\Theme\Templates\Page\Speaking;

get_header(); ?>

<div id="primary" class="content-area">
	<main id="main" class="site-main" role="main">

		<?php
		while ( have_posts() ) {

			the_post();
			?>

			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<header class="entry-header">
					<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
				</header>
				<!-- .entry-header -->

				<div class="entry-content">
					<?php the_content(); ?>
					<?php get_template_part( 'template-parts/content', 'speaking' ); ?>
				</div>
				<!-- .entry-content -->
			</article><!-- #post-## -->

		<?php } // End of the loop.
		?>

	</main>
	<!-- #main -->
</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
