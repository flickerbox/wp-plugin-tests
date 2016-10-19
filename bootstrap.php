<?php

// Path to /WPROOT/tests/phpunit/

define( 'TESTPATH', realpath(__DIR__ . '/../../') . '/tests/phpunit/');
define( 'SRCPATH', '/Users/ccarlevato/Sites/com.flickerbox.labs/' );

/**
 * The WordPress tests functions.
 *
 * We are loading this so that we can add our tests filter
 * to load the plugin, using tests_add_filter().
 */
require_once  TESTPATH . 'includes/functions.php';

/**
 * Manually load the plugin main file.
 *
 * The plugin won't be activated within the test WP environment,
 * that's why we need to load it manually.
 *
 * You will also need to perform any installation necessary after
 * loading your plugin, since it won't be installed.
 */
function _manually_load_plugin() {

	// require your plugin files for any plugins to be tested here.

	require SRCPATH . '/wp-content/mu-plugins/flickerbox-themes/flickerbox-themes.php';

	// Make sure plugin is installed here ...
}
tests_add_filter( 'muplugins_loaded', '_manually_load_plugin' );

/**
 * Sets up the WordPress test environment.
 */
require_once TESTPATH . 'includes/bootstrap.php';