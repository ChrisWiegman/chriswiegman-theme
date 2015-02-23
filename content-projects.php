<?php
/**
 * @package ChrisWiegman
 */
?>
<!-- begin .archive-projects-->
<div class="archive-projects">

	<?php
	$args = array( 'post_type' => 'project' );
	$loop = new WP_Query( $args );
	?>

	<?php
	while ( $loop->have_posts() ) {

		$loop->the_post();

		get_template_part( 'content', 'project_list' );

	} ?>


</div>
<!-- end .archive-projects-->

