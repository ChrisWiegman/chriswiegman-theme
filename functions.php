<?php
/**
 * ChrisWiegman functions and definitions.
 *
 * @since   5.0.0
 *
 * @package CW\Theme
 *
 * @author  Chris Wiegman <chris@chriswiegman.com>
 */

use CW\Theme\Post_Types;

add_filter( 'stylesheet_directory_uri', 'filter_stylesheet_directory_uri' );

/**
 * Filter stylesheet_directory_uri
 *
 * Make sure we're using the right folder with Varnish
 *
 * @since 5.4.2
 *
 * @param string $stylesheet_dir_uri Stylesheet directory URI.
 *
 * @return string Filtered URI.
 */
function filter_stylesheet_directory_uri( $stylesheet_dir_uri ) {

	if ( defined( 'WP_LOCAL_DEV' ) && true === WP_LOCAL_DEV ) {
		return str_replace( 'http:', 'https:', $stylesheet_dir_uri );
	}

	return $stylesheet_dir_uri;

}

// Useful global constants.
define( 'CW_THEME_VERSION', '5.4.2' );
define( 'CW_THEME_PATH', get_template_directory() . '/' );
define( 'CW_THEME_URL', get_stylesheet_directory_uri() );
define( 'CW_THEME_INCLUDES', CW_THEME_PATH . 'includes/' );

require( CW_THEME_INCLUDES . 'functions/core.php' );
require( CW_THEME_INCLUDES . 'functions/template-tags.php' );
require( CW_THEME_INCLUDES . 'classes/widgets/class-ad.php' );
require( CW_THEME_INCLUDES . 'classes/widgets/class-donate.php' );
require( CW_THEME_INCLUDES . 'classes/widgets/class-latest-tweets.php' );
require( CW_THEME_INCLUDES . 'classes/post-types/class-project.php' );
require( CW_THEME_INCLUDES . 'classes/post-types/class-speaking.php' );
require( CW_THEME_INCLUDES . 'classes/post-types/class-journal.php' );

// Instantiate required classes.
new Post_Types\Project();
new Post_Types\Speaking();
new Post_Types\Journal();

CW\Theme\Functions\Core\init();
