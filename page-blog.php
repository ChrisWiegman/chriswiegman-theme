<?php
/**
 * Templates for the blog page.
 *
 * @package chriswiegman-theme
 */

get_header();

$cw_theme_args       = array(
	'posts_per_page' => -1,
);
$cw_theme_blog_query = new WP_Query( $cw_theme_args );
?>
<main>
	<article class='h-entry page-index' itemscope='' itemtype='http://schema.org/BlogPosting'>
		<div class="container">
			<div class="content-header">
				<h1 class="title post-title p-name" itemprop="name headline">All Posts</h1>
				<p class="description"><?php printf( '<span class="post-count">%d</span> posts found.', intval( $cw_theme_blog_query->found_posts ) ); ?></p>
			</div>
			<div class="content-search">
				<form action="/" method="get">
					<label for="search">Search all content</label>
					<input type="text" name="s" id="search" placeholder="Search all content" value="<?php the_search_query(); ?>" />
					<input type="submit" alt="Search" value="Search"  />
				</form>
			</div>
			<div class="content-categories">
				<div class="categories">
					Filter Posts: <a href="/blog" class="category">All Posts</a>
					<?php
					$cw_theme_categories = get_categories(
						array(
							'orderby' => 'name',
							'order'   => 'ASC',
						)
					);

					foreach ( $cw_theme_categories as $cw_theme_category ) {
						printf( '<a href="%s" class="category">%s Posts</a>', esc_url( get_category_link( $cw_theme_category->term_id ) ), esc_html( $cw_theme_category->name ) );
					}
					?>
				</div>
			</div>
			<div class="content e-content" itemprop="articleBody">
				<?php
				if ( $cw_theme_blog_query->have_posts() ) {

					echo '<!-- Group by year. -->';

					$cw_theme_current_year = false;

					/* Start the Loop */
					while ( $cw_theme_blog_query->have_posts() ) {
						$cw_theme_blog_query->the_post();

						$cw_theme_post_year = get_the_date( 'Y' );

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
						<a class="post" href="<?php the_permalink(); ?>">
							<?php the_title( '<h3 class="post-title">', '</h3>' ); ?>
							<span class="post-day"><?php the_date( 'M j' ); ?></span>
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
