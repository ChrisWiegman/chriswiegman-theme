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
		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

			<?php
			while ( have_posts() ) {

				the_post();
				?>

				<header class="entry-header">
					<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
				</header>

				<div class="entry-content">

					<h2><?php esc_html_e( 'Bio', 'chriswiegman' ); ?></h2>

					<?php the_content(); ?>

					<div id="projects">

						<h2><?php esc_html_e( 'Projects', 'chriswiegman' ); ?></h2>

						<p id="projects-intro">
							<?php echo wp_kses_post( get_post_meta( get_the_ID(), 'projects_intro', true ) ); ?>
						</p>

						<?php get_template_part( 'template-parts/content', 'projects' ); ?>
						<p class="projects-note"><?php esc_html_e( 'Note that "archived" projects are projects I am no longer involved in for
						one reason or another.', 'chriswiegman' ); ?></p>

					</div>

					<div id="speaking">

						<h2><?php esc_html_e( 'Speaking', 'chriswiegman' ); ?></h2>

						<p id="speaking-intro">
							<?php echo wp_kses_post( get_post_meta( get_the_ID(), 'speaking_intro', true ) ); ?>
						</p>

						<?php get_template_part( 'template-parts/content', 'speaking' ); ?>

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