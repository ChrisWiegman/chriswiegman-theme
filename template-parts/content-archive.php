<?php
/**
 * The archive content template
 *
 * @since   5.0.0
 *
 * @package CW\Theme\Templates\Parts\Content\Archive
 *
 * @author  Chris Wiegman <chris@chriswiegman.com>
 */

namespace CW\Theme\Templates\Parts\Content\Archive;

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
	</header>
	<!-- .entry-header -->

	<div class="entry-content">

		<?php the_content(); ?>

		<div class="archive-page">

			<h4><?php esc_html_e( 'Pages:', 'chriswiegman' ); ?></h4>
			<ul>
				<?php wp_list_pages( array( 'title_li' => '' ) ); ?>
			</ul>

			<h4><?php esc_html_e( '50 Latest Posts:', 'chriswiegman' ); ?></h4>
			<ul>
				<?php wp_get_archives( 'type=postbypost&limit=50' ); ?>
			</ul>

		</div>
		<!-- end .archive-page-->

		<div class="archive-page">

			<h4><?php esc_html_e( 'Categories:', 'chriswiegman' ); ?></h4>
			<ul>
				<?php wp_list_categories( 'sort_column=name&title_li=' ); ?>
			</ul>

		</div>

		<div class="clear"></div>
		<!-- end .archive-page-->

		<?php
		wp_link_pages(
			array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'chriswiegman' ),
				'after'  => '</div>',
			)
		);
		?>

	</div>
	<!-- .entry-content -->

	<footer class="entry-footer">
		<?php edit_post_link( esc_html__( 'Edit', 'chriswiegman' ), '<span class="edit-link">', '</span>' ); ?>
	</footer>
	<!-- .entry-footer -->
</article><!-- #post-## -->
