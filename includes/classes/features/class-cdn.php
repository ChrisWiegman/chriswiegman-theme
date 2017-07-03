<?php
/**
 * Add MaxCDN
 *
 * Adds MaxCDN to asset URLs where appropriate.
 *
 * @package chriswiegman
 *
 * @since   2.3.0
 *
 * @author  Chris Wiegman <chris@chriswiegman.com>
 */

namespace CW\Theme\Features;

/**
 * Class CDN
 */
class CDN {

	/**
	 * Setup CDN
	 *
	 * Sets up various CDN information.
	 *
	 * @since 2.2.2
	 */
	public function __construct() {

		add_filter( 'the_content', array( $this, 'replace_content_urls' ) );
		add_filter( 'script_loader_src', array( $this, 'replace_script_urls' ) );
		add_filter( 'style_loader_src', array( $this, 'replace_style_urls' ) );
		add_filter( 'post_thumbnail_html', array( $this, 'post_thumbnail_html' ) );

	}

	/**
	 * Get CDN domain
	 *
	 * Returns the CDN domain for the current site.
	 *
	 * @since 2.2.0
	 *
	 * @return string The CDN domain.
	 */
	private function get_cdn_url() {

		$cdn_url = 'cdn1.chriswiegman.com';

		return $cdn_url;

	}

	/**
	 * Filters HTML
	 *
	 * Filters various HTML items to insert the CDN domain.
	 *
	 * @since 2.2.0
	 *
	 * @param string $html The HTML to filter.
	 *
	 * @return string the filtered HTML
	 */
	public function post_thumbnail_html( $html ) {

		if ( ! is_user_logged_in() ) {

			$rep = $this->get_cdn_url();

			$html = str_replace( '=/wp-content/uploads', '=https://' . $rep . '/wp-content/uploads', $html );
			$html = str_replace(
				array(
					'https://www.chriswiegman.com/content/uploads',
					'https://www.chriswiegman.com/content/uploads',
				),
				'https://' . $rep . '/content/uploads', $html
			);

		}

		return $html;

	}

	/**
	 * Filters post content
	 *
	 * Filters post content items to insert the CDN domain.
	 *
	 * @since 2.2.0
	 *
	 * @param string $content The content to filter.
	 *
	 * @return string the filtered content
	 */
	public function replace_content_urls( $content ) {

		if ( ! is_user_logged_in() ) {

			$rep = $this->get_cdn_url();

			$content = str_replace( '=/content/uploads', '=https://' . $rep . '/content/uploads', $content );
			$content = str_replace(
				array(
					'https://www.chriswiegman.com/content/uploads',
					'https://www.chriswiegman.com/content/uploads',
				),
				'https://' . $rep . '/content/uploads', $content
			);

		}

		return $content;
	}

	/**
	 * Filters JavaScript sources
	 *
	 * Filters various JavaScript source URLs to insert the CDN domain.
	 *
	 * @since 2.2.0
	 *
	 * @param string $src The url to filter.
	 *
	 * @return string the filtered url
	 */
	public function replace_script_urls( $src ) {

		if ( ! is_user_logged_in() ) {

			$cdn_domain = $this->get_cdn_url();

			$src = str_replace( 'www.chriswiegman.com', $cdn_domain, $src );

		}

		return $src;

	}

	/**
	 * Filters CSS sources
	 *
	 * Filters various CSS source URLs to insert the CDN domain.
	 *
	 * @since 2.2.0
	 *
	 * @param string $src The url to filter.
	 *
	 * @return string the filtered url
	 */
	public function replace_style_urls( $src ) {

		if ( ! is_user_logged_in() ) {

			$cdn_domain = $this->get_cdn_url();

			$src = str_replace(
				array(
					'http://www.chriswiegman.com',
					'https://www.chriswiegman.com',
				),
				'https://' . $cdn_domain, $src
			);

		}

		return $src;

	}
}
