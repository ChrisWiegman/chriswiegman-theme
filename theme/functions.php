<?php
/**
 * Functions and filters for theme additions.
 *
 * @package chriswiegman-theme
 */

namespace CW\Theme;

// Useful global constants.
define( 'CW_THEME_VERSION', '9.7.4' );

/**
 * Setup theme hooks.
 *
 * @since 9.0.0
 */
function init() {

	$n = function ( $function ) {
		return __NAMESPACE__ . "\\$function";
	};

	// Add new actions and filters.
	add_action( 'after_setup_theme', $n( 'action_after_setup_theme' ) );
	add_action( 'widgets_init', $n( 'action_widgets_init' ) );
	add_action( 'wp_enqueue_scripts', $n( 'action_wp_enqueue_scripts' ) );
	add_filter( 'feed_links_show_comments_feed', '__return_false' );
	add_filter( 'wp_resource_hints', $n( 'filter_wp_resource_hints' ), 10, 2 );
	add_action( 'admin_menu', $n( 'action_admin_menu' ) );
	add_action( 'init', $n( 'action_init' ), 100 );
	add_action( 'wp_before_admin_bar_render', $n( 'action_wp_before_admin_bar_render' ) );
	add_filter( 'wp_nav_menu_items', $n( 'filter_wp_nav_menu_items' ), 10, 2 );
	add_action( 'send_headers', $n( 'action_send_headers' ) );
	// Cleanup extra garbage.
	if ( function_exists( 'remove_action' ) ) {

		remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
		remove_action( 'wp_print_styles', 'print_emoji_styles' );
		remove_action( 'wp_head', 'rsd_link' );
		remove_action( 'wp_head', 'wlwmanifest_link' );
		remove_action( 'wp_head', 'wp_generator' );
		remove_action( 'template_redirect', 'rest_output_link_header', 11 );
		remove_action( 'wp_head', 'wp_oembed_add_discovery_links' );
		remove_action( 'wp_head', 'rest_output_link_wp_head' );

	}
}

/**
 * Action send_headers
 *
 * Set the security headers.
 *
 * @since 9.6.2
 */
function action_send_headers() {

	header( 'Strict-Transport-Security: max-age=15768000' );
	header( 'x-content-type-options: nosniff' );
	header( 'x-permitted-cross-domain-policies: none' );
	header( 'x-xss-protection: 1; mode=block' );
	header( 'x-frame-options: SAMEORIGIN' );

}

/**
 * Filter wp_nav_menu_items
 *
 * Adds a search box to the main nav menu
 *
 * @since 9.6.0
 *
 * @param string  $items Output of menu items.
 * @param WP_Term $args Array of menu arguments.
 *
 * @return string Output of menu items.
 */
function filter_wp_nav_menu_items( $items, $args ) {

	if ( 'primary' === $args->theme_location ) {
		$items .= '<li class="menu-item search-form">' . get_search_form( false ) . '</li>';
	}

	return $items;

}

/**
 * Removes comments from the admin bar
 *
 * @since 9.3.3
 */
function action_wp_before_admin_bar_render() {

	global $wp_admin_bar;

	$wp_admin_bar->remove_menu( 'comments' );

}

/**
 * Removes comments from the admin menu
 *
 * @since 9.3.3
 */
function action_admin_menu() {

	remove_menu_page( 'edit-comments.php' );

}

/**
 * Remove support for comments
 *
 * @since 9.3.3
 */
function action_init() {

	remove_post_type_support( 'post', 'comments' );
	remove_post_type_support( 'page', 'comments' );
	add_image_size( 'avatar', 228, 228, true );

}

/**
 * Filter wp_resource hints
 *
 * Remove extra DNS prefecth links.
 *
 * @param array  $urls          URLs to print for resource hints.
 * @param string $relation_type The relation type the URLs are printed for, e.g. 'preconnect' or 'prerender'.
 *
 * @return array
 */
function filter_wp_resource_hints( $urls, $relation_type ) {

	if ( 'dns-prefetch' !== $relation_type ) {
		return $urls;
	}

	unset( $urls[1] );

	return $urls;
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
	add_editor_style( 'assets/editor.css' );

	// Add theme support for the title tag.
	add_theme_support( 'title-tag' );

	// Add theme support for the title tag.
	add_theme_support( 'html5' );

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

	$min     = '.min';
	$version = CW_THEME_VERSION;

	if ( defined( 'SCRIPT_DEBUG' ) && true === SCRIPT_DEBUG ) {

		$min     = '';
		$version = time();

	}

	wp_deregister_script( 'wp-embed' );
	wp_dequeue_style( 'wp-block-library' );
	wp_enqueue_style( 'cw-theme-style', get_template_directory_uri() . '/assets/main' . $min . '.css', array(), $version );

}

init();
