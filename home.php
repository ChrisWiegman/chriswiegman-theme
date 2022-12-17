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
		<div class="container">
			<div class="content">
				<div class="intro">
					<h1>Hi, I'm Chris.</h1>
					<p>I'm an <a href="https://wpengine.com/" title="WP Engine">engineering manager</a>, teacher, <a href="/speaking">speaker</a>, aspiring <a href="/blog">writer</a> and pilot currently based in Sarasota, Florida. My work focuses on WordPress, developer experience and humane and sustainable technology.</p>
					<p>Find me on: <a rel="me" href="https://mastodon.chriswiegman.com/@chris">Mastodon</a>, <a rel="me" href="https://pixelfed.chriswiegman.com/chris">Pixelfed</a> and <a rel="me" href="https://github.com/ChrisWiegman">GitHub</a>.</p>
				</div>
				<img src="/wp-content/uploads/2022/04/chris-wiegman.png" alt="Chris Wiegman" />
			</div>
		</div>

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
