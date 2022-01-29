<?php
/**
 * The template for the common footer on every page.
 *
 * @package chriswiegman-theme
 */

?>

<footer>
	<?php
	wp_nav_menu(
		array(
			'theme_location' => 'footer',
			'container'      => '',
		)
	);
	?>
	<div>

	<div class="copyright">
		<?php
		wp_nav_menu(
			array(
				'theme_location' => 'copyright',
				'container'      => '',
			)
		);
		?>
	</div>
</footer>

<?php wp_footer(); ?>
</body>

</html>
