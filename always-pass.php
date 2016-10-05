<?php
/**
 * This test allows you to validate local setup of test environment is successful by performing a test that always passes
 */
class Tests_Plugins_AlwaysPass extends WP_UnitTestCase {
	protected $user_id;

	function setUp() {
		parent::setUp();

		$this->user_id = self::factory()->user->create( array(
			'role' => 'administrator'
		) );

		wp_set_current_user( $this->user_id );
	}

	function test_always_passes() {
		$this->assertEquals(true, true);
	}
}