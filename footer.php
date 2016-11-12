<?php
/**
 * The template for displaying archive pages.
 *
 * @since   5.0.0
 *
 * @package CW\Theme\Templates\Footer
 *
 * @author  Chris Wiegman <chris@chriswiegman.com>
 */

namespace CW\Theme\Templates\Footer;
?>

</div><!-- #content -->

<footer id="colophon" class="site-footer" role="contentinfo">
	<div class="footer-wrap">
		<div class="footer-menu">
			<?php wp_nav_menu( array( 'theme_location' => 'footer' ) ); ?>
		</div>
		<!-- .site-info -->
		<div class="site-info">
			<span class="copyright">&copy; <?php echo esc_html( date( 'Y', time() ) ); ?> Chris Wiegman</span> -
			<span class="license"><a href="http://creativecommons.org/licenses/by-nc-nd/4.0/" target="_blank"><?php esc_html_e( 'Creative Commons Licensed', 'chriswiegman' ); ?></a></span>
			-
			<span class="poweredby"><?php esc_html_e( 'Powered by', 'chriswiegman' ); ?>
				<a href="http://wordpress.org/" title="WordPress" target="_blank">WordPress</a></span>
		</div>
		<!-- .site-info -->
	</div>
</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>
</body>
</html>
