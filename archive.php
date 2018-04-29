<?php
/**
 * The template for displaying archive pages.
 *
 * Template Name: Archive page
 *
 * @since   5.0.0
 *
 * @package CW\Theme\Templates\Archive
 *
 * @author  Chris Wiegman <chris@chriswiegman.com>
 */

namespace CW\Theme\Templates\Archive;

use CW\Theme\Functions\Template_Tags;

get_header();

$archive_page = false;
?>

	<section id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

			<?php

			if ( have_posts() ) {
				?>

				<header class="page-header">
					<h1 class="page-title">
						<?php

						if ( is_category() ) :

							single_cat_title();
							esc_html_e( ' Posts', 'chriswiegman' );

						elseif ( is_tag() ) :
							single_tag_title();

						elseif ( is_author() ) :

							// translators: author name.
							printf( esc_html__( 'Author: %s', 'chriswiegman' ), '<span class="vcard">' . get_the_author() . '</span>' );

						elseif ( is_day() ) :

							// translators: the date.
							printf( esc_html__( 'Day: %s', 'chriswiegman' ), '<span>' . get_the_date() . '</span>' );

						elseif ( is_month() ) :

							// translators: the month.
							printf( esc_html__( 'Month: %s', 'chriswiegman' ), '<span>' . get_the_date( _x( 'F Y', 'monthly archives date format', 'chriswiegman' ) ) . '</span>' );

						elseif ( is_year() ) :

							// translators: the year.
							printf( esc_html__( 'Year: %s', 'chriswiegman' ), '<span>' . get_the_date( _x( 'Y', 'yearly archives date format', 'chriswiegman' ) ) . '</span>' );

						elseif ( is_tax( 'post_format', 'post-format-aside' ) ) :
							esc_html_e( 'Asides', 'chriswiegman' );

						elseif ( is_tax( 'post_format', 'post-format-gallery' ) ) :
							esc_html_e( 'Galleries', 'chriswiegman' );

						elseif ( is_tax( 'post_format', 'post-format-image' ) ) :
							esc_html_e( 'Images', 'chriswiegman' );

						elseif ( is_tax( 'post_format', 'post-format-video' ) ) :
							esc_html_e( 'Videos', 'chriswiegman' );

						elseif ( is_tax( 'post_format', 'post-format-quote' ) ) :
							esc_html_e( 'Quotes', 'chriswiegman' );

						elseif ( is_tax( 'post_format', 'post-format-link' ) ) :
							esc_html_e( 'Links', 'chriswiegman' );

						elseif ( is_tax( 'post_format', 'post-format-status' ) ) :
							esc_html_e( 'Statuses', 'chriswiegman' );

						elseif ( is_tax( 'post_format', 'post-format-audio' ) ) :
							esc_html_e( 'Audios', 'chriswiegman' );

						elseif ( is_tax( 'post_format', 'post-format-chat' ) ) :
							esc_html_e( 'Chats', 'chriswiegman' );

						else :
							$archive_page = true;

						endif;
						?>
					</h1>
				</header><!-- .page-header -->

				<?php

				if ( true === $archive_page ) {

					while ( have_posts() ) :
						the_post();
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

						<?php
					endwhile; // End of the loop.

				} else {

					while ( have_posts() ) {

						the_post();
						get_template_part( 'template-parts/content', get_post_format() );

					}

					Template_Tags\paging_nav();

				}
			} else {

				get_template_part( 'template-parts/content', 'none' );

			}
			?>

		</main><!-- #main -->
	</section><!-- #primary -->

	<?php

	get_sidebar();
	get_footer();
