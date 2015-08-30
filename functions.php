<?php
/**
 * ChrisWiegman functions and definitions
 *
 * @package ChrisWiegman
 */

define( 'CW_THEME_VERISON', '1.2.0' );

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) ) {
	$content_width = 640; /* pixels */
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 */
function chriswiegman_setup() {

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	//Enable support for Post Thumbnails on posts and pages.
	add_theme_support( 'post-thumbnails' );

	//Enable post formats
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

}

add_action( 'after_setup_theme', 'chriswiegman_setup' );

/**
 * Register widget area.
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

	if ( defined( 'WP_LOCAL_DEV' ) && true === WP_LOCAL_DEV ) {

		wp_enqueue_style( 'chriswiegman-style', get_template_directory_uri() . '/lib/css/master.css', array(), CW_THEME_VERISON );

		wp_enqueue_script( 'chriswiegman-footer', get_template_directory_uri() . '/lib/js/footer.js', array( 'jquery' ), CW_THEME_VERISON, true );

	} else {

		wp_enqueue_style( 'chriswiegman-style', get_template_directory_uri() . '/lib/css/master.min.css', array(), CW_THEME_VERISON );

		wp_enqueue_script( 'chriswiegman-footer', get_template_directory_uri() . '/lib/js/footer.min.js', array( 'jquery' ), CW_THEME_VERISON, true );

	}

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
 * Create the correct more link
 */
function chriswiegman_excerpt_more() {

	return '... <a class="more-link" href="' . get_permalink( get_the_ID() ) . '">' . __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'chriswiegman' ) . '</a>';

}

add_filter( 'excerpt_more', 'chriswiegman_excerpt_more' );

add_action( 'wp_enqueue_scripts', 'chriswiegman_scripts' );

/**
 * Add custom styles to wysiwyg editor
 */
function chriswiegman_add_editor_styles() {

	if ( defined( 'WP_LOCAL_DEV' ) && true === WP_LOCAL_DEV ) {

		add_editor_style( get_stylesheet_directory_uri() . '/lib/css/editor.min.css' );

	} else {

		add_editor_style( get_stylesheet_directory_uri() . '/lib/css/editor.css' );

	}

}

add_action( 'init', 'chriswiegman_add_editor_styles' );

/**
 * Removes an extra jQuery Script
 */
function cw_remove_jquery_migrate( $scripts ) {

	if ( ! is_admin() ) {
		$scripts->remove( 'jquery' );
		$scripts->add( 'jquery', false, array( 'jquery-core' ), '1.11.1' );
	}

}

add_filter( 'wp_default_scripts', 'cw_remove_jquery_migrate' );

/**
 * Clean up the header
 */
function cw_feed_links() {

	echo '<link rel="alternate" type="' . feed_content_type() . '" title="Chris Wiegman | All Posts" href="http://feeds.chriswiegman.com" />' . PHP_EOL;
	echo '<link rel="alternate" type="' . feed_content_type() . '" title="Chris Wiegman | All Comments" href="http://feeds.chriswiegman.com/comments" />' . PHP_EOL;

}

remove_action( 'wp_head', 'wlwmanifest_link' );
remove_action( 'wp_head', 'wp_generator' );
remove_action( 'wp_head', 'feed_links_extra', 3 );
remove_action( 'wp_head', 'feed_links', 2 );
remove_action( 'wp_head', 'rsd_link' );
add_action( 'wp_head', 'cw_feed_links' );

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

//Add search form to menu
add_filter( 'wp_nav_menu_items', 'add_search_box_to_menu', 10, 2 );

function add_search_box_to_menu( $items, $args ) {

	// If this isn't the main navbar menu, do nothing
	if ( 'primary' !== $args->theme_location ) {
		return $items;
	}

	// On main menu: put styling around search and append it to the menu items
	return $items . '<li class="cw-nav-menu-search">' . get_search_form( false ) . '</li>';
}
