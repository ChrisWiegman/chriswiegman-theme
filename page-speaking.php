<?php
/**
 * Template for my speaking page.
 *
 * @package chriswiegman-theme
 */

get_header();
?>
<main>
	<article class='h-entry page-index' itemscope='' itemtype='http://schema.org/BlogPosting'>
		<div class="container">
			<div class="content-header">
				<?php the_title( '<h1 class="title post-title p-name" itemprop="name headline">', '</h1>' ); ?>
			</div>
			<div class="content e-content" itemprop="articleBody">

				<?php
				if ( has_post_thumbnail() ) {
					the_post_thumbnail( 'featured' );
				}

					the_content();
				?>

				<h2 id="conferences">Conferences</h2>
				<?php
				$cw_theme_event_params = array(
					'orderby' => 'event_date DESC',
					'where'   => 'event_type = "Conference"',
					'limit'   => -1,
				);
				$cw_theme_events       = pods( 'event' )->find( $cw_theme_event_params );

				if ( 0 < $cw_theme_events->total() ) {

					echo '<!-- Group by year. -->';

					$cw_theme_current_year = false;

					/* Start the Loop */
					while ( $cw_theme_events->fetch() ) {

						if ( ! empty( $cw_theme_events->field( 'talks' ) ) ) {

							$cw_theme_post_year = gmdate( 'Y', strtotime( $cw_theme_events->field( 'event_date' ) ) );

							if ( $cw_theme_post_year !== $cw_theme_current_year ) {

								if ( false !== $cw_theme_current_year ) {
									echo '</ul>';
								}

								printf( '<h3>%s</h3>', intval( $cw_theme_post_year ) );
								echo '<ul>';

							}

							$cw_theme_current_year = $cw_theme_post_year;
							$cw_theme_keynote      = '';
							$cw_theme_talks        = $cw_theme_events->field( 'talks' );
							foreach ( $cw_theme_talks as $cw_theme_talk ) {
								if ( isset( $cw_theme_talk['keynote'] ) && '1' === $cw_theme_talk['keynote'] ) {
									$cw_theme_keynote = ' (keynote presentation)';
								}
							}
							?>
							<?php if ( strlen( trim( $cw_theme_events->display( 'event_link' ) ) ) > 0 ) { ?>
								<li><a href="<?php echo esc_url( $cw_theme_events->display( 'event_link' ) ); ?>"><?php echo esc_html( $cw_theme_events->display( 'post_title' ) ); ?></a><?php echo esc_html( $cw_theme_keynote ); ?></li>
							<?php } else { ?>
								<li><?php echo esc_html( $cw_theme_events->display( 'post_title' ) ); ?><?php echo esc_html( $cw_theme_keynote ); ?></li>
								<?php
							}
						}
					}
				}
				?>
				</ul>

				<h2 id="meetups">Meetups</h2>
				<p>Of course, conferences aren’t all there is. I’ve also been fortunate to work with local WordPress and other groups in my hometown and beyond. Here are some of the Meetup groups I’ve been honored to speak to over the years.</p>
				<ul>
					<?php
					$cw_theme_meetup_params = array(
						'orderby' => 'event_date DESC',
						'where'   => 'event_type = "Meetup"',
					);
					$cw_theme_meetups       = pods( 'event' )->find( $cw_theme_meetup_params );

					if ( 0 < $cw_theme_meetups->total() ) {

						/* Start the Loop */
						while ( $cw_theme_meetups->fetch() ) {
							?>
							<li><a href="<?php echo esc_url( $cw_theme_meetups->display( 'event_link' ) ); ?>"><?php echo esc_html( $cw_theme_meetups->display( 'post_title' ) ); ?></a></li>
							<?php
						}
					}
					?>
				</ul>

				<h2 id="full-talks">Full Talks Available Online</h2>
				<p>Some of my talks are available online. Here’s a list of talks I’ve given with links to the full talk.</p>
				<ul>
					<?php
					$cw_theme_full_talk_params = array(
						'orderby' => 'post_title ASC',
						'where'   => 'video_link <> ""',
					);
					$cw_theme_full_talks       = pods( 'talk' )->find( $cw_theme_full_talk_params );

					if ( 0 < $cw_theme_full_talks->total() ) {

						/* Start the Loop */
						while ( $cw_theme_full_talks->fetch() ) {
							$cw_theme_event = $cw_theme_full_talks->field( 'event' );
							?>
							<li><a href="<?php echo esc_url( $cw_theme_full_talks->display( 'video_link' ) ); ?>"><?php echo esc_html( $cw_theme_full_talks->display( 'post_title' ) ); ?></a> - <?php echo esc_html( $cw_theme_event['post_title'] ); ?></li>
							<?php
						}
					}
					?>
				</ul>

				<h2 id="slides">Slides</h2>
				<p>You can find slides from many of my talks at <a href="https://slides.chriswiegman.com/">slides.chriswiegman.com</a>.</p>
			</div>
		</div>
	</article>

</main>
<?php
get_footer();
