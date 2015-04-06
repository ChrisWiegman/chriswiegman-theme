<?php
/**
 * @package ChrisWiegman
 */
?>
<!-- begin .archive-projects-->
<ul class="archive-speaking fa-ul">

	<?php
	$args = array(
		'post_type' => 'speaking',
		'order'     => 'DESC',
		'orderby'   => 'meta_value_num',
		'meta_key'  => '_presentation_date',
	);
	$loop = new WP_Query( $args );
	?>

	<?php
	while ( $loop->have_posts() ) {

		$loop->the_post();

		get_template_part( 'content', 'speaking_list' );

	} ?>


</ul>
<!-- end .archive-projects-->

