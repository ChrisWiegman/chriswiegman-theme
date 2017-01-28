<?php
/**
 * The sidebar containing the main widget area.
 *
 * @since   5.0.0
 *
 * @package CW\Theme\Templates\Siebar
 *
 * @author  Chris Wiegman <chris@chriswiegman.com>
 */

namespace CW\Theme\Templates\Sidebar;

if ( ! is_active_sidebar( 'sidebar' ) ) {
	return;
}
?>

<div id="secondary" class="widget-area" role="complementary">
	<?php dynamic_sidebar( 'sidebar' ); ?>
</div><!-- #secondary -->
