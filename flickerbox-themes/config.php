<?php
/**
 * Performs configuration tests for the flickerbox-themes plugin
 *
 * @group flickerbox
 * @group flickerbox-config
 * @group flickerbox-themes
 * @group flickerbox-themes-config
 */


class Tests_Plugins_FlickerboxThemesConfig extends WP_UnitTestCase {

	// Setup
	function setUp() {
		parent::setUp();
	}

	// Teardown
	function tearDown() {
		parent::tearDown();
	}

	/**
	 * Confirm the plugin contains expected configuration values
	 */
	function test_plugin_config(){
		$this->assertEquals(ABSPATH . 'wp-content/mu-plugins/flickerbox-themes/flickerbox-themes.php', \FB_Themes\Core::config('base'));
		$this->assertEquals(ABSPATH . 'wp-content/mu-plugins/flickerbox-themes/', \FB_Themes\Core::config('dir'));
		$this->assertEquals(get_site_url() . '/wp-content/mu-plugins/flickerbox-themes', \FB_Themes\Core::config('url'));
		$this->assertEquals('FB_Themes\\', \FB_Themes\Core::config('namespace'));
		$this->assertEquals('fbthemes', \FB_Themes\Core::config('prefix'));
		$this->assertEquals('flickerbox-themes', \FB_Themes\Core::config('text-domain'));
	}

}
