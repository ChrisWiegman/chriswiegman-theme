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
		<div class="site-info">
			<p><span class="copyright">&copy; <?php echo date( 'Y', time() ); ?> Chris Wiegman - </span><span class="license"><a href="http://creativecommons.org/licenses/by-nc-nd/4.0/" target="_blank">Creative Commons Licensed</a></span></p>
		</div><!-- .site-info -->
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
