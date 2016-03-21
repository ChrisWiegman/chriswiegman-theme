<?php
/**
 * Test Core functions
 *
 * Unit tests for Core functions
 *
 * @since   0.1.0
 *
 * @package CW\Theme\Core
 *
 * @author  Chris Wiegman <chris@chriswiegman.com>
 */

namespace CW\Theme\Functions\Core;

use CW\Theme as Base;

/**
 * Class Core_Tests
 */
class Functions_Tests extends Base\TestCase {

	/**
	 * Files required for test.
	 *
	 * @var array
	 */
	protected $test_files = array(
		'functions/core.php',
	);

	/**
	 * Test theme setup
	 *
	 * @since 5.0.0
	 */
	function test_init() {

		// Setup.
		\WP_Mock::expectActionAdded( 'after_setup_theme', '\CW\Theme\Functions\Core\setup' );

		// Act.
		init();

		// Verify.
		$this->assertConditionsMet();

	}
}