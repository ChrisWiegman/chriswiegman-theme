<?php
/**
 * ChrisWiegman Core functions and definitions.
 *
 * @since   5.0.0
 *
 * @package CW\Theme\Functions\Core
 *
 * @author  Chris Wiegman <chris@chriswiegman.com>
 */

namespace CW\Theme\Functions\Core;

/**
 * Action after_theme_setup
 *
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * @since 5.0.0
 *
 * @return void
 */
function action_after_setup_theme() {

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	// Enable support for Post Thumbnails on posts and pages.
	add_theme_support( 'post-thumbnails' );

	// Enable post formats.
	add_theme_support( 'post-formats', array( 'image', 'quote' ) );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus(
		array(
			'primary' => __( 'Primary Menu', 'chriswiegman' ),
			'footer'  => __( 'Footer Menu', 'chriswiegman' ),
		)
	);

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		)
	);

	load_theme_textdomain( 'chriswiegman', CW_THEME_PATH . '/languages' );

}

/**
 * Action init
 *
 * Add custom styles to wysiwyg editor
 *
 * @since 5.0.0
 *
 * @return void
 */
function action_init() {

	$min = ( defined( 'SCRIPT_DEBUG' ) && true === SCRIPT_DEBUG ) ? '' : '.min';

	add_editor_style( get_stylesheet_directory_uri() . '/assets/css/editor' . $min . '.css' );

}

/**
 * Action widgets_init
 *
 * Register widget area.
 *
 * @since 5.0.0
 *
 * @return void
 */
function action_widgets_init() {

	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'chriswiegman' ),
			'id'            => 'sidebar',
			'description'   => esc_html__( 'The primary sidebar on the right side of most content.', 'chriswiegman' ),
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);

	register_sidebar(
		array(
			'name'          => esc_html__( 'Intro', 'chriswiegman' ),
			'id'            => 'intro',
			'description'   => esc_html__( 'The intro area at the top of most pages.', 'chriswiegman' ),
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);

}

/**
 * Action wp
 *
 * Sets the authordata global when viewing an author archive.
 *
 * This provides backwards compatibility with
 * http://core.trac.wordpress.org/changeset/25574
 *
 * It removes the need to call the_post() and rewind_posts() in an author
 * template to print information about the author.
 *
 * @since 5.0.0
 *
 * @global \WP_Query $wp_query WordPress Query object.
 *
 * @return void
 */
function action_wp() {

	global $wp_query;

	if ( $wp_query->is_author() && isset( $wp_query->post ) ) {
		$GLOBALS['authordata'] = get_userdata( $wp_query->post->post_author );
	}
}

/**
 * Action wp_enqueue_scripts
 *
 * Enqueue scripts and styles.
 *
 * @since 5.0.0
 *
 * @return void
 */
function action_wp_enqueue_scripts() {

	$min = ( defined( 'SCRIPT_DEBUG' ) && true === SCRIPT_DEBUG ) ? '' : '.min';

	wp_enqueue_style( 'google-fonts', 'https://fonts.googleapis.com/css?family=Arvo:700|Gudea:400,400italic,700', array(), CW_THEME_VERSION );

	wp_enqueue_style( 'chriswiegman-style', get_template_directory_uri() . '/assets/css/master' . $min . '.css', array(), CW_THEME_VERSION );

	wp_enqueue_script( 'chriswiegman-footer', get_template_directory_uri() . '/assets/js/footer' . $min . '.js', array( 'jquery' ), CW_THEME_VERSION, false );

	$vars = array(
		'small'  => wp_get_attachment_image_src( get_post_thumbnail_id(), array( 150, 150 ) ),
		'medium' => wp_get_attachment_image_src( get_post_thumbnail_id(), array( 250, 250 ) ),
		'large'  => wp_get_attachment_image_src( get_post_thumbnail_id(), array( 350, 350 ) ),
		'full'   => wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'full' ),
	);

	wp_localize_script(
		'chriswiegman-footer',
		'chriswiegman_featured_image',
		$vars
	);

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

}

/**
 * Action wp_head
 *
 * Clean up the header
 *
 * @since 5.0.0
 *
 * @return void
 */
function action_wp_head() {

	printf(
		'<link rel="alternate" type="%s" title="%s" href="%s" />%s',
		esc_attr( feed_content_type() ),
		get_the_title() . ' | ' . esc_attr__( 'All Posts', 'chriswiegman' ),
		'http://feeds.chriswiegman.com/',
		esc_attr( PHP_EOL )
	);

	printf(
		'<link rel="alternate" type="%s" title="%s" href="%s" />%s',
		esc_attr( feed_content_type() ),
		get_the_title() . ' | ' . esc_attr__( 'All Comments', 'chriswiegman' ),
		'http://feeds.chriswiegman.com/comments',
		esc_attr( PHP_EOL )
	);

}

/**
 *Filter body_classees
 *
 * Adds custom classes to the array of body classes.
 *
 * @since 5.0.0
 *
 * @param array $classes Classes for the body element.
 *
 * @return array
 */
function filter_body_class( $classes ) {

	// Adds a class of group-blog to blogs with more than 1 published author.
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	return $classes;

}

/**
 * Filter excerpt_more
 *
 * Create the correct more link
 *
 * @since 5.0.0
 *
 * @return string The return more text
 */
function filter_excerpt_more() {

	return '... <a class="more-link" href="' . esc_url( get_permalink( get_the_ID() ) ) . '">' . sprintf( esc_html__( 'Continue Reading %s', 'chriswiegman' ), '<span class="meta-nav">&rarr;</span>' ) . '</a>';

}

/**
 * Filter wp_default_scripts
 *
 * Removes an extra jQuery Script
 *
 * @since 5.0.0
 *
 * @param \WP_Scripts $scripts The Default WordPress scripts.
 *
 * @return void
 */
function filter_wp_default_scripts( $scripts ) {

	if ( ! is_admin() ) {

		$scripts->remove( 'jquery' );
		$scripts->add( 'jquery', false, array( 'jquery-core' ), '1.12.3' );

	}

}

/**
 * Filter wp_nav_menu_items
 *
 * Add social sharing to main menu.
 *
 * @since 5.1.0
 *
 * @param string $items The HTML list content for the menu items.
 * @param object $args  An object containing wp_nav_menu() arguments.
 *
 * @return string Filtered HTML list of menu items
 */
function filter_wp_nav_menu_items( $items, $args ) {

	if ( 'primary' === $args->theme_location ) {

		$items .= '<li class="social-share last"><a href="https://github.com/ChrisWiegman" target="_blank" title="' . esc_attr( 'View My Code on Github', 'chriswiegman' ) . '"><span class="fa fa-github fa-2x"></span></a></li>';
		$items .= '<li class="social-share"><a href="https://profiles.wordpress.org/chriswiegman/" target="_blank" title="' . esc_attr( 'View My Plugins on WordPress.org', 'chriswiegman' ) . '"><span class="fa fa-wordpress fa-2x"></span></a></li>';
		$items .= '<li class="social-share"><a href="https://twitter.com/ChrisWiegman" target="_blank" title="' . esc_attr( 'Follow Me on Twitter', 'chriswiegman' ) . '"><span class="fa fa-twitter fa-2x"></span></a></li>';
		$items .= '<li class="social-share"><a href="https://facebook.com/chris.wiegman" target="_blank" title="' . esc_attr( 'Friend Me on Facebook', 'chriswiegman' ) . '"><span class="fa fa-facebook fa-2x"></span></a></li>';
		$items .= '<li class="social-share first"><a href="http://feeds.chriswiegman.com/" target="_blank" title="' . esc_attr( 'Subscribe via RSS', 'chriswiegman' ) . '"><span class="fa fa-rss fa-2x"></span></a></li>';

	}

	return $items;

}

/**
 * Filter wp_page_menu_args
 *
 * Show home item on menu.
 *
 * @since 5.0.0
 *
 * @param array $args Array of menu arguments.
 *
 * @return array Filtered array of menu arguments
 */
function filter_wp_page_menu_args( $args ) {

	$args['show_home'] = true;

	return $args;

}

/**
 * Filter wp_title
 *
 * Filters wp_title to print a neat <title> tag based on what is being viewed.
 *
 * @since 5.0.0
 *
 * @param string $title Default title text for current view.
 * @param string $sep   Optional separator.
 *
 * @return string The filtered title.
 */
function filter_wp_title( $title, $sep ) {

	if ( is_feed() ) {
		return $title;
	}

	global $page, $paged;

	// Add the blog name.
	$title .= get_bloginfo( 'name', 'display' );

	// Add the blog description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) ) {
		$title .= " $sep $site_description";
	}

	// Add a page number if necessary.
	if ( ( $paged >= 2 || $page >= 2 ) && ! is_404() ) {
		$title .= " $sep " . sprintf( __( 'Page %s', 'chriswiegman' ), max( $paged, $page ) );
	}

	return $title;

}

/**
 * Makes WP Theme available for translation.
 *
 * Translations can be added to the /lang directory.
 * If you're building a theme based on WP Theme, use a find and replace
 * to change 'wptheme' to the name of your theme in all template files.
 *
 * @uses  load_theme_textdomain() For translation/localization support.
 *
 * @since 0.1.0
 *
 * @return void
 */
function i18n() {

}

/**
 * Setup theme hooks.
 *
 * @since 5.0.0
 *
 * @return void
 */
function init() {

	$n = function ( $function ) {

		return __NAMESPACE__ . "\\$function";

	};

	remove_action( 'wp_head', 'feed_links', 2 );
	remove_action( 'wp_head', 'feed_links_extra', 3 );
	remove_action( 'wp_head', 'rsd_link' );
	remove_action( 'wp_head', 'wlwmanifest_link' );
	remove_action( 'wp_head', 'wp_generator' );

	add_action( 'after_setup_theme', $n( 'i18n' ) );
	add_action( 'after_setup_theme', $n ( 'action_after_setup_theme' ) );
	add_filter( 'excerpt_more', $n ( 'filter_excerpt_more' ) );
	add_action( 'init', $n ( 'action_init' ) );
	add_action( 'widgets_init', $n ( 'action_widgets_init' ) );
	add_action( 'wp', $n ( 'action_wp' ) );
	add_action( 'wp_enqueue_scripts', $n ( 'action_wp_enqueue_scripts' ) );
	add_action( 'wp_head', $n ( 'action_wp_head' ) );

	add_filter( 'body_class', $n ( 'filter_body_class' ) );
	add_filter( 'wp_default_scripts', $n ( 'filter_wp_default_scripts' ) );
	add_filter( 'wp_nav_menu_items', $n( 'filter_wp_nav_menu_items' ), 10, 2 );
	add_filter( 'wp_page_menu_args', $n ( 'filter_wp_page_menu_args' ) );
	add_filter( 'wp_title', $n ( 'filter_wp_title' ), 10, 2 );

}
