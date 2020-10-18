<?php
/**
 * Test the primary theme file
 *
 * @package chriswiegman-theme
 */

 namespace chriswiegman\theme\tests;

use function PHPUnit\Framework\assertEquals;

/**
 * Test the main plugin file
 */
class PluginFileTest extends \WP_Mock\Tools\TestCase {

	/**
	 * Test loader function
	 */
	public function test_chriswiegman_loader() {

		$this->assertEquals( 1, 1 );

	}
}
