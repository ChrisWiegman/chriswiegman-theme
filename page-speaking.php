<?php
/**
 * Templates for individual posts and pages.
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
				<p class="description">All the technical and personal posts I've written on this site going back to 2008.</p>
			</div>
			<div class="content-search">
				<form action="/" method="get">
					<label for="search">Search all content</label>
					<input type="text" name="s" id="search" placeholder="Search all content" value="<?php the_search_query(); ?>" />
					<input type="submit" alt="Search" value="Search"  />
				</form>
			</div>
			<div class="content e-content" itemprop="articleBody">
				<?php
				$cw_theme_event_params = array(
					'orderby' => 't.name DESC',
				);
				$cw_theme_events       = pods( 'event' )->find();

				if ( 0 < $cw_theme_events->total() ) {

					echo '<!-- Group by year. -->';

					$cw_theme_current_year = false;

					/* Start the Loop */
					while ( $cw_theme_events->fetch() ) {

						$cw_theme_post_year = $cw_theme_events->field( 'start_date' );

						if ( $cw_theme_post_year !== $cw_theme_current_year ) {

							if ( false !== $cw_theme_current_year ) {
								echo '</div>';
								echo '</div>';
							}

							echo '<div class="posts-group">';
							printf( '<h2 class="main-header">%s</h2>', intval( $cw_theme_post_year ) );
							echo '<div class="posts">';

						}

						$cw_theme_current_year = $cw_theme_post_year;
						?>
						<a class="post" href="<?php echo esc_url( $cw_theme_events->display( 'event_link' ) ); ?>">
							<h3 class="post-title"><?php echo esc_html( $cw_theme_events->display( 'post_title' ) ); ?></h3>
						</a>
						<?php
					}
				}
				?>
			</div>
		</div>
	</article>

</main>
<?php
get_footer();
