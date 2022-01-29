<?php
/**
 * The main template file
 *
 * @package chriswiegman-theme
 */

get_header();
?>

<main>

	<?php
	if ( is_home() || is_front_page() ) {
		dynamic_sidebar( 'home-intro' );
	}
	?>

	<div class="content home">

	<?php
	if ( have_posts() ) {

		/* Start the Loop */
		while ( have_posts() ) {
			the_post();
			?>
			<a href="<?php esc_url( get_the_permalink() ); ?>">
				<?php the_title( '<span class="post-title">', '</span>' ); ?>
				<span class="post-day"><?php get_the_date( 'M j' ); ?></span>
			</a>

			<?php
		}
	}
	?>
	</div>
</main>

<?php
get_footer();
