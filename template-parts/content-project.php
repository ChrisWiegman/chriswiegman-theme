<?php
/**
 * The template used for displaying page content from projects
 *
 * @since   5.0.0
 *
 * @package CW\Theme\Templates\Parts\Content\Project
 *
 * @author  Chris Wiegman <chris@chriswiegman.com>
 */

namespace CW\Theme\Templates\Parts\Content\Project;
?>

<article id="project-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php

	$title     = get_the_title();
	$permalink = esc_url( get_permalink() );

	if ( has_post_thumbnail() ) {
		printf( '<div class="featured-image"><a class="post-header-image" href="%s" rel="bookmark" title="%s">%s</a></div>', esc_url( $permalink ), esc_attr( $title ), get_the_post_thumbnail() );
	}

	$types    = get_the_terms( get_the_ID(), 'project-type' );
	$statuses = get_the_terms( get_the_ID(), 'project-status' );

	?>

	<header class="entry-header">
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>

		<div class="entry-meta">
			<span class="project-types">
				<?php esc_html_e( 'Type: ', 'ChrisWiegman' ); ?>
				<?php foreach ( $types as $type ) { ?>
					<span class="project-type"><?php echo esc_html( $type->name ); ?></span>
				<?php } ?>
				</span>
			<span class="project-statuses">
				<?php esc_html_e( 'Status: ', 'ChrisWiegman' ); ?>
				<?php foreach ( $statuses as $status ) { ?>
					<span class="project-status"><?php echo esc_html( $status->name ); ?></span>
				<?php } ?>
			</span>
		</div>
		<!-- .entry-meta -->
	</header>
	<!-- .entry-header -->

	<div class="entry-content">
		<?php the_content(); ?>
		<?php
		$project_url = get_post_meta( get_the_ID(), '_project_url', true );

		if ( $project_url ) {
			?>
			<a href="<?php echo esc_url( $project_url ); ?>" target="_blank"><?php esc_html_e( 'View the project Page', 'chriswiegman' ); ?></a>
			<?php
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
