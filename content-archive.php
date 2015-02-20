<?php
/**
 * @package ChrisWiegman
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
	</header>
	<!-- .entry-header -->

	<div class="entry-content">

		<?php the_content(); ?>

		<div class="archive-page">

			<h4><?php _e( 'Pages:', 'genesis' ); ?></h4>
			<ul>
				<?php wp_list_pages( array( 'title_li' => '' ) ); ?>
			</ul>

			<h4><?php _e( '50 Latest Posts:', 'genesis' ); ?></h4>
			<ul>
				<?php wp_get_archives( 'type=postbypost&limit=50' ); ?>
			</ul>

		</div>
		<!-- end .archive-page-->

		<div class="archive-page">

			<h4><?php _e( 'Categories:', 'genesis' ); ?></h4>
			<ul>
				<?php wp_list_categories( 'sort_column=name&title_li=' ); ?>
			</ul>

			<h4><?php _e( 'Authors:', 'genesis' ); ?></h4>
			<ul>
				<?php wp_list_authors( 'exclude_admin=0&optioncount=1' ); ?>
			</ul>

		</div>

		<div class="clear"></div>
		<!-- end .archive-page-->

		<?php
		wp_link_pages( array(
			               'before' => '<div class="page-links">' . __( 'Pages:', 'chriswiegman' ),
			               'after'  => '</div>',
		               ) );
		?>

	</div>
	<!-- .entry-content -->

	<footer class="entry-footer">
		<?php edit_post_link( __( 'Edit', 'chriswiegman' ), '<span class="edit-link">', '</span>' ); ?>
	</footer>
	<!-- .entry-footer -->
</article><!-- #post-## -->