<?php
/**
 * Templates for the archive and other pages.
 *
 * @package chriswiegman-theme
 */

get_header();
global $wp_query;
?>
<main>
	<article class='h-entry page-index' itemscope='' itemtype='http://schema.org/BlogPosting'>
		<div class="container">
			<div class="content-header">
				<?php
				if ( is_search() ) {
					printf( '<h1 class="title p-name" itemprop="name headline">Search results for: <span class="term">%s</span></h1>', esc_attr( get_search_query() ) );
				} elseif ( is_archive() ) {
					$cw_theme_archive_prefix = 'Posts tagged: ';
					if ( is_category() ) {
						$cw_theme_archive_prefix = 'Posts in: ';
					}

					printf( '<h1 class="title p-name" itemprop="name headline">%s<span class="term">%s</span></h1>', esc_attr( $cw_theme_archive_prefix ), esc_attr( single_cat_title( '', false ) ) );
				} else {
					the_title( '<h1 class="title post-title p-name" itemprop="name headline">', '</h1>' );
				}
				?>
				<p class="description"><?php printf( '<span class="post-count">%d</span> posts found.', intval( $wp_query->found_posts ) ); ?></p>
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

				if ( have_posts() ) {
					?>
					<div class="posts-group">
						<div class="posts">
							<?php
							/* Start the Loop */
							while ( have_posts() ) {
								the_post();
								?>
							<a class="post" href="<?php the_permalink(); ?>">
								<?php the_title( '<h3 class="post-title">', '</h3>' ); ?>
								<span class="post-day"><?php the_date( 'M j, Y' ); ?></span>
							</a>
							<?php } ?>
						</div>
					</div>
				<?php } ?>
			</div>
		</div>
	</article>
</main>
<?php
get_footer();
