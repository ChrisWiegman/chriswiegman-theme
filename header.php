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
	<title><?php esc_html( wp_title( '|', true, 'right' ) ); ?></title>
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<div id="page" class="hfeed site">
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
			<div class="site-title">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><span class="logo-chris">Chris</span><span class="logo-wiegman">Wiegman</span></a>
			</div>

			<div class="menu-toggle"><i class="menu-icon icon-menu"></i><?php esc_html_e( 'Menu', 'chriswiegman' ); ?>
			</div>
			<nav id="site-navigation" class="main-navigation" role="navigation">
				<?php wp_nav_menu( array( 'theme_location' => 'primary' ) ); ?>
			</nav>

		</div>
		<!-- #site-navigation -->
	</header>
	<!-- #masthead -->

	<div id="content" class="site-content">
