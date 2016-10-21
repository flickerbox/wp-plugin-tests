<?php
/**
 * Global paths
 *
 * TESTPATH - Path to WordPress PHPUnit tests
 * ABSPATH - Path to codebase of the plugins you want to test
 */
define( 'TESTPATH', realpath(__DIR__ . '/../../') . '/tests/phpunit/');

if (!defined('ABSPATH')) {
	define( 'ABSPATH', '/Users/ccarlevato/Sites/com.flickerbox.labs/' );
}

/**
 * The WordPress tests functions, enables tests_add_filter().
 */
require_once  TESTPATH . 'includes/functions.php';

/**
 * Load main files for all plugins to be tested
 */
function _load_plugin() {

	// Third Party Plugins
	require ABSPATH . '/wp-content/mu-plugins/advanced-custom-fields-pro/acf.php';

	// Our Plugins
	require ABSPATH . '/wp-content/mu-plugins/flickerbox-themes/flickerbox-themes.php';

}
tests_add_filter( 'muplugins_loaded', '_load_plugin' );

/**
 * Set up the WordPress test environment
 */
require_once TESTPATH . 'includes/bootstrap.php';