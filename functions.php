<?php
/**
 * Functions and filters for theme additions.
 *
 * @package chriswiegman-theme
 */

namespace CW\Theme;

// Useful global constants.
define( 'CW_THEME_VERSION', '11.0.1' );

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
	add_action( 'wp_enqueue_scripts', $n( 'action_wp_enqueue_scripts' ) );
	add_filter( 'feed_links_show_comments_feed', '__return_false' );
	add_filter( 'wp_resource_hints', $n( 'filter_wp_resource_hints' ), 10, 2 );
	add_action( 'admin_menu', $n( 'action_admin_menu' ) );
	add_action( 'init', $n( 'action_init' ), 100 );
	add_action( 'wp_before_admin_bar_render', $n( 'action_wp_before_admin_bar_render' ) );
	add_action( 'send_headers', $n( 'action_send_headers' ) );
	add_action( 'pre_get_posts', $n( 'action_pre_get_posts' ) );
	add_action( 'admin_init', $n( 'action_admin_init' ) );
	add_filter( 'xmlrpc_enabled', '__return_false' );
	add_filter( 'rest_enabled', '__return_false' );

	// Close comments on the front-end.
	add_filter( 'comments_open', '__return_false', 20, 2 );
	add_filter( 'pings_open', '__return_false', 20, 2 );

	// Hide existing comments.
	add_filter( 'comments_array', '__return_empty_array', 10, 2 );

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
		remove_action( 'xmlrpc_rsd_apis', 'rest_output_rsd' );
		remove_action( 'wp_head', 'rest_output_link_wp_head', 10, 0 );
		remove_action( 'template_redirect', 'rest_output_link_header', 11, 0 );
		remove_action( 'auth_cookie_malformed', 'rest_cookie_collect_status' );
		remove_action( 'auth_cookie_expired', 'rest_cookie_collect_status' );
		remove_action( 'auth_cookie_bad_username', 'rest_cookie_collect_status' );
		remove_action( 'auth_cookie_bad_hash', 'rest_cookie_collect_status' );
		remove_action( 'auth_cookie_valid', 'rest_cookie_collect_status' );
		remove_filter( 'rest_authentication_errors', 'rest_cookie_check_errors', 100 );
		remove_action( 'init', 'rest_api_init' );
		remove_action( 'rest_api_init', 'rest_api_default_filters', 10, 1 );
		remove_action( 'parse_request', 'rest_api_loaded' );
		remove_action( 'rest_api_init', 'wp_oembed_register_route' );
		remove_filter( 'rest_pre_serve_request', '_oembed_rest_pre_serve_request', 10, 4 );
		remove_action( 'wp_head', 'wp_oembed_add_discovery_links' );
		remove_action( 'wp_head', 'wp_oembed_add_host_js' );

	}
}

/**
 * Action admin_init
 *
 * @since 11.1.0
 */
function action_admin_init() {

	// Redirect any user trying to access comments page.
	global $pagenow;

	if ( 'edit-comments.php' === $pagenow ) {

		wp_safe_redirect( admin_url() );
		exit;

	}

	// Remove comments metabox from dashboard.
	remove_meta_box( 'dashboard_recent_comments', 'dashboard', 'normal' );

}

/**
 * Action pre_get_posts
 *
 * @since 11.0.0
 *
 * @param WP_Query $query The query we're trying to edit.
 */
function action_pre_get_posts( $query ) {

	global $wp_the_query;

	if ( ! is_home() && ! is_admin() && $query === $wp_the_query ) {
		$query->set( 'posts_per_page', -1 );
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

	// Cleanup unneeded Block editor features.
	add_theme_support( 'disable-custom-font-sizes' );
	add_theme_support( 'disable-custom-colors' );
	add_theme_support( 'disable-custom-gradients' );
	remove_theme_support( 'core-block-patterns' );

	// Add a better image size.
	add_image_size( 'featured', 850 );

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
