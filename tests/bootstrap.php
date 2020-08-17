<?php

require_once dirname( dirname( __FILE__ ) ) . '/vendor/autoload.php';

WP_Mock::setUsePatchwork( false );

// Now call the bootstrap method of WP Mock
WP_Mock::bootstrap();

/**
 * Now we include any plugin files that we need to be able to run the tests. This
 * should be files that define the functions and classes you're going to test.
 */
require_once dirname( dirname( __FILE__ ) )  . '/theme/functions.php';
