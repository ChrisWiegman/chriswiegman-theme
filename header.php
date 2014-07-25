<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package ChrisWiegman
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?php wp_title( '|', true, 'right' ); ?></title>
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="hfeed site">
	<a class="skip-link screen-reader-text" href="#content"><?php _e( 'Skip to content', 'chriswiegman' ); ?></a>

	<header id="masthead" class="site-header" role="banner">
		<div class="wrap">

			<div class="site-branding">
				<div class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><img src="<?php echo get_stylesheet_directory_uri() . '/img/logo.png'; ?>" alt="Chris Wiegman" width="256" height="40"></a></div>
			</div>

			<nav id="site-navigation" class="main-navigation" role="navigation">
				<button class="menu-toggle"><?php _e( 'Primary Menu', 'chriswiegman' ); ?></button>
				<?php wp_nav_menu( array( 'theme_location' => 'primary' ) ); ?>
			</nav>

		</div>
		<!-- #site-navigation -->
	</header>
	<!-- #masthead -->

	<?php if ( is_active_sidebar( 'intro' ) ) { ?>

		<div id="intro">
			<div id="intro-widget" class="widget-area" role="complementary">
				<?php dynamic_sidebar( 'intro' ); ?>
			</div>
		</div>
		<!-- #intro -->

	<?php } ?>

	<div id="content" class="site-content">
