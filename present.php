<?php
class Tests_Plugins_present extends WP_UnitTestCase {
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