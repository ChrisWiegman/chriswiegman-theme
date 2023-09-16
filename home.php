<?php
/**
 * The main template file
 *
 * @package chriswiegman-theme
 */

get_header();
?>

<main>
	<article class="hero">
		<?php dynamic_sidebar( 'intro' ); ?>
		<div class="container">
			<h2 class="main-header"><span>Recent Posts</span> <a href="/blog">View All</a></h2>
			<?php
			if ( have_posts() ) {

				/* Start the Loop */
				while ( have_posts() ) {
					the_post();
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
	</article>
</main>

<?php
get_footer();
