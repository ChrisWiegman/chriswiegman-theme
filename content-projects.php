<?php
/**
 * @package ChrisWiegman
 */
?>
<!-- begin .archive-projects-->
<div class="archive-projects">

	<?php
	$args = array( 'post_type' => 'project' );
	$loop = new WP_Query( $args );
	?>

	<?php
	while ( $loop->have_posts() ) {

		$loop->the_post();

		?>
		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

			<?php

			$title     = get_the_title();
			$permalink = esc_url( get_permalink() );
			$types     = get_the_terms( get_the_ID(), 'project_type' );
			$statuses  = get_the_terms( get_the_ID(), 'project_status' );

			?>

			<header class="entry-header">

				<?php printf( '<h2 class="entry-title"><a href="%s" title="%s" rel="bookmark">%s</a></h2>', $permalink, $title, $title ); ?>

				<div class="entry-meta">
					<span class="project-types">
						<?php _e( 'Type: ', 'ChrisWiegman' ); ?>
						<?php foreach ( $types as $type ) { ?>
							<span class="project-type"><a class="url fn n" href=""><?php echo $type->name; ?></a></span>
						<?php } ?>
					</span>
					<span class="project-statuses">
						<?php _e( 'Status: ', 'ChrisWiegman' ); ?>
						<?php foreach ( $statuses as $status ) { ?>
							<span class="project-status"><a class="url fn n" href=""><?php echo $status->name; ?></a></span>
						<?php } ?>
					</span>
				</div>
				<!-- .entry-meta -->

			</header>
			<!-- .entry-header -->

			<div class="entry-content">
				<?php the_excerpt(); ?>
			<!-- .entry-content -->

		</article><!-- #post-## -->

	<?php } ?>


</div>
<!-- end .archive-projects-->

