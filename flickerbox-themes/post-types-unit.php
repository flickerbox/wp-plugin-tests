<?php
/**
 * Performs unit tests for the flickerbox-themes plugin post types
 *
 * @group flickerbox
 * @group flickerbox-unit
 * @group flickerbox-themes
 * @group flickerbox-themes-unit
 */


class Tests_Plugins_FlickerboxThemesPostTypeUnit extends WP_UnitTestCase {

	// Setup
	function setUp() {
		parent::setUp();
	}

	// Teardown
	function tearDown() {
		parent::tearDown();
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
		$this->assertTrue(post_type_supports($test_object->name, 'title'));
	}

	/**
	 * Confirm CTA custom fields (used for creating/editing CTA posts)
	 *
	 * JSON source located at /flickerbox-themes/data/acf/acf-cta-post-type-edit.json
	 *
	 * @requires function acf_get_fields
	 */
	function test_cta_custom_fields(){
		$test_group = 'group_cta_edit';
		$fields = array();
		$validated_fields = 0;
		$expected_number_of_fields = 14;

		// Retrieve CTA edit custom fields and organize for testing
		foreach(acf_get_fields($test_group) as $field){
			$fields[$field['name']] = $field;
		}

		// Confirm all required custom fields are present
		$this->assertTrue(array_key_exists('content', $fields));
		$this->assertTrue(array_key_exists('heading', $fields));
		$this->assertTrue(array_key_exists('message_text', $fields));
		$this->assertTrue(array_key_exists('button_text', $fields));
		$this->assertTrue(array_key_exists('button_url', $fields));
		$this->assertTrue(array_key_exists('button_target', $fields));
		$this->assertTrue(array_key_exists('design', $fields));
		$this->assertTrue(array_key_exists('message_color', $fields));
		$this->assertTrue(array_key_exists('message_background', $fields));
		$this->assertTrue(array_key_exists('border_color', $fields));
		$this->assertTrue(array_key_exists('background_style', $fields));
		$this->assertTrue(array_key_exists('background_images', $fields));
		$this->assertTrue(array_key_exists('background_color', $fields));
		$this->assertTrue(array_key_exists('button_styles', $fields));

		// Validate Content Tab and count it
		$this->assertEquals('tab', $fields['content']['type']);
		$this->assertEquals('Content', $fields['content']['label']);
		$this->assertEquals('top', $fields['content']['placement']);
		$validated_fields++;

		// Validate Heading Field and count it
		$this->assertEquals('fbacf_header', $fields['heading']['type']);
		$this->assertEquals('Heading', $fields['heading']['label']);
		$this->assertEquals('1', $fields['heading']['required']);
		$this->assertGreaterThanOrEqual(70, $fields['heading']['maxlength']);
		$this->assertEquals(["h1", "h2", "h3", "h4", "h5", "h6"], $fields['heading']['allowed_sizes']);
		$this->assertEquals(["left", "center", "right"], $fields['heading']['allowed_alignments']);
		$validated_fields++;

		// Validate Message Text Field and count it
		$this->assertEquals('text', $fields['message_text']['type']);
		$this->assertEquals('Message Text', $fields['message_text']['label']);
		$this->assertEquals('1', $fields['message_text']['required']);
		$this->assertEquals('300', $fields['message_text']['maxlength']);
		$this->assertEquals('0', $fields['message_text']['readonly']);
		$this->assertEquals('0', $fields['message_text']['disabled']);
		$validated_fields++;

		// Validate Button Text Field and count it
		$this->assertEquals('text', $fields['button_text']['type']);
		$this->assertEquals('Button Text', $fields['button_text']['label']);
		$this->assertEquals('1', $fields['button_text']['required']);
		$this->assertEquals('70', $fields['button_text']['maxlength']);
		$this->assertEquals('0', $fields['button_text']['readonly']);
		$this->assertEquals('0', $fields['button_text']['disabled']);
		$validated_fields++;

		// Validate Button URL Field and count it
		$this->assertEquals('text', $fields['button_url']['type']);
		$this->assertEquals('Button URL', $fields['button_url']['label']);
		$this->assertEquals('1', $fields['button_url']['required']);
		$this->assertEquals('300', $fields['button_url']['maxlength']);
		$this->assertEquals('0', $fields['button_url']['readonly']);
		$this->assertEquals('0', $fields['button_url']['disabled']);
		$validated_fields++;

		// Validate Button Target Field and count it
		$this->assertEquals('select', $fields['button_target']['type']);
		$this->assertEquals('Button Target', $fields['button_target']['label']);
		$this->assertEquals(['_blank' => 'Open in New Tab/Window', '_self' => 'Open in Same Tab/Window'], $fields['button_target']['choices']);
		$this->assertEquals(['_blank'], $fields['button_target']['default_value']);
		$this->assertEquals('0', $fields['button_target']['readonly']);
		$this->assertEquals('0', $fields['button_target']['disabled']);
		$validated_fields++;

		// Validate Design Tab and count it
		$this->assertEquals('tab', $fields['design']['type']);
		$this->assertEquals('Design', $fields['design']['label']);
		$this->assertEquals('top', $fields['design']['placement']);
		$validated_fields++;

		// Validate Heading & Message Color Field and count it
		$this->assertEquals('color_picker', $fields['message_color']['type']);
		$this->assertEquals('Heading & Message Color', $fields['message_color']['label']);
		$this->assertNotNull($fields['message_color']['instructions']);
		$this->assertEquals('0', $fields['message_color']['required']);
		$this->assertEquals('#000000', $fields['message_color']['default_value']);
		$validated_fields++;

		// Validate Heading & Message Background Field and count it
		$this->assertEquals('color_picker', $fields['message_background']['type']);
		$this->assertEquals('Heading & Message Background', $fields['message_background']['label']);
		$this->assertNotNull($fields['message_background']['instructions']);
		$this->assertEquals('0', $fields['message_background']['required']);
		$this->assertEquals('#FFFFFF', $fields['message_background']['default_value']);
		$validated_fields++;

		// Validate Border Color Field and count it
		$this->assertEquals('color_picker', $fields['border_color']['type']);
		$this->assertEquals('Border Color', $fields['border_color']['label']);
		$this->assertNotNull($fields['border_color']['instructions']);
		$this->assertEquals('0', $fields['border_color']['required']);
		$this->assertEquals('', $fields['border_color']['default_value']);
		$validated_fields++;

		// Validate Background Style Field and count it
		$this->assertEquals('radio', $fields['background_style']['type']);
		$this->assertEquals('Background Style', $fields['background_style']['label']);
		$this->assertEquals(['color' => 'Color', 'image' => 'Image(s)'], $fields['background_style']['choices']);
		$this->assertEquals('color', $fields['background_style']['default_value']);
		$this->assertEquals('horizontal', $fields['background_style']['layout']);
		$validated_fields++;

		// Validate Background Images Field and count it
		$validated_subfields = 0;
		$expected_number_of_subfields = 1;

		$this->assertEquals('repeater', $fields['background_images']['type']);
		$this->assertEquals('Background Images', $fields['background_images']['label']);
		$this->assertNotNull($fields['background_images']['instructions']);
		$this->assertEquals($fields['background_style']['key'],
							$fields['background_images']['conditional_logic'][0][0]['field'],
							'Conditional logic field for Background Images is NOT Background Style field.');
		$this->assertEquals('image', $fields['background_images']['conditional_logic'][0][0]['value']);
		$this->assertEquals('table', $fields['background_images']['layout']);
		$this->assertEquals('Add Row', $fields['background_images']['button_label']);

		// Image Subfield (Background Images Field)
		$this->assertEquals('image', $fields['background_images']['sub_fields'][0]['type']);
		$this->assertEquals('Image', $fields['background_images']['sub_fields'][0]['label']);
		$this->assertEquals('1', $fields['background_images']['sub_fields'][0]['required']);
		$this->assertEquals('id', $fields['background_images']['sub_fields'][0]['return_format']);
		$this->assertEquals('thumbnail', $fields['background_images']['sub_fields'][0]['preview_size']);
		$this->assertEquals('all', $fields['background_images']['sub_fields'][0]['library']);
		$validated_subfields++;

		$this->assertEquals($expected_number_of_subfields, count($fields['background_images']['sub_fields']));
		$this->assertEquals($expected_number_of_subfields, $validated_subfields);
		$validated_fields++;

		// Validate Background Color Field and count it
		$this->assertEquals('color_picker', $fields['background_color']['type']);
		$this->assertEquals('Background Color', $fields['background_color']['label']);
		$this->assertEquals('1', $fields['background_color']['required']);
		$this->assertEquals($fields['background_style']['key'],
			$fields['background_color']['conditional_logic'][0][0]['field'],
			'Conditional logic field for Background Color is NOT Background Style field.');
		$this->assertEquals('color', $fields['background_color']['conditional_logic'][0][0]['value']);
		$this->assertEquals('#EEECEA', $fields['background_color']['default_value']);
		$validated_fields++;

		// Validate Button Custom Styles Field and count it
		$this->assertEquals('text', $fields['button_styles']['type']);
		$this->assertEquals('Button Custom Styles', $fields['button_styles']['label']);
		$this->assertEquals('0', $fields['button_styles']['required']);
		$this->assertEquals('200', $fields['button_styles']['maxlength']);
		$this->assertEquals('0', $fields['button_styles']['readonly']);
		$this->assertEquals('0', $fields['button_styles']['disabled']);
		$validated_fields++;

		// Validate Field Group Location Settings and Count
		$locations = array();
		foreach(acf_get_field_groups() as $group){
			// retrieve location for current test group
			if ($group['key'] == $test_group){
				$locations = $group['location'];
			}
		}

		$this->assertEquals(1, count($locations));
		$this->assertEquals(1, count($locations[0]));
		$this->assertEquals('post_type', $locations[0][0]['param']);
		$this->assertEquals('==', $locations[0][0]['operator']);
		$this->assertEquals(sprintf('%s--cta', \FB_Themes\Core::config('prefix')), $locations[0][0]['value']);

		// Make sure we had the expected number of fields...
		$this->assertEquals($expected_number_of_fields, count($fields), 'CTA post type in the flickerbox-themes plugin has wrong number of custom fields');

		// .. and that we validated them all
		$this->assertEquals($expected_number_of_fields, $validated_fields, 'Incorrect number of custom fields validated for CTA post type in flickerbox-themes plugin.');
	}

	/**
	 * Confirm CTA global settings custom fields (used for setting default and homepage CTAs)
	 *
	 * JSON source located at /flickerbox-themes/data/acf/acf-cta-global-settings.json
	 *
	 * @requires function acf_get_fields
	 */
	function test_cta_setting_custom_fields() {
		$test_group = 'group_cta_global_settings';
		$fields = array();
		$validated_fields = 0;
		$expected_number_of_fields = 2;

		// Retrieve CTA edit custom fields and organize for testing
		foreach(acf_get_fields($test_group) as $field){
			$fields[$field['name']] = $field;
		}

		// Validate Homepage CTA Setting Field and count it
		$this->assertEquals('relationship', $fields['homepage_cta']['type']);
		$this->assertEquals('Homepage CTA', $fields['homepage_cta']['label']);
		$this->assertNotNull($fields['homepage_cta']['instructions']);
		$this->assertEquals('0', $fields['homepage_cta']['required']);
		$this->assertEquals([sprintf('%s--cta', \FB_Themes\Core::config('prefix'))], $fields['homepage_cta']['post_type']);
		$this->assertEquals(['search'], $fields['homepage_cta']['filters']);
		$this->assertEquals('0', $fields['homepage_cta']['min']);
		$this->assertEquals('1', $fields['homepage_cta']['max']);
		$this->assertEquals('object', $fields['homepage_cta']['return_format']);
		$validated_fields++;

		// Validate Global Default CTA Setting Field and count it
		$this->assertEquals('relationship', $fields['default_cta']['type']);
		$this->assertEquals('Default Post Page CTA', $fields['default_cta']['label']);
		$this->assertNotNull($fields['default_cta']['instructions']);
		$this->assertEquals('1', $fields['default_cta']['required']);
		$this->assertEquals([sprintf('%s--cta', \FB_Themes\Core::config('prefix'))], $fields['default_cta']['post_type']);
		$this->assertEquals(['search'], $fields['default_cta']['filters']);
		$this->assertEquals('1', $fields['default_cta']['min']);
		$this->assertEquals('1', $fields['default_cta']['max']);
		$this->assertEquals('object', $fields['default_cta']['return_format']);
		$validated_fields++;

		// Validate Field Group Location Settings and Count
		$locations = array();
		foreach(acf_get_field_groups() as $group){
			// retrieve location for current test group
			if ($group['key'] == $test_group){
				$locations = $group['location'];
			}
		}

		$this->assertEquals(1, count($locations));
		$this->assertEquals(1, count($locations[0]));
		$this->assertEquals('options_page', $locations[0][0]['param']);
		$this->assertEquals('==', $locations[0][0]['operator']);
		$this->assertEquals('-settings', $locations[0][0]['value']);

		// Make sure we had the expected number of fields...
		$this->assertEquals($expected_number_of_fields, count($fields), 'CTA settings in the flickerbox-themes plugin has wrong number of custom fields');

		// .. and that we validated them all
		$this->assertEquals($expected_number_of_fields, $validated_fields, 'Incorrect number of custom fields validated for CTA settings in flickerbox-themes plugin.');
	}

	/**
	 * Confirm CTA relationship custom fields (used for pairing CTAs to posts)
	 *
	 * JSON source located at /flickerbox-themes/data/acf/acf-cta-post-relationship.json
	 *
	 * @requires function acf_get_fields
	 */
	function test_cta_relationship_custom_fields() {
		$test_group = 'group_call_to_action_relationship';
		$fields = array();
		$validated_fields = 0;
		$expected_number_of_fields = 1;

		// Retrieve CTA edit custom fields and organize for testing
		foreach(acf_get_fields($test_group) as $field){
			$fields[$field['name']] = $field;
		}

		// Validate CTA Relationship Setting Field and count it
		$this->assertEquals('relationship', $fields['call_to_action']['type']);
		$this->assertEquals('Call To Action', $fields['call_to_action']['label']);
		$this->assertNotNull($fields['call_to_action']['instructions']);
		$this->assertEquals('0', $fields['call_to_action']['required']);
		$this->assertEquals([sprintf('%s--cta', \FB_Themes\Core::config('prefix'))], $fields['call_to_action']['post_type']);
		$this->assertEquals(['search'], $fields['call_to_action']['filters']);
		$this->assertEquals('0', $fields['call_to_action']['min']);
		$this->assertEquals('1', $fields['call_to_action']['max']);
		$this->assertEquals('object', $fields['call_to_action']['return_format']);
		$validated_fields++;


		// Validate Field Group Location Settings and Count
		$locations = array();
		foreach(acf_get_field_groups() as $group){
			// retrieve location for current test group
			if ($group['key'] == $test_group){
				$locations = $group['location'];
			}
		}

		$this->assertEquals(1, count($locations));
		$this->assertEquals(1, count($locations[0]));
		$this->assertEquals('post_type', $locations[0][0]['param']);
		$this->assertEquals('!=', $locations[0][0]['operator']);
		$this->assertEquals(sprintf('%s--cta', \FB_Themes\Core::config('prefix')), $locations[0][0]['value']);

		// Make sure we had the expected number of fields...
		$this->assertEquals($expected_number_of_fields, count($fields), 'CTA relationship in the flickerbox-themes plugin has wrong number of custom fields');

		// .. and that we validated them all
		$this->assertEquals($expected_number_of_fields, $validated_fields, 'Incorrect number of custom fields validated for CTA relationship in flickerbox-themes plugin.');

	}

}

