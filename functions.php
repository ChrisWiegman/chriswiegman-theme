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

// Useful global constants.
define( 'CW_THEME_VERSION', '5.0.1' );
define( 'CW_THEME_PATH', get_template_directory() . '/' );
define( 'CW_THEME_INCLUDES', CW_THEME_PATH . 'includes/' );

require( CW_THEME_INCLUDES . 'functions/core.php' );
require( CW_THEME_INCLUDES . 'functions/template-tags.php' );

CW\Theme\Functions\Core\init();
