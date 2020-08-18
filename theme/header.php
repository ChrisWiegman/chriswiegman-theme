<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package chriswiegman-theme
 */

?>

<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<div class="header">
	<span class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php bloginfo( 'name' ); ?> Homepage"><?php bloginfo( 'name' ); ?></a></span>
	<?php
	wp_nav_menu(
		array(
			'theme_location' => 'primary',
			'container'      => '',
		)
	);
	?>
</div>

<div class="container">
