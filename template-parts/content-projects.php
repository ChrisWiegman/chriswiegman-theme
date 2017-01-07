<?php
/**
 * The template used for displaying page content from projects
 *
 * @since   5.0.0
 *
 * @package CW\Theme\Templates\Parts\Content\Projects
 *
 * @author  Chris Wiegman <chris@chriswiegman.com>
 */

namespace CW\Theme\Templates\Parts\Content\Projects;
?>
<!-- begin .archive-projects-->
<ul class="archive-projects cpt-list">

	<?php
	$args = array( 'post_type' => 'project' );
	$loop = new \WP_Query( $args );
	?>

	<?php
	while ( $loop->have_posts() ) {

		$loop->the_post();

		get_template_part( 'template-parts/content', 'project_list' );

	}
	wp_reset_postdata();
	?>

</ul>
<!-- end .archive-projects-->

