<?php
/**
 * The main template file
 *
 * @package chriswiegman-theme
 */

get_header();
?>

<main>
	<article class="hero">
		<div class="container">
			<div class="content">
				<div class="intro">
					<h1>Hi, I'm Chris.</h1>
					<p>I'm an <a href="https://wpengine.com/" title="WP Engine">engineering manager</a>, teacher, <a href="/speaking">speaker</a>, aspiring <a href="/blog">writer</a> and pilot currently based in Sarasota, Florida. My work focuses on WordPress, developer experience and humane and sustainable technology.</p>
				</div>
				<img src="/wp-content/uploads/2022/04/chris-wiegman.png" alt="Chris Wiegman" />
			</div>
			<div class="social">
				<span>Find me elsewhere:</span>
				<div class="links">
					<a href="https://cfw.li/masto" title="Chris Wiegman on Mastodon"><svg
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
					<a href="https://cfw.li/code" title="My public Code"><svg
					xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true"
					focusable="false" width="1em" height="1em" style="
						-ms-transform: rotate(360deg);
						-webkit-transform: rotate(360deg);
						transform: rotate(360deg);
					" preserveaspectratio="xMidYMid meet" viewbox="0 -3.5 256 256">
					<title>My public code</title>
					<path
						d="M127.505 0C57.095 0 0 57.085 0 127.505c0 56.336 36.534 104.13 87.196 120.99 6.372 1.18 8.712-2.766 8.712-6.134 0-3.04-.119-13.085-.173-23.739-35.473 7.713-42.958-15.044-42.958-15.044-5.8-14.738-14.157-18.656-14.157-18.656-11.568-7.914.872-7.752.872-7.752 12.804.9 19.546 13.14 19.546 13.14 11.372 19.493 29.828 13.857 37.104 10.6 1.144-8.242 4.449-13.866 8.095-17.05-28.32-3.225-58.092-14.158-58.092-63.014 0-13.92 4.981-25.295 13.138-34.224-1.324-3.212-5.688-16.18 1.235-33.743 0 0 10.707-3.427 35.073 13.07 10.17-2.826 21.078-4.242 31.914-4.29 10.836.048 21.752 1.464 31.942 4.29 24.337-16.497 35.029-13.07 35.029-13.07 6.94 17.563 2.574 30.531 1.25 33.743 8.175 8.929 13.122 20.303 13.122 34.224 0 48.972-29.828 59.756-58.22 62.912 4.573 3.957 8.648 11.717 8.648 23.612 0 17.06-.148 30.791-.148 34.991 0 3.393 2.295 7.369 8.759 6.117 50.634-16.879 87.122-64.656 87.122-120.973C255.009 57.085 197.922 0 127.505 0" />
					<path
						d="M47.755 181.634c-.28.633-1.278.823-2.185.389-.925-.416-1.445-1.28-1.145-1.916.275-.652 1.273-.834 2.196-.396.927.415 1.455 1.287 1.134 1.923M54.027 187.23c-.608.564-1.797.302-2.604-.589-.834-.889-.99-2.077-.373-2.65.627-.563 1.78-.3 2.616.59.834.899.996 2.08.36 2.65M58.33 194.39c-.782.543-2.06.034-2.849-1.1-.781-1.133-.781-2.493.017-3.038.792-.545 2.05-.055 2.85 1.07.78 1.153.78 2.513-.019 3.069M65.606 202.683c-.699.77-2.187.564-3.277-.488-1.114-1.028-1.425-2.487-.724-3.258.707-.772 2.204-.555 3.302.488 1.107 1.026 1.445 2.496.7 3.258M75.01 205.483c-.307.998-1.741 1.452-3.185 1.028-1.442-.437-2.386-1.607-2.095-2.616.3-1.005 1.74-1.478 3.195-1.024 1.44.435 2.386 1.596 2.086 2.612M85.714 206.67c.036 1.052-1.189 1.924-2.705 1.943-1.525.033-2.758-.818-2.774-1.852 0-1.062 1.197-1.926 2.721-1.951 1.516-.03 2.758.815 2.758 1.86M96.228 206.267c.182 1.026-.872 2.08-2.377 2.36-1.48.27-2.85-.363-3.039-1.38-.184-1.052.89-2.105 2.367-2.378 1.508-.262 2.857.355 3.049 1.398" />
					</svg></a>
				</div>
			</div>
		</div>

		<div class="container">
			<h2 class="main-header"><span>Recent Posts</span> <a href="/blog">View All</a></h2>
			<?php
			if ( have_posts() ) {

				/* Start the Loop */
				while ( have_posts() ) {
					the_post();
					?>
					<a class="post" href="<?php the_permalink(); ?>">
						<?php the_title( '<h3 class="post-title">', '</h3>' ); ?>
						<span class="post-day"><?php the_date( 'M j' ); ?></span>
					</a>
					<?php
				}
			}
			?>
		</div>
	</article>
</main>

<?php
get_footer();
