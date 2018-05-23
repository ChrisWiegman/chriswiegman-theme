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
use \CW\Theme\Features;

// Useful global constants.
define( 'CW_THEME_VERSION', '8.0.6' );
define( 'CW_THEME_PATH', get_template_directory() . '/' );
define( 'CW_THEME_URL', get_stylesheet_directory_uri() );
define( 'CW_THEME_INCLUDES', CW_THEME_PATH . 'includes/' );

require CW_THEME_INCLUDES . 'functions/core.php';
require CW_THEME_INCLUDES . 'functions/template-tags.php';
require CW_THEME_INCLUDES . 'classes/widgets/class-latest-tweets.php';

CW\Theme\Functions\Core\init();
