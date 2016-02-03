<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package ChrisWiegman
 */
?>

</div><!-- #content -->

<footer id="colophon" class="site-footer" role="contentinfo">
	<div class="footer-wrap">
		<div class="footer-menu">
			<?php wp_nav_menu( array( 'theme_location' => 'footer' ) ); ?>
		</div>
		<!-- .site-info -->
		<div class="site-info">
			<span class="copyright">&copy; <?php echo date( 'Y', time() ); ?> Chris Wiegman</span> -
			<span class="license"><a href="http://creativecommons.org/licenses/by-nc-nd/4.0/" target="_blank">Creative Commons Licensed</a></span> -
			<span class="poweredby">Powered by <a href="http://wordpress.org/" title="WordPress" target="_blank">WordPress</a></span>
		</div>
		<!-- .site-info -->
	</div>
</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>
</body>
</html>
