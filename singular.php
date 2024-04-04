<?php
/**
 * Templates for individual posts and pages.
 *
 * @package chriswiegman-theme
 */

add_filter( 'syntax_highlighting_code_block_styling', '__return_true' );
get_header();
?>
<main>
	<article class='h-entry' itemscope='' itemtype='http://schema.org/BlogPosting'>
		<div class="container">
			<div class='content-header'>
				<?php
				if ( 'post' === get_post_type() ) {
					printf( '<div class="meta"><time class="dt-published">%s</time></div>', get_the_date( 'l, F jS, Y' ) );
				}
				?>
				<?php the_title( '<h1 class="title post-title p-name" itemprop="name headline">', '</h1>' ); ?>
				<?php
				$cw_theme_tags = get_the_tags( get_the_ID() );
				if ( $cw_theme_tags ) {
					?>
					<div class="tags">
					<?php
					foreach ( $cw_theme_tags as $cw_theme_tag ) {
						?>
						<a href="<?php echo esc_url( get_tag_link( $cw_theme_tag->term_id ) ); ?>" title="<?php echo esc_attr( $cw_theme_tag->name ); ?>"><?php echo esc_html( $cw_theme_tag->name ); ?></a>
					<?php } ?>
					</div>
				<?php } ?>
			</div>

			<div class="content e-content" itemprop="articleBody">

				<?php
				if ( has_post_thumbnail() ) {
					the_post_thumbnail( 'large', array( 'class' => 'wp-block-image aligncenter' ) );
				}

				the_content();
				?>

			</div>
		</div>
	</article>

	<?php if ( 'post' === get_post_type() ) { ?>
	<div class="navigation prevnext">
		<span class="prev"><?php previous_post_link( '&larr; %link', '%title', false ); ?></span>
		<span class="next"><?php next_post_link( '%link &rarr;', '%title', false ); ?></span>
	</div>
	<?php } ?>
</main>
<?php
get_footer();
