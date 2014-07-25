<?php
/**
 * @package ChrisWiegman
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>

		<div class="entry-meta">
			<?php chriswiegman_posted_on(); ?>
		</div>
		<!-- .entry-meta -->
	</header>
	<!-- .entry-header -->

	<div class="entry-content">

		<?php the_content(); ?>

		<?php
		$terms = get_terms( 'software_type' );

		echo '<p>I write a lot of code and, when I can, I try to share it in hopes someone might find it useful. Here are some of my active (or at least recent) projects. Take a look at <a href="https://github.com/ChrisWiegman" title="Chris Wiegman on GitHub" target="_blank">my GitHub profile</a> for even more.</p>';

		if ( count( $terms ) > 0 ) {

			foreach ( $terms as $term ) {

				echo '<h2 class="software-category">' . $term->name . '</h2>';

				$args = array(
					'post_type'      => 'software',
					'orderby'        => 'title',
					'order'          => 'ASC',
					'posts_per_page' => '12',
					'tax_query'      => array(
						array(
							'taxonomy' => 'software_type',
							'field'    => 'slug',
							'terms'    => $term->slug,
						)
					)
				);

				$loop = new WP_Query( $args );

				if ( $loop->have_posts() ) {

					while ( $loop->have_posts() ) {

						$loop->the_post();

						global $post, $cw_lib;

						$meta = $cw_lib->get_plugin_data( $post->ID );

						echo '<div class="software-short">';
						echo '<h3 class="software-title"><a href="' . get_post_meta( $post->ID, '_software_url', true ) . '" target="_blank">' . get_the_title() . '</a></h3>';

						if ( $meta != false ) {
							echo '<div class="software-rating" itemprop="aggregateRating" itemscope itemtype="http://schema.org/AggregateRating"> ';
							echo '<div class="rating-stars">';
							echo '<div class="rating" style="width: ' . ( $meta['Rating'] / 5 ) * 100 . '%;">';
							echo '<meta itemprop="ratingValue" content="' . $meta['Rating'] . '">';
							echo '<meta itemprop="reviewCount" content="' . $meta['Votes'] . '">';
							echo '</div>';
							echo '</div>';
							echo '<div class="software-downloads">' . number_format( substr( $meta['Downloads'], 14 ) ) . ' downloads</div>';
							echo '</div>';
						}

						echo '</div>';

					}

				}

			}

		}
		?>

		<?php
		wp_link_pages( array(
			               'before' => '<div class="page-links">' . __( 'Pages:', 'chriswiegman' ),
			               'after'  => '</div>',
		               ) );
		?>

	</div>
	<!-- .entry-content -->

	<footer class="entry-footer">
		<?php
		/* translators: used between list items, there is a space after the comma */
		$category_list = get_the_category_list( __( ', ', 'chriswiegman' ) );

		/* translators: used between list items, there is a space after the comma */
		$tag_list = get_the_tag_list( '', __( ', ', 'chriswiegman' ) );

		if ( ! chriswiegman_categorized_blog() ) {
			// This blog only has 1 category so we just need to worry about tags in the meta text
			if ( '' != $tag_list ) {
				$meta_text = __( 'This entry was tagged %2$s. Bookmark the <a href="%3$s" rel="bookmark">permalink</a>.', 'chriswiegman' );
			} else {
				$meta_text = __( 'Bookmark the <a href="%3$s" rel="bookmark">permalink</a>.', 'chriswiegman' );
			}

		} else {
			// But this blog has loads of categories so we should probably display them here
			if ( '' != $tag_list ) {
				$meta_text = __( 'This entry was posted in %1$s and tagged %2$s. Bookmark the <a href="%3$s" rel="bookmark">permalink</a>.', 'chriswiegman' );
			} else {
				$meta_text = __( 'This entry was posted in %1$s. Bookmark the <a href="%3$s" rel="bookmark">permalink</a>.', 'chriswiegman' );
			}

		} // end check for categories on this blog

		printf(
			$meta_text,
			$category_list,
			$tag_list,
			get_permalink()
		);
		?>

		<?php edit_post_link( __( 'Edit', 'chriswiegman' ), '<span class="edit-link">', '</span>' ); ?>
	</footer>
	<!-- .entry-footer -->
</article><!-- #post-## -->
