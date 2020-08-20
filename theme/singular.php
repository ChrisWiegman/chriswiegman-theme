<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package chriswiegman-theme
 */

get_header();
?>

<article class = 'h-entry' itemscope = '' itemtype = 'http://schema.org/BlogPosting'>
	<div class = 'content-header'>
		<?php
		the_title( '<h1 class="title post-title p-name" itemprop="name headline">', '</h1>' );

		if ( 'post' === get_post_type() ) {
			printf( '<div class="meta"><a class="u-url" href="%s"><time class="dt-published">%s</time></a></dif>', esc_url( get_the_permalink() ), get_the_date( 'l, F jS, Y' ) );
		}
		?>
	</div>

	<div class="content e-content" itemprop="articleBody">

			<?php
			if ( has_post_thumbnail() ) {
				echo '<p>';
				the_post_thumbnail();
				echo '</p>';
			}

			the_content();
			?>

	</div>

</article>

<?php
get_footer();
