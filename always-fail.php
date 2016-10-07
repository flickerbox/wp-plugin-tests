<?php
/**
 * For demonstration purposes this test always fails
 *
 * @group flickerbox
 */
class Tests_Plugins_AlwaysFail extends WP_UnitTestCase {

	function test_always_fails() {
		$this->assertEquals(true, false);
	}

}