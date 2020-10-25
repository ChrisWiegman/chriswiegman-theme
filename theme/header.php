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

	<?php wp_head(); ?>
</head>

<body>

<div class="header">
	<div class="content">
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
</div>

<div class="container">
