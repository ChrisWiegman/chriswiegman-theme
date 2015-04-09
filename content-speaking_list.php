<li id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php

	$title                 = get_the_title();
	$permalink             = esc_url( get_permalink() );
	$icon_raw              = get_post_meta( get_the_ID(), '_presentation_icon', true );
	$icon                  = empty( $icon_raw ) ? 'comment' : esc_attr( $icon_raw );
	$conference_name       = get_post_meta( get_the_ID(), '_conference_name', true );
	$slide_url             = get_post_meta( get_the_ID(), '_slide_url', true );
	$conference_url        = get_post_meta( get_the_ID(), '_conference_url', true );
	$raw_presentation_date = get_post_meta( get_the_ID(), '_presentation_date', true );
	$conference_location   = get_post_meta( get_the_ID(), '_conference_location', true );
	$presentation_date     = empty( $raw_presentation_date ) ? '' : date( 'F Y', $raw_presentation_date );

	?>

	<span class="fa fa-<?php echo $icon; ?> fa-3x fa-fw fa-li"></span>

	<div class="entry-header">

		<?php
		if ( empty ( $slide_url ) ) {

			printf( '<h2 class="entry-title">%s</h2>', $title );

		} else {

			printf( '<h2 class="entry-title"><a href="%s" title="%s" rel="bookmark">%s</a></h2>', esc_url( $slide_url ), esc_attr( 'View slides from: ' . $title ), sanitize_text_field( $title ) );

		}
		?>

		<div class="entry-meta">

			<?php

			if ( ! empty( $conference_name ) ) {

				echo '<span class="speaking-conference" >';

				if ( empty( $conference_url ) ) {

					echo sanitize_text_field( $conference_name );

				} else {

					printf( '<a href="%s" title="%s" target="_blank">%s</a>', esc_url( $conference_url ), esc_attr( $conference_name ), sanitize_text_field( $conference_name ) );

				}

				echo '</span >';

			}

			if ( ! empty( $presentation_date ) ) {

				echo ' - <span class="speaking-date" >';

				echo sanitize_text_field( $presentation_date );

				echo '</span >';
			}

			if ( ! empty( $conference_location ) ) {

				echo ' - <span class="speaking-location" >';

				echo sanitize_text_field( $conference_location );

				echo '</span >';
			}

			?>

		</div>
		<!-- .entry-meta -->

	</div>
	<!-- .entry-header -->

</li><!-- #post-## -->
<div class="divider"></div>