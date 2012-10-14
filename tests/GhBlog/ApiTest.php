<?php

use GhBlog\Api;

class GhBlog_ApiTest extends PHPUnit_Framework_TestCase {

	public function testGetGithub() {
		$api = Api::factory('Github');
		$this->assertTrue($api instanceof \GhBlog\Api\Github);
	}

	public function testGetFiels() {
		$api = Api::factory('Files');
		$this->assertTrue($api instanceof \GhBlog\Api\Files);
	}

	public function testGetNotExists() {
		try
		{
			$api = Api::factory('NotExists');
			$this->assertTrue(false);
		}
		catch(\GhBlog\Api\Exception $e)
		{
			$this->assertTrue(true);
		}
	}

}