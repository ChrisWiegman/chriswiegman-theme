<?php
/**
 * @package ChrisWiegman
 */
?>
<!-- begin .archive-projects-->
<ul class="archive-projects fa-ul">

	<?php
	$args = array( 'post_type' => 'project' );
	$loop = new WP_Query( $args );
	?>

	<?php
	while ( $loop->have_posts() ) {

		$loop->the_post();

		get_template_part( 'content', 'project_list' );

	} ?>


</ul>
<!-- end .archive-projects-->

