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

						<h2><?php esc_html_e( 'Speaking', 'chriswiegman' ); ?></h2>

						<?php get_template_part( 'template-parts/content', 'speaking' ); ?>

					</div>

				</div>

			<?php } // End of the loop.
			?>
		</article><!-- #post-## -->
	</main>
	<!-- #main -->
</div><!-- #primary -->

<?php get_footer(); ?>
