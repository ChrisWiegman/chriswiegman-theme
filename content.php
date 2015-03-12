<?php
/**
 * @package ChrisWiegman
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php

	$title     = get_the_title();
	$permalink = esc_url( get_permalink() );

	if ( has_post_thumbnail() ) {
		printf( '<div class="featured-image"><a class="post-header-image" href="%s" rel="bookmark" title="%s">%s</a></div>', $permalink, $title, get_the_post_thumbnail() );
	}

	?>

	<?php if ( ! has_post_format( 'quote' ) ) { ?>
		<header class="entry-header">

			<?php printf( '<h2 class="entry-title"><a href="%s" title="%s" rel="bookmark">%s</a></h2>', $permalink, $title, $title ); ?>

			<?php if ( 'post' == get_post_type() ) { ?>
				<div class="entry-meta">
					<?php chriswiegman_posted_on(); ?>
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

		wp_link_pages( array(
			               'before' => '<div class="page-links">' . __( 'Pages:', 'chriswiegman' ),
			               'after'  => '</div>',
		               ) );
		?>
	</div>
	<!-- .entry-content -->

</article><!-- #post-## -->