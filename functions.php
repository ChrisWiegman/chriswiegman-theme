<?php
/**
 * Functions and filters for theme additions.
 *
 * @package chriswiegman-theme
 */

namespace CW\Theme;

// Useful global constants.
use WP_POST;
use WP_Query;

define( 'CW_THEME_VERSION', '12.10.1' );

/**
 * Setup theme hooks.
 *
 * @since 9.0.0
 */
function init() {
	// Add new actions and filters.
	add_action( 'after_setup_theme', 'CW\Theme\action_after_setup_theme' );
	add_action( 'wp_enqueue_scripts', 'CW\Theme\action_wp_enqueue_scripts' );
	add_filter( 'feed_links_show_comments_feed', '__return_false' );
	add_filter( 'wp_resource_hints', 'CW\Theme\filter_wp_resource_hints', 10, 2 );
	add_action( 'admin_menu', 'CW\Theme\action_admin_menu' );
	add_action( 'init', 'CW\Theme\action_init', 100 );
	add_action( 'wp_before_admin_bar_render', 'CW\Theme\action_wp_before_admin_bar_render' );
	add_action( 'send_headers', 'CW\Theme\action_send_headers' );
	add_action( 'pre_get_posts', 'CW\Theme\action_pre_get_posts' );
	add_action( 'admin_init', 'CW\Theme\action_admin_init' );
	add_action( 'save_post', 'CW\Theme\action_save_post', 10, 3 );
	add_filter( 'xmlrpc_enabled', '__return_false' );
	add_filter( 'big_image_size_threshold', '__return_false' );
	add_filter( 'intermediate_image_sizes_advanced', 'CW\Theme\filter_intermediate_image_sizes_advanced', 10, 3 );
	add_filter( 'wpseo_next_rel_link', '__return_false' );
	add_filter( 'wpseo_prev_rel_link', '__return_false' );
	add_filter( 'wpseo_debug_markers', '__return_false' );
	add_action( 'widgets_init', 'CW\Theme\action_widgets_init' );
	add_filter( 'wpseo_json_ld_output', '__return_false' );
	add_filter( 'syntax_highlighting_code_block_styling', '__return_false' );

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
		remove_action( 'wp_head', 'rest_output_link_wp_head' );
		remove_action( 'wp_head', 'wp_shortlink_wp_head' );
		remove_action( 'template_redirect', 'wp_shortlink_header', 11 );
	}

	// Require additional functionality.
	require __DIR__ . '/includes/post_columns/event.php';
	require __DIR__ . '/includes/post_columns/location.php';
	require __DIR__ . '/includes/post_columns/talk.php';
}

/**
 * Action widgets_init
 *
 * Register widget area.
 *
 * @since 12.7.0
 */
function action_widgets_init() {
	register_sidebar(
		array(
			'name'          => 'Intro',
			'id'            => 'intro',
			'description'   => 'The intro area at the top of the home page.',
			'before_widget' => '<div class="container">',
			'after_widget'  => '</div>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}

/**
 * Action save_post
 *
 * Update the index pages when content is saved.
 *
 * @since 12.1.0
 *
 * @param int     $post_ID Post ID.
 * @param WP_POST $post Post object.
 */
function action_save_post( $post_ID, $post ) {
	$post_types = array(
		'post'  => 1226,
		'talk'  => 463,
		'event' => 463,
	);

	if (
		array_key_exists( $post->post_type, $post_types ) &&
		! wp_is_post_revision( $post ) &&
		'publish' === $post->post_status
	) {
		remove_action( 'save_post', __NAMESPACE__ . '\action_save_post' );

		$index_page = array(
			'ID'            => $post_types[ $post->post_type ],
			'post_date'     => current_time( 'mysql' ),
			'post_date_gmt' => current_time( 'mysql', 1 ),
		);

		wp_update_post( $index_page );
	}
}

/**
 * Filter intermediate_image_sizes_advanced.
 *
 * Unset default image sizes.
 *
 * @since 12.0.3
 *
 * @param array $new_sizes Associative array of image sizes to be created.
 *
 * @return array
 */
function filter_intermediate_image_sizes_advanced( $new_sizes ) {
	unset( $new_sizes['thumbnail'] );
	unset( $new_sizes['medium_large'] );

	return $new_sizes;
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
 * @param WP_Query $query The query we're trying to edit.
 *
 * @since 11.0.0
 */
function action_pre_get_posts( $query ) {
	global $wp_the_query;

	if ( ! is_home() && ! is_admin() && $query === $wp_the_query ) {
		$query->set( 'posts_per_page', - 1 );
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
}

/**
 * Filter wp_resource hints
 *
 * Remove extra DNS pre-fetch links.
 *
 * @param array  $urls URLs to print for resource hints.
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
	add_theme_support( 'html5', array( 'search-form' ) );

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

	remove_image_size( '1536x1536' );
	remove_image_size( '2048x2048' );
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
	wp_dequeue_style( 'global-styles' );
	wp_dequeue_style( 'classic-theme-styles' );
	wp_enqueue_style( 'cw-theme-style', get_template_directory_uri() . '/assets/main' . $min . '.css', array(), $version );
}

init();
