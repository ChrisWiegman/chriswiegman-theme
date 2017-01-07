<?php
/**
 * The template used for displaying the speaking gig list
 *
 * @since   5.0.0
 *
 * @package CW\Theme\Templates\Parts\Content\Speaking_List
 *
 * @author  Chris Wiegman <chris@chriswiegman.com>
 */

namespace CW\Theme\Templates\Parts\Content\Speaking_List;

?>

<li id="post-<?php esc_attr( the_ID() ); ?>" <?php post_class(); ?>>

	<?php

	$title                 = get_the_title();
	$icon_raw              = get_post_meta( get_the_ID(), '_presentation_icon', true );
	$icon                  = empty( $icon_raw ) ? 'comment' : esc_attr( $icon_raw );
	$conference_name       = get_post_meta( get_the_ID(), '_conference_name', true );
	$slide_url             = get_post_meta( get_the_ID(), '_slide_url', true );
	$conference_url        = get_post_meta( get_the_ID(), '_conference_url', true );
	$raw_presentation_date = get_post_meta( get_the_ID(), '_presentation_date', true );
	$conference_location   = get_post_meta( get_the_ID(), '_conference_location', true );
	$presentation_date     = empty( $raw_presentation_date ) ? '' : date( 'F Y', $raw_presentation_date );

	?>

	<i class="list-icon icon-<?php echo esc_attr( $icon ); ?>"></i>

	<div class="entry-header">

		<?php
		if ( empty( $slide_url ) ) {

			printf( '<h2 class="entry-title">%s</h2>', esc_html( $title ) );

		} else {

			printf( '<h2 class="entry-title"><a href="%s" title="%s" rel="bookmark">%s</a></h2>', esc_url( $slide_url ), esc_attr( 'View slides from: ' . $title ), sanitize_text_field( $title ) );

		}
		?>

		<div class="entry-meta">

			<?php

			if ( ! empty( $conference_name ) ) {

				echo '<span class="speaking-conference" >';

				if ( empty( $conference_url ) ) {

					echo esc_html( $conference_name );

				} else {

					printf( '<a href="%s" title="%s" target="_blank">%s</a>', esc_url( $conference_url ), esc_attr( $conference_name ), esc_html( $conference_name ) );

				}

				echo '</span >';

			}

			if ( ! empty( $presentation_date ) ) {

				echo ' - <span class="speaking-date" >';

				echo esc_html( $presentation_date );

				echo '</span >';
			}

			if ( ! empty( $conference_location ) ) {

				echo ' - <span class="speaking-location" >';

				echo esc_html( $conference_location );

				echo '</span >';
			}

			?>

		</div>
		<!-- .entry-meta -->

	</div>
	<!-- .entry-header -->
	<div class="divider"></div>
</li><!-- #post-## -->
