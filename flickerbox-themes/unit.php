<?php
/**
 * Lets test a plugin!
 *
 * @group flickerbox
 * @group flickerbox-themes
 * @group flickerbox-unit-tests
 * @group flickerbox-themes-unit-tests
 */


class Tests_Plugins_FlickerboxThemesUnit extends WP_UnitTestCase {

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
		$this->assertEquals(SRCPATH . 'wp-content/mu-plugins/flickerbox-themes/flickerbox-themes.php', \FB_Themes\Core::config('base'));
		$this->assertEquals(SRCPATH . 'wp-content/mu-plugins/flickerbox-themes/', \FB_Themes\Core::config('dir'));
		$this->assertEquals(get_site_url() . '/wp-content/mu-plugins/flickerbox-themes', \FB_Themes\Core::config('url'));
		$this->assertEquals('FB_Themes\\', \FB_Themes\Core::config('namespace'));
		$this->assertEquals('fbthemes', \FB_Themes\Core::config('prefix'));
		$this->assertEquals('flickerbox-themes', \FB_Themes\Core::config('text-domain'));
	}

	/**
	 * Confirm the plugin creates proper post type
	 */
	function test_cta_post_type(){
		// Retrieve CTA post type object
		$test_object = get_post_type_object(sprintf('%s--cta', \FB_Themes\Core::config('prefix')));

		// Validate object is a post
		$this->assertInstanceOf('WP_Post_Type', $test_object);

		// Validate object name, this should never be references directly, but just in case
		$this->assertEquals('fbthemes--cta', $test_object->name);

		// Validate object labels
		$this->assertEquals('Calls To Action', $test_object->labels->name);
		$this->assertEquals('Call To Action', $test_object->labels->singular_name);
		$this->assertEquals('Add New Call to Action', $test_object->labels->add_new_item);
		$this->assertEquals('Edit Call to Action', $test_object->labels->edit_item);
		$this->assertEquals('New CTA', $test_object->labels->new_item);
		$this->assertEquals('View CTA', $test_object->labels->view_item);
		
		// Validate object settings
		$this->assertEquals(false, $test_object->public);
		$this->assertEquals(true, $test_object->show_ui);
		$this->assertEquals(false, $test_object->has_archive);
		$this->assertEquals(true, $test_object->show_in_menu);
		$this->assertEquals(true, $test_object->exclude_from_search);
		$this->assertEquals('page', $test_object->capability_type);
		$this->assertEquals(true, $test_object->map_meta_cap);
		$this->assertEquals(false, $test_object->hierarchical);
		$this->assertEquals('fbthemes--cta', $test_object->query_var);
		$this->assertEquals('dashicons-phone', $test_object->menu_icon);


		// Validate supported admin edit inputs
	}

}

