<?php
/**
 * The content template
 *
 * @since   5.0.0
 *
 * @package CW\Theme\Templates\Parts\Content
 *
 * @author  Chris Wiegman <chris@chriswiegman.com>
 */

namespace CW\Theme\Templates\Parts\Content;

use CW\Theme\Functions\Template_Tags;

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php

	$title     = get_the_title();
	$permalink = esc_url( get_permalink() );

	if ( has_post_thumbnail() ) {
		printf( '<div class="featured-image"><a class="post-header-image" href="%s" rel="bookmark" title="%s">%s</a></div>', esc_url( $permalink ), esc_attr( $title ), get_the_post_thumbnail() );
	}

	?>

	<?php if ( ! has_post_format( 'quote' ) ) { ?>
		<header class="entry-header">

			<?php printf( '<h2 class="entry-title"><a href="%s" title="%s" rel="bookmark">%s</a></h2>', esc_url( $permalink ), esc_attr( $title ), esc_html( $title ) ); ?>

			<?php if ( 'post' === get_post_type() ) { ?>
				<div class="entry-meta">
					<?php Template_Tags\posted_on(); ?>
				</div><!-- .entry-meta -->
			<?php } ?>

		</header>
	<?php } ?>
	<!-- .entry-header -->

	<div class="entry-content">
		<?php
		if ( ! has_post_format( 'quote' ) ) {
			the_excerpt();
		} else {
			the_content();
		}

		wp_link_pages(
			array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'chriswiegman' ),
				'after'  => '</div>',
			)
		);
		?>
	</div>
	<!-- .entry-content -->

</article><!-- #post-## -->
