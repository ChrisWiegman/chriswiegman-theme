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

</div>

<div class="footer wrapper">
	<nav class="nav">
		<?php
		wp_nav_menu(
			array(
				'theme_location' => 'footer',
				'container'      => '',
				'menu_class'     => 'footer-menu',
			)
		);
		?>
	</nav>
	<div>
		<div class="copyright">&copy; <?php gmdate( 'Y' ); ?> <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="me" title="<?php bloginfo( 'name' ); ?> Homepage">Chris
				Wiegman</a> · <a rel="license" href="https://creativecommons.org/licenses/by-sa/4.0/" title="Attribution-ShareAlike 4.0 International (CC BY-SA 4.0) license">Creative Commons
				Licensed</a> · <a href="/policies/">Policies</a> · <a href="mailto:contact@chriswiegman.com"
				rel="me" title="Contact Chris Wiegman">Contact</a></div>
	</div>
</div>

<?php wp_footer(); ?>
</body>

</html>
