<?php
/**
 * @package ChrisWiegman
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
	</header><!-- .entry-header -->

	<div class="entry-content">

		<?php the_content(); ?>

		<?php
		$terms = get_terms( 'software_type' );

		if ( count( $terms ) > 0 ) {

			foreach ( $terms as $term ) { //Loop through Software categories

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

				if ( $loop->have_posts() ) { //if the category has items loop through them

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
		<?php edit_post_link( __( 'Edit', 'chriswiegman' ), '<span class="edit-link">', '</span>' ); ?>
	</footer>
	<!-- .entry-footer -->
</article><!-- #post-## -->
