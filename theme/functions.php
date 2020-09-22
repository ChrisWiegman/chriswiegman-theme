<?php
/**
 * Functions and filters for theme additions.
 *
 * @package chriswiegman-theme
 */

namespace CW\Theme;

// Useful global constants.
define( 'CW_THEME_VERSION', '9.1.0' );

/**
 * Setup theme hooks.
 *
 * @since 9.0.0
 *
 * @return void
 */
function init() {

	$n = function ( $function ) {
		return __NAMESPACE__ . "\\$function";
	};

	// Add new actions and filters.
	add_action( 'after_setup_theme', $n( 'action_after_setup_theme' ) );
	add_action( 'widgets_init', $n( 'action_widgets_init' ) );
	add_action( 'wp_enqueue_scripts', $n( 'action_wp_enqueue_scripts' ) );
	add_filter( 'pre_get_posts', $n( 'filter_pre_get_posts' ) );
	add_filter( 'feed_links_show_comments_feed', __return_false() );

	// Cleanup extra garbage.
	if ( function_exists( 'remove_action' ) ) {
		remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
		remove_action( 'wp_print_styles', 'print_emoji_styles' );
	}

}

/**
 * Action after_theme_setup
 *
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * @since 9.0.0
 */
function action_after_setup_theme() {

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	// Enable support for Post Thumbnails on posts and pages.
	add_theme_support( 'post-thumbnails' );

	// Enable Appropriate styles in the editor.
	add_theme_support( 'editor-styles' );
	add_editor_style( 'assets/main.min.css' );

	// Add theme support for the title tag.
	add_theme_support( 'title-tag' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus(
		array(
			'primary' => 'Primary Menu',
			'footer'  => 'Footer Menu',
		)
	);

}

/**
 * Action widgets_init
 *
 * Register widget area.
 *
 * @since 9.0.0
 */
function action_widgets_init() {

	register_sidebar(
		array(
			'name'          => 'Homepage Intro',
			'id'            => 'home-intro',
			'description'   => 'The intro section for the homepage',
			'before_widget' => '',
			'after_widget'  => '',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);

}


/**
 * Action wp_enqueue_scripts
 *
 * Enqueue scripts and styles.
 *
 * @since 9.0.0
 */
function action_wp_enqueue_scripts() {

	$min = ( defined( 'SCRIPT_DEBUG' ) && true === SCRIPT_DEBUG ) ? '' : '.min';

	wp_deregister_script( 'wp-embed' );
	wp_dequeue_style( 'wp-block-library' );
	wp_enqueue_style( 'cw-theme-style', get_template_directory_uri() . '/assets/main' . $min . '.css', array(), CW_THEME_VERSION );

}

/**
 * Exclude Journal from homepage
 *
 * @since 9.1.0
 *
 * @param WP_Query $query The posts query to filter.
 */
function filter_pre_get_posts( $query ) {

	if ( $query->is_home || $query->is_feed ) {
		$query->set( 'cat', '-106' ); // Remove "Journal" posts.
	}

	return $query;

}

init();
