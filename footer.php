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
			<p><span class="copyright">&copy; <?php echo date( 'Y', time() ); ?> Chris Wiegman - </span><span class="license"><a href="http://creativecommons.org/licenses/by-nc-nd/4.0/" target="_blank">Creative Commons Licensed</a></span> - <span class="policies"><a href="/policies" title="Policies and Disclosures">Policies and Disclosures</a></span></p>
		</div><!-- .site-info -->
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>
<script type="text/javascript">
	(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	})(window,document,'script','//www.google-analytics.com/analytics.js','ga');

	ga('create', 'UA-46206362-1', 'auto');
	ga('send', 'pageview');

</script>
</body>
</html>
