<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @since   5.0.0
 *
 * @package CW\Theme\Templates\Header
 *
 * @author  Chris Wiegman <chris@chriswiegman.com>
 */

namespace CW\Theme\Templates\Header;
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?php wp_title( '|', true, 'right' ); ?></title>
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<?php
if ( is_home() && is_active_sidebar( 'intro' ) ) {
	$intro_class = 'has-intro ';
} else {
	$intro_class = '';
}
?>
<div id="page" class="hfeed site <?php echo esc_attr( $intro_class ); ?>">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'chriswiegman' ); ?></a>

	<?php
	if ( is_user_logged_in() ) {
		$hclass = 'top-padding ';
	} else {
		$hclass = '';
	}
	?>
	<header id="masthead" class="<?php echo esc_attr( $hclass ); ?>site-header" role="banner">
		<div class="progress-wrap">
			<div class="progress-indicator"></div>
		</div>
		<div class="wrap">
			<div class="site-branding">
				<div class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><img
							src="https://cdn1.chriswiegman.com/content/themes/chriswiegman/img/logo.png" alt="Chris Wiegman" width="256" height="40"></a>
				</div>
			</div>

			<div class="menu-toggle"><?php esc_html_e( 'Menu', 'chriswiegman' ); ?></div>
			<nav id="site-navigation" class="main-navigation" role="navigation">

				<?php wp_nav_menu( array( 'theme_location' => 'primary' ) ); ?>
			</nav>

		</div>
		<!-- #site-navigation -->
	</header>
	<!-- #masthead -->

	<?php if ( is_home() && is_active_sidebar( 'intro' ) ) { ?>

		<div id="intro">
			<div id="intro-widget" class="widget-area" role="complementary">
				<?php dynamic_sidebar( 'intro' ); ?>
			</div>
		</div>
		<!-- #intro -->

	<?php } ?>

	<div id="content" class="site-content">
