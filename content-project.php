<?php
/**
 * @package ChrisWiegman
 */
?>

<article id="project-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php

	$title     = get_the_title();
	$permalink = esc_url( get_permalink() );

	if ( has_post_thumbnail() ) {
		printf( '<div class="featured-image"><a class="post-header-image" href="%s" rel="bookmark" title="%s">%s</a></div>', $permalink, $title, get_the_post_thumbnail() );
	}

	$types    = get_the_terms( get_the_ID(), 'project-type' );
	$statuses = get_the_terms( get_the_ID(), 'project-status' );

	?>

	<header class="entry-header">
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>

		<div class="entry-meta">
			<span class="project-types">
				<?php _e( 'Type: ', 'ChrisWiegman' ); ?>
				<?php foreach ( $types as $type ) { ?>
					<span class="project-type"><?php echo $type->name; ?></span>
				<?php } ?>
				</span>
			<span class="project-statuses">
				<?php _e( 'Status: ', 'ChrisWiegman' ); ?>
				<?php foreach ( $statuses as $status ) { ?>
					<span class="project-status"><?php echo $status->name; ?></span>
				<?php } ?>
			</span>
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
