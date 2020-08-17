<?php
/**
 * Test the primary theme file
 *
 * @package ChrisWiegman\ChrisWiegman_Theme
 */

 namespace ChrisWiegman\ChrisWiegman_Theme\Tests;

use function PHPUnit\Framework\assertEquals;

/**
 * Test the main plugin file
 */
class PluginFileTest extends \WP_Mock\Tools\TestCase {

	/**
	 * Test loader function
	 */
	public function test_chriswiegman_wordpress_plugin_starter_loader() {

		this->assertEquals( 1, 1 );

	}
}
