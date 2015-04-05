<?php
/**
 * The template for displaying the projects.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package ChrisWiegman
 */

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
					<?php get_template_part( 'content', 'projects' ); ?>
					<p class="projects-note">Note that "archived" projects are projects I am no longer involved in for one reason or another.</p>
				</div>
				<!-- .entry-content -->
			</article><!-- #post-## -->

		<?php } // end of the loop. ?>

	</main>
	<!-- #main -->
</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
