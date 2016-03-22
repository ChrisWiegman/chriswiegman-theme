<?php
/**
 * The template used for displaying single post content
 *
 * @since   5.0.0
 *
 * @package CW\Theme\Templates\Parts\Content\Single
 *
 * @author  Chris Wiegman <chris@chriswiegman.com>
 */

namespace CW\Theme\Templates\Parts\Content\Single;

use CW\Theme\Functions\Template_Tags;

?>

<article id="post-<?php esc_attr( the_ID() ); ?>" <?php post_class(); ?>>
	<?php

	$title     = get_the_title();
	$permalink = esc_url( get_permalink() );

	if ( has_post_thumbnail() && ! has_post_format( 'image' ) ) {
		printf( '<div class="featured-image"><a class="post-header-image" href="%s" rel="bookmark" title="%s">%s</a></div>', esc_url( $permalink ), esc_attr( $title ), get_the_post_thumbnail() );
	}

	?>

	<header class="entry-header">
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>

		<div class="entry-meta">
			<?php Template_Tags\posted_on(); ?>
		</div>
		<!-- .entry-meta -->
	</header>
	<!-- .entry-header -->

	<div class="entry-content">
		<?php the_content(); ?>
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

</article><!-- #post-## -->
