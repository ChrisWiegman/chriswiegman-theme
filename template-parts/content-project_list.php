<?php
/**
 * The template used for displaying page content from projects
 *
 * @since   5.0.0
 *
 * @package CW\Theme\Templates\Parts\Content\Project_List
 *
 * @author  Chris Wiegman <chris@chriswiegman.com>
 */

namespace CW\Theme\Templates\Parts\Content\Project_List;
?>
<li id="post-<?php esc_attr( the_ID() ); ?>" <?php post_class(); ?>>

	<?php

	$title     = get_the_title();
	$permalink = esc_url( get_permalink() );
	$types     = get_the_terms( get_the_ID(), 'project-type' );
	$statuses  = get_the_terms( get_the_ID(), 'project-status' );

	if ( has_term( 'wordpress-plugin', 'project-type', get_the_ID() ) ) {

		$icon = 'wordpress';

	} elseif ( has_term( 'google-chrome-extension', 'project-type', get_the_ID() ) ) {

		$icon = 'google';

	} else {

		$icon = 'laptop';

	}

	?>

	<span class="fa fa-<?php echo esc_attr( $icon ); ?> fa-3x fa-fw fa-li"></span>

	<div class="entry-header">

		<?php printf( '<h2 class="entry-title"><a href="%s" title="%s" rel="bookmark">%s</a></h2>', esc_url( $permalink ), esc_attr( $title ), sanitize_text_field( $title ) ); ?>

		<div class="entry-meta">
					<span class="project-types">
						<?php esc_html_e( 'Type: ', 'ChrisWiegman' ); ?>
						<?php foreach ( $types as $type ) { ?>
							<?php
							$term_link = get_term_link( $type );

							if ( is_wp_error( $term_link ) ) {
								continue;
							}
							?>
							<span class="project-type"><?php echo esc_html( $type->name ); ?></span>
						<?php } ?>
					</span>
					<span class="project-statuses">
						<?php esc_html_e( 'Status: ', 'ChrisWiegman' ); ?>
						<?php foreach ( $statuses as $status ) { ?>
							<?php
							$term_link = get_term_link( $status );

							if ( is_wp_error( $term_link ) ) {
								continue;
							}
							?>
							<span class="project-status"><?php echo esc_html( $status->name ); ?></span>
						<?php } ?>
					</span>
		</div>
		<!-- .entry-meta -->

	</div>
	<!-- .entry-header -->
	<div class="divider"></div>
</li><!-- #post-## -->
