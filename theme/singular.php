<?php
/**
 * Templates for individual posts and pages.
 *
 * @package chriswiegman-theme
 */

get_header();
?>

<article class='h-entry' itemscope='' itemtype='http://schema.org/BlogPosting'>
	<div class='content-header'>
		<?php
				the_title( '<h1 class="title post-title p-name" itemprop="name headline">', '</h1>' );

		if ( 'post' === get_post_type() ) {
			printf( '<div class="meta"><a class="u-url" href="%s"><time class="dt-published">%s</time></a></div>', esc_url( get_the_permalink() ), get_the_date( 'l, F jS, Y' ) );
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

<?php if ( 'post' === get_post_type() ) { ?>
<div class="navigation prevnext">
	<span class="prev"><?php previous_post_link( '&larr; %link', '%title', false ); ?></span>
	<span class="next"><?php next_post_link( '%link &rarr;', '%title', false ); ?></span>
</div>
<?php } ?>

<?php
get_footer();
