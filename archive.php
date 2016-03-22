<?php
/**
 * The template for displaying archive pages.
 *
 * @since   5.0.0
 *
 * @package CW\Theme\Templates\Archive
 *
 * @author  Chris Wiegman <chris@chriswiegman.com>
 */

namespace CW\Theme\Templates\Archive;

use CW\Theme\Functions\Template_Tags;

get_header(); ?>

<section id="primary" class="content-area">
	<main id="main" class="site-main" role="main">

		<?php if ( have_posts() ) : ?>

			<header class="page-header">
				<h1 class="page-title">
					<?php
					if ( is_category() ) :

						single_cat_title();
						esc_html_e( ' Posts', 'chriswiegman' );

					elseif ( is_tag() ) :
						single_tag_title();

					elseif ( is_author() ) :
						printf( __( 'Author: %s', 'chriswiegman' ), '<span class="vcard">' . get_the_author() . '</span>' );

					elseif ( is_day() ) :
						printf( __( 'Day: %s', 'chriswiegman' ), '<span>' . get_the_date() . '</span>' );

					elseif ( is_month() ) :
						printf( __( 'Month: %s', 'chriswiegman' ), '<span>' . get_the_date( _x( 'F Y', 'monthly archives date format', 'chriswiegman' ) ) . '</span>' );

					elseif ( is_year() ) :
						printf( __( 'Year: %s', 'chriswiegman' ), '<span>' . get_the_date( _x( 'Y', 'yearly archives date format', 'chriswiegman' ) ) . '</span>' );

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
						esc_html_e( 'Archives', 'chriswiegman' );

					endif;
					?>
				</h1>
			</header><!-- .page-header -->

			<?php /* Start the Loop */ ?>
			<?php while ( have_posts() ) : the_post(); ?>

				<?php
				/**
				 * Include the Post-Format-specific template for the content.
				 * If you want to override this in a child theme, then include a file
				 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
				 */
				get_template_part( 'template-parts/content', get_post_format() );
				?>

			<?php endwhile; ?>

			<?php Template_Tags\paging_nav(); ?>

		<?php else : ?>

			<?php get_template_part( 'template-parts/content', 'none' ); ?>

		<?php endif; ?>

	</main><!-- #main -->
</section><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
