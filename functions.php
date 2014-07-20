<?php
/**
 * ChrisWiegman functions and definitions
 *
 * @package ChrisWiegman
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) ) {
	$content_width = 640; /* pixels */
}

if ( ! function_exists( 'chriswiegman_setup' ) ) {

	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function chriswiegman_setup() {

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
		 */
		//add_theme_support( 'post-thumbnails' );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array( 'primary' => __( 'Primary Menu', 'chriswiegman' ), ) );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form', 'comment-form', 'comment-list', 'gallery', 'caption'
		) );

		/*
		 * Enable support for Post Formats.
		 * See http://codex.wordpress.org/Post_Formats
		 */
		add_theme_support( 'post-formats', array(
			'aside', 'image', 'video', 'quote', 'link'
		) );

	}

} // chriswiegman_setup

add_action( 'after_setup_theme', 'chriswiegman_setup' );

/**
 * Register widget area.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_sidebar
 */
function chriswiegman_widgets_init() {

	register_sidebar( array(
		                  'name'          => __( 'Sidebar', 'chriswiegman' ),
		                  'id'            => 'sidebar-1',
		                  'description'   => '',
		                  'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		                  'after_widget'  => '</aside>',
		                  'before_title'  => '<h1 class="widget-title">',
		                  'after_title'   => '</h1>',
	                  ) );
}

add_action( 'widgets_init', 'chriswiegman_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function chriswiegman_scripts() {

	wp_enqueue_style( 'chriswiegman-style', get_template_directory_uri() . '/css/master.css' );

	wp_enqueue_script( 'chriswiegman-footer', get_template_directory_uri() . '/js/footer.min.js', array(), '1.0', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

}

add_action( 'wp_enqueue_scripts', 'chriswiegman_scripts' );

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';