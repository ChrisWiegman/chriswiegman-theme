<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package chriswiegman-theme
 */

 // Useful global constants.
define( 'CW_THEME_VERSION', '9.0.0' );

/**
 * Action after_theme_setup
 *
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * @since 5.0.0
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

add_action( 'after_setup_theme', 'action_after_setup_theme' );

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

add_action( 'widgets_init', 'action_widgets_init' );

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
	wp_enqueue_style( 'chriswiegman-style', get_template_directory_uri() . '/assets/main' . $min . '.css', array(), CW_THEME_VERSION );

}

add_action( 'wp_enqueue_scripts', 'action_wp_enqueue_scripts' );

// Cleanup extra garbage.
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'wp_print_styles', 'print_emoji_styles' );
