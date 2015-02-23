<?php
/**
 * @package ChrisWiegman
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php

	$title = get_the_title();
	$permalink = esc_url( get_permalink() );

	if ( has_post_thumbnail() && ! has_post_format( 'image' ) ) {
		printf( '<div class="featured-image"><a class="post-header-image" href="%s" rel="bookmark" title="%s">%s</a></div>', $permalink, $title, get_the_post_thumbnail() );
	}

	?>

	<header class="entry-header">
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>

		<div class="entry-meta">
			<?php chriswiegman_posted_on(); ?>
		</div>
		<!-- .entry-meta -->
	</header>
	<!-- .entry-header -->

	<div class="entry-content">
		<?php the_content(); ?>
		<?php
		wp_link_pages( array(
			               'before' => '<div class="page-links">' . __( 'Pages:', 'chriswiegman' ),
			               'after'  => '</div>',
		               ) );
		?>
	</div>
	<!-- .entry-content -->

</article><!-- #post-## -->
