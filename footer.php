<?php
/**
 * The template for the common footer on every page.
 *
 * @package chriswiegman-theme
 */

?>

<footer>
	<div class="content">
		<?php
		wp_nav_menu(
			array(
				'theme_location' => 'footer',
				'container'      => '',
			)
		);
		?>

		<div class="copyright">
			<span class="copyright-date">Copyright&copy; <?php echo esc_html( gmdate( 'Y' ) ); ?></span> | <a title="Attribution-ShareAlike 4.0 International (CC BY-SA 4.0) license" href="https://creativecommons.org/licenses/by-nc-sa/4.0/" rel="license">Creative Commons Licensed</a> | <a href="/policies/">Policies</a>
		</div>
	</div>
</footer>

<?php wp_footer(); ?>
</body>

</html>
