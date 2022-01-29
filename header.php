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
	<div class="content">
		<span class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="Chris Wiegman"><img alt="" src="data:image/png;base64,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" alt="Chris Wiegman"> Chris Wiegman</a></span>
		<?php
		wp_nav_menu(
			array(
				'theme_location' => 'primary',
				'container'      => '',
			)
		);
		?>
	</div>
</header>
