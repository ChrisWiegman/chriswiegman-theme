<?php
/**
 * The main template file
 *
 * @package chriswiegman-theme
 */

get_header();
?>

<main>

	<div class="h-card intro">
	<img class="u-photo" src="/wp-content/uploads/2021/04/chris-wiegman-401x401.png" alt="Chris Wiegman" />
	<div class="intro-text">
		<p>
		Hello, I'm
		<a class="u-url u-uid p-name" href="https://chriswiegman-theme.lndo.site/">Chris Wiegman</a>.
		<span class="p-note">I am an <span class="p-category">engineering manager</span>,
			<span class="p-category">teacher</span>,
			<span class="p-category">speaker</span>, aspiring
			<span class="p-category">writer</span> and
			<span class="p-category">pilot</span> based in
			<span class="p-locality">Sarasota, Florida</span> and focusing on
			<span class="p-category">WordPress</span>,
			<span class="p-category">developer experience</span> and
			<span class="p-category">humane</span> and
			<span class="p-category">sustainable tech</span> tech.</span>
		</p>
		<p class="social">
		<a rel="me" class="u-url" href="https://cfw.li/masto" title="Chris Wiegman on Mastodon"><svg
			xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true"
			focusable="false" width="1em" height="1em" style="
				-ms-transform: rotate(360deg);
				-webkit-transform: rotate(360deg);
				transform: rotate(360deg);
			" preserveaspectratio="xMidYMid meet" viewbox="0 0 24 24">
			<title>Chris Wiegman on Mastodon</title>
			<path
				d="M23.193 7.879c0-5.206-3.411-6.732-3.411-6.732C18.062.357 15.108.025 12.041 0h-.076c-3.068.025-6.02.357-7.74 1.147c0 0-3.411 1.526-3.411 6.732c0 1.192-.023 2.618.015 4.129c.124 5.092.934 10.109 5.641 11.355c2.17.574 4.034.695 5.535.612c2.722-.15 4.25-.972 4.25-.972l-.09-1.975s-1.945.613-4.129.539c-2.165-.074-4.449-.233-4.799-2.891a5.499 5.499 0 0 1-.048-.745s2.125.52 4.817.643c1.646.075 3.19-.097 4.758-.283c3.007-.359 5.625-2.212 5.954-3.905c.517-2.665.475-6.507.475-6.507zm-4.024 6.709h-2.497V8.469c0-1.29-.543-1.944-1.628-1.944c-1.2 0-1.802.776-1.802 2.312v3.349h-2.483v-3.35c0-1.536-.602-2.312-1.802-2.312c-1.085 0-1.628.655-1.628 1.944v6.119H4.832V8.284c0-1.289.328-2.313.987-3.07c.68-.758 1.569-1.146 2.674-1.146c1.278 0 2.246.491 2.886 1.474L12 6.585l.622-1.043c.64-.983 1.608-1.474 2.886-1.474c1.104 0 1.994.388 2.674 1.146c.658.757.986 1.781.986 3.07v6.304z" />
			</svg></a>
		<a rel="me" class="u-url" href="https://twitter.com/ChrisWiegman" title="Chris Wiegman on Twitter"><svg
			xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true"
			focusable="false" width="1em" height="1em" style="
				-ms-transform: rotate(360deg);
				-webkit-transform: rotate(360deg);
				transform: rotate(360deg);
			" preserveaspectratio="xMidYMid meet" viewbox="0 0 24 24">
			<title>Chris Wiegman on Twitter</title>
			<path
				d="M23.954 4.569a10 10 0 0 1-2.825.775a4.958 4.958 0 0 0 2.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 0 0-8.384 4.482C7.691 8.094 4.066 6.13 1.64 3.161a4.822 4.822 0 0 0-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 0 1-2.228-.616v.061a4.923 4.923 0 0 0 3.946 4.827a4.996 4.996 0 0 1-2.212.085a4.937 4.937 0 0 0 4.604 3.417a9.868 9.868 0 0 1-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 0 0 7.557 2.209c9.054 0 13.999-7.496 13.999-13.986c0-.209 0-.42-.015-.63a9.936 9.936 0 0 0 2.46-2.548l-.047-.02z" />
			</svg></a>
		<a rel="me" class="u-url" href="https://cfw.li/code" title="Chris Wiegman's Code"><svg
			xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true"
			focusable="false" width="1em" height="1em" style="
				-ms-transform: rotate(360deg);
				-webkit-transform: rotate(360deg);
				transform: rotate(360deg);
			" preserveaspectratio="xMidYMid meet" viewbox="0 -3.5 256 256">
			<title>Chris Wiegman's public code projects</title>
			<path
				d="M127.505 0C57.095 0 0 57.085 0 127.505c0 56.336 36.534 104.13 87.196 120.99 6.372 1.18 8.712-2.766 8.712-6.134 0-3.04-.119-13.085-.173-23.739-35.473 7.713-42.958-15.044-42.958-15.044-5.8-14.738-14.157-18.656-14.157-18.656-11.568-7.914.872-7.752.872-7.752 12.804.9 19.546 13.14 19.546 13.14 11.372 19.493 29.828 13.857 37.104 10.6 1.144-8.242 4.449-13.866 8.095-17.05-28.32-3.225-58.092-14.158-58.092-63.014 0-13.92 4.981-25.295 13.138-34.224-1.324-3.212-5.688-16.18 1.235-33.743 0 0 10.707-3.427 35.073 13.07 10.17-2.826 21.078-4.242 31.914-4.29 10.836.048 21.752 1.464 31.942 4.29 24.337-16.497 35.029-13.07 35.029-13.07 6.94 17.563 2.574 30.531 1.25 33.743 8.175 8.929 13.122 20.303 13.122 34.224 0 48.972-29.828 59.756-58.22 62.912 4.573 3.957 8.648 11.717 8.648 23.612 0 17.06-.148 30.791-.148 34.991 0 3.393 2.295 7.369 8.759 6.117 50.634-16.879 87.122-64.656 87.122-120.973C255.009 57.085 197.922 0 127.505 0" />
			<path
				d="M47.755 181.634c-.28.633-1.278.823-2.185.389-.925-.416-1.445-1.28-1.145-1.916.275-.652 1.273-.834 2.196-.396.927.415 1.455 1.287 1.134 1.923M54.027 187.23c-.608.564-1.797.302-2.604-.589-.834-.889-.99-2.077-.373-2.65.627-.563 1.78-.3 2.616.59.834.899.996 2.08.36 2.65M58.33 194.39c-.782.543-2.06.034-2.849-1.1-.781-1.133-.781-2.493.017-3.038.792-.545 2.05-.055 2.85 1.07.78 1.153.78 2.513-.019 3.069M65.606 202.683c-.699.77-2.187.564-3.277-.488-1.114-1.028-1.425-2.487-.724-3.258.707-.772 2.204-.555 3.302.488 1.107 1.026 1.445 2.496.7 3.258M75.01 205.483c-.307.998-1.741 1.452-3.185 1.028-1.442-.437-2.386-1.607-2.095-2.616.3-1.005 1.74-1.478 3.195-1.024 1.44.435 2.386 1.596 2.086 2.612M85.714 206.67c.036 1.052-1.189 1.924-2.705 1.943-1.525.033-2.758-.818-2.774-1.852 0-1.062 1.197-1.926 2.721-1.951 1.516-.03 2.758.815 2.758 1.86M96.228 206.267c.182 1.026-.872 2.08-2.377 2.36-1.48.27-2.85-.363-3.039-1.38-.184-1.052.89-2.105 2.367-2.378 1.508-.262 2.857.355 3.049 1.398" />
			</svg></a>
		<a rel="me" class="u-url" href="https://profiles.wordpress.org/chriswiegman/"
			title="Chris Wiegman on WordPress.org"><svg xmlns="http://www.w3.org/2000/svg"
			xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" focusable="false" width="1em" height="1em"
			style="
				-ms-transform: rotate(360deg);
				-webkit-transform: rotate(360deg);
				transform: rotate(360deg);
			" preserveaspectratio="xMidYMid meet" viewbox="0 0 24 24">
			<title>Chris Wiegman on WordPress.org</title>
			<path
				d="M21.469 6.825c.84 1.537 1.318 3.3 1.318 5.175c0 3.979-2.156 7.456-5.363 9.325l3.295-9.527c.615-1.54.82-2.771.82-3.864c0-.405-.026-.78-.07-1.11m-7.981.105c.647-.03 1.232-.105 1.232-.105c.582-.075.514-.93-.067-.899c0 0-1.755.135-2.88.135c-1.064 0-2.85-.15-2.85-.15c-.585-.03-.661.855-.075.885c0 0 .54.061 1.125.09l1.68 4.605l-2.37 7.08L5.354 6.9c.649-.03 1.234-.1 1.234-.1c.585-.075.516-.93-.065-.896c0 0-1.746.138-2.874.138c-.2 0-.438-.008-.69-.015C4.911 3.15 8.235 1.215 12 1.215c2.809 0 5.365 1.072 7.286 2.833c-.046-.003-.091-.009-.141-.009c-1.06 0-1.812.923-1.812 1.914c0 .89.513 1.643 1.06 2.531c.411.72.89 1.643.89 2.977c0 .915-.354 1.994-.821 3.479l-1.075 3.585l-3.9-11.61l.001.014zM12 22.784c-1.059 0-2.081-.153-3.048-.437l3.237-9.406l3.315 9.087c.024.053.05.101.078.149c-1.12.393-2.325.609-3.582.609M1.211 12c0-1.564.336-3.05.935-4.39L7.29 21.709A10.794 10.794 0 0 1 1.211 12M12 0C5.385 0 0 5.385 0 12s5.385 12 12 12s12-5.385 12-12S18.615 0 12 0" />
			</svg></a>
		<a rel="me" class="u-url" href="http://cfw.li/gpg" title="Chris Wiegman's public key"><svg
			xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true"
			focusable="false" width="0.82em" height="1em" style="
				-ms-transform: rotate(360deg);
				-webkit-transform: rotate(360deg);
				transform: rotate(360deg);
			" preserveaspectratio="xMidYMid meet" viewbox="0 0 832 1024">
			<title>Chris Wiegman's public key</title>
			<path
				d="M704 384h-32V262q0-111-72.5-186.5T415 0q-74 0-133 35.5t-90.5 95T160 262v122h-32q-53 0-90.5 37.5T0 512v384q0 53 37.5 90.5T128 1024h576q53 0 90.5-37.5T832 896V512q0-53-37.5-90.5T704 384zM224 262q0-84 53-141t138-57t139 56.5T608 262v122H224V262zm544 634q0 17-8.5 32T736 951.5t-32 8.5H128q-26 0-45-19t-19-45V512q0-26 19-45t45-19h576q26 0 45 19t19 45v384zM416 576q-27 0-45.5 18.5T352 640q0 36 32 55v105q0 13 9.5 22.5T416 832t22.5-9.5T448 800V695q32-19 32-55q0-27-18.5-45.5T416 576z" />
			</svg></a>
		</p>
	</div>
	</div>

	<div>
		<h2 class="main-header"><span>Recent Posts</span> <a href="/blog">View All</a></h2>
		<?php
		if ( have_posts() ) {

			/* Start the Loop */
			while ( have_posts() ) {
				the_post();
				?>
				<a href="<?php esc_url( get_the_permalink() ); ?>">
					<?php the_title( '<span class="post-title">', '</span>' ); ?>
					<span class="post-day"><?php get_the_date( 'M j' ); ?></span>
				</a>

				<?php
			}
		}
		?>
	</div>
</main>

<?php
get_footer();
