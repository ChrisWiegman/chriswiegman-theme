<?php
/**
 * The header template.
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
	<link rel="icon" href="/favicon.ico" type="image/x-icon">
	<?php wp_head(); ?>
</head>

<body>

<header>
	<span class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php bloginfo( 'name' ); ?> Homepage"><?php bloginfo( 'name' ); ?></a></span>
	<?php
	wp_nav_menu(
		array(
			'theme_location' => 'primary',
			'container'      => '',
		)
	);
	?>
</header>
