<?php
/**
 * This test allows you to validate local setup of test environment is successful by performing a test that always passes
 *
 * @group flickerbox
 * @group fb-setup
 */
class Tests_Plugins_AlwaysPass extends WP_UnitTestCase {

	function test_always_passes() {
		$this->assertEquals(true, true);
	}

}