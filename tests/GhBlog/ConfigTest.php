<?php

use GhBlog\Config;

class GhBlog_ConfigTest extends PHPUnit_Framework_TestCase {

	public function testGetFromLoadFile() {
		$this->assertEquals('github', Config::app()->get('api.provider'));
		$this->assertEquals('jwest/git-blog', Config::app()->get('api.provider.repo'));
		$this->assertEquals('data/template', Config::app()->get('path.template'));
		$this->assertEquals(array(1,2,3,4), Config::app()->get('arr.test'));
	}

	public function testSipmleGetSet() {
		Config::app()->set('test', 'test1');
		$this->assertEquals('test1', Config::app()->get('test'));
		Config::app()->set('path.template', 'test');
		$this->assertEquals('test', Config::app()->get('path.template'));
	}

	public function testValueNotDeclared() {
		try {
			Config::app()->get('notExists');
			$this->assertTrue(false);
		} catch (Exception $e) {
			$this->assertTrue(true);
			$this->assertEquals('Config value "notExists" not defined', $e->getMessage());
		}
	}

}