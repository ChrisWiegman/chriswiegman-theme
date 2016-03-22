<?php
/**
 * The template used for displaying speaking gig content
 *
 * @since   5.0.0
 *
 * @package CW\Theme\Templates\Parts\Content\Speaking
 *
 * @author  Chris Wiegman <chris@chriswiegman.com>
 */

namespace CW\Theme\Templates\Parts\Content\Speaking;

?>
<!-- begin .archive-projects-->
<ul class="archive-speaking fa-ul">

	<?php
	$args = array(
		'post_type' => 'speaking',
		'order'     => 'DESC',
		'orderby'   => 'meta_value_num',
		'meta_key'  => '_presentation_date',
		'nopaging'  => true,
	);
	$loop = new \WP_Query( $args );
	?>

	<?php
	while ( $loop->have_posts() ) {

		$loop->the_post();

		get_template_part( 'template-parts/content', 'speaking_list' );

	} ?>

</ul>
<!-- end .archive-projects-->

