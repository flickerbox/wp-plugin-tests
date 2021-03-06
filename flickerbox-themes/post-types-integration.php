<?php
/**
 * Performs unit tests for the flickerbox-themes plugin post types
 *
 * @group flickerbox
 * @group flickerbox-integration
 * @group flickerbox-themes
 * @group flickerbox-themes-integration
 */


class Tests_Plugins_FlickerboxThemesIntegration extends WP_UnitTestCase {

	public static $editor_user_id;
	public static $author_user_id;

	// Setup
	function setUp() {
		parent::setUp();
	}

	// Teardown
	function tearDown() {
		parent::tearDown();
	}

	/**
	 * Confirm we can create a post using the CTA post type
	 */
	function test_cta_post_creation(){

		// Create and validate test CTA post
		$test_object = get_post_type_object(sprintf('%s--cta', \FB_Themes\Core::config('prefix')));
		$cta = self::factory()->post->create_and_get( array('post_type' => $test_object->name) );

		$this->assertInstanceOf('WP_Post', $cta);
		$this->assertEquals(sprintf('%s--cta', \FB_Themes\Core::config('prefix')), $cta->post_type);

		// Get CTA post fields for updating
		$test_group = 'group_cta_edit';
		$fields = array();

		// Retrieve CTA edit custom fields and organize for testing
		foreach(acf_get_fields($test_group) as $field){
			$fields[$field['name']] = $field['key'];
		}

		// Confirm all required fields are present
		$this->assertTrue(array_key_exists('heading', $fields));
		$this->assertTrue(array_key_exists('message_text', $fields));
		$this->assertTrue(array_key_exists('button_text', $fields));
		$this->assertTrue(array_key_exists('button_url', $fields));
		$this->assertTrue(array_key_exists('button_target', $fields));
		$this->assertTrue(array_key_exists('message_color', $fields));
		$this->assertTrue(array_key_exists('message_background', $fields));
		$this->assertTrue(array_key_exists('border_color', $fields));
		$this->assertTrue(array_key_exists('background_style', $fields));
		$this->assertTrue(array_key_exists('background_images', $fields));
		$this->assertTrue(array_key_exists('background_color', $fields));
		$this->assertTrue(array_key_exists('button_styles', $fields));


		// Update field values
		update_field($fields['heading'], array('text' => 'This! Is! Awesome!', 'size' => 'h3', 'align' => 'right'), $cta->ID);
		update_field($fields['message_text'], 'The power of this CTA compells you.', $cta->ID);
		update_field($fields['button_text'], 'Click Me!', $cta->ID);
		update_field($fields['button_url'], 'https://www.somedomain.edu', $cta->ID);
		update_field($fields['button_target'], '_self', $cta->ID);
		update_field($fields['message_color'], '#123456', $cta->ID);
		update_field($fields['message_background'], '#ABCDEFG', $cta->ID);
		update_field($fields['border_color'], '#987654', $cta->ID);
		update_field($fields['background_style'], 'color', $cta->ID);
		update_field($fields['background_color'], '#ZYXWVU', $cta->ID);

		$saved_values = get_fields($cta->ID);

		// Validate saved values
		$this->assertEquals('h3', $saved_values['heading']['size']);
		$this->assertEquals('right', $saved_values['heading']['align']);
		$this->assertEquals('This! Is! Awesome!', $saved_values['heading']['text']);
		$this->assertEquals('The power of this CTA compells you.', $saved_values['message_text']);
		$this->assertEquals('Click Me!', $saved_values['button_text']);
		$this->assertEquals('https://www.somedomain.edu', $saved_values['button_url']);
		$this->assertEquals('_self', $saved_values['button_target']);
		$this->assertEquals('#123456', $saved_values['message_color']);
		$this->assertEquals('#ABCDEFG', $saved_values['message_background']);
		$this->assertEquals('#987654', $saved_values['border_color']);
		$this->assertEquals('color', $saved_values['background_style']);
		$this->assertEquals('#ZYXWVU', $saved_values['background_color']);

		// Upload an image and get it's attachment url
		$filename = ( DIR_TESTDATA.'/images/waffles.jpg' );
		$contents = file_get_contents($filename);
		$upload = wp_upload_bits(basename($filename), null, $contents);
		$this->assertTrue( empty($upload['error']) );
		$image_id = $this->_make_attachment($upload);
		$attachment_url = @wp_get_attachment_image_url($image_id, 'fullsize');

		// Change background style to image and validate change
		update_field($fields['background_style'], 'image', $cta->ID);
		$this->assertEquals('image', get_field('background_style', $cta->ID));

		// Set background image to uploaded image and validate
		update_field('background_images', array('images_0' => $image_id), $cta->ID);
		$background_images = get_field('background_images', $cta->ID);
		$background_url = @wp_get_attachment_image_url($background_images['images_0'], 'fullsize');
		$this->assertEquals($attachment_url, $background_url);
	}

	/**
	 * Confirm we can create a relationship between a CTAs post and a post/page post
	 */
	function test_cta_post_relationship(){

		// Create and validate test CTA post
		$test_object = get_post_type_object(sprintf('%s--cta', \FB_Themes\Core::config('prefix')));
		$cta = self::factory()->post->create_and_get( array('post_type' => $test_object->name) );
		$this->assertInstanceOf('WP_Post', $cta);
		$this->assertEquals(sprintf('%s--cta', \FB_Themes\Core::config('prefix')), $cta->post_type);

		// Create and validate a new page
		$post = self::factory()->post->create_and_get( array('post_type' => 'page') );
		$this->assertInstanceOf('WP_Post', $post);
		$this->assertEquals('page', $post->post_type);

		// Get CTA relationship fields for updating
		$test_group = 'group_call_to_action_relationship';
		$fields = array();

		// Retrieve CTA edit custom fields and organize for testing
		foreach(acf_get_fields($test_group) as $field){
			$fields[$field['name']] = $field['key'];
		}

		// Confirm all required fields are present (Currently just 1)
		$this->assertTrue(array_key_exists('call_to_action', $fields));

		// Verify the post doesn't have a CTA
		$this->assertEquals('', get_field('call_to_action', $post->ID));

		// Set post's CTA to the test CTA
		update_field($fields['call_to_action'], $cta->ID, $post->ID);

		// Validate relationship between CTA and page was successful
		$assigned_cta = get_field('call_to_action', $post->ID);
		$this->assertEquals($cta->ID, $assigned_cta[0]->ID);
	}

}

