<?php
/**
 * The template for the common footer on every page.
 *
 * @package chriswiegman-theme
 */

?>

</main>

<footer>
	<div class="content">
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
			<div class="copyright"><a rel="license" href="https://creativecommons.org/licenses/by-sa/4.0/" title="Attribution-ShareAlike 4.0 International (CC BY-SA 4.0) license">Creative Commons
					Licensed</a> · <a href="/policies/">Policies</a></div>
		</div>
	</div>
</footer>

<?php wp_footer(); ?>
</body>

</html>
