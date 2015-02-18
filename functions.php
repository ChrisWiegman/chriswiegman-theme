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

		//Enable support for Post Thumbnails on posts and pages.
		add_theme_support( 'post-thumbnails' );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array( 'primary' => __( 'Primary Menu', 'chriswiegman' ), ) );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form', 'comment-form', 'comment-list', 'gallery', 'caption'
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
		                  'id'            => 'sidebar',
		                  'description'   => 'The primary sidebar on the right side of most content.',
		                  'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		                  'after_widget'  => '</aside>',
		                  'before_title'  => '<h2 class="widget-title">',
		                  'after_title'   => '</h2>',
	                  ) );

	register_sidebar( array(
		                  'name'          => __( 'Intro', 'chriswiegman' ),
		                  'id'            => 'intro',
		                  'description'   => 'The intro area at the top of most pages.',
		                  'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		                  'after_widget'  => '</aside>',
		                  'before_title'  => '<h2 class="widget-title">',
		                  'after_title'   => '</h2>',
	                  ) );
}

add_action( 'widgets_init', 'chriswiegman_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function chriswiegman_scripts() {

	wp_enqueue_style( 'chriswiegman-style', get_template_directory_uri() . '/lib/css/master.css', array(), '1.2' );

	wp_enqueue_script( 'chriswiegman-footer', get_template_directory_uri() . '/lib/js/footer.min.js', array( 'jquery' ), '1.3', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

}

//Create the correct more link
function chriswiegman_excerpt_more() {

	return '... <a class="more-link" href="' . get_permalink( get_the_ID() ) . '">' . __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'chriswiegman' ) . '</a>';

}

add_filter( 'excerpt_more', 'chriswiegman_excerpt_more' );

add_action( 'wp_enqueue_scripts', 'chriswiegman_scripts' );

//Add custom styles to wysiwyg editor
add_action( 'init', 'chriswiegman_add_editor_styles' );

function chriswiegman_add_editor_styles() {

	add_editor_style( get_stylesheet_directory_uri() . '/css/editor.css' );

}

add_filter( 'wp_default_scripts', 'cw_remove_jquery_migrate' );

function cw_remove_jquery_migrate( $scripts ) {

	if ( ! is_admin() ) {
		$scripts->remove( 'jquery' );
		$scripts->add( 'jquery', false, array( 'jquery-core' ), '1.11.0' );
	}
}

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';