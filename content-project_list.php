<li id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php

	$title     = get_the_title();
	$permalink = esc_url( get_permalink() );
	$types     = get_the_terms( get_the_ID(), 'project-type' );
	$statuses  = get_the_terms( get_the_ID(), 'project-status' );
	$icon_meta = get_post_meta( get_the_ID(), '_project_icon', true );

	$icon = empty( $icon_meta ) ? 'laptop' : esc_attr( $icon_meta );

	?>

	<i class="fa fa-<?php echo $icon; ?> fa-3x fa-fw fa-li"></i>

	<span class="entry-header">

		<?php printf( '<h2 class="entry-title"><a href="%s" title="%s" rel="bookmark">%s</a></h2>', $permalink, $title, $title ); ?>

		<div class="entry-meta">
					<span class="project-types">
						<?php _e( 'Type: ', 'ChrisWiegman' ); ?>
						<?php foreach ( $types as $type ) { ?>
							<?php
							$term_link = get_term_link( $type );

							if ( is_wp_error( $term_link ) ) {
								continue;
							}
							?>
							<span class="project-type"><?php echo $type->name; ?></span>
						<?php } ?>
					</span>
					<span class="project-statuses">
						<?php _e( 'Status: ', 'ChrisWiegman' ); ?>
						<?php foreach ( $statuses as $status ) { ?>
							<?php
							$term_link = get_term_link( $status );

							if ( is_wp_error( $term_link ) ) {
								continue;
							}
							?>
							<span class="project-status"><?php echo $status->name; ?></span>
						<?php } ?>
					</span>
		</div>
		<!-- .entry-meta -->

	</span>
	<!-- .entry-header -->

</li><!-- #post-## -->