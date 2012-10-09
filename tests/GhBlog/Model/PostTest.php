<?php

class GhBlog_Model_PostTest extends PHPUnit_Framework_TestCase {

	public function testGetPost() {

		class_alias('\GhBlog\Model\Post', 'P1');

		$path = '2012/10_06_test_post3.md';
		$obj = $this->getMock('P1', array('_loadFromApi', '_loadFromFile'));
		$obj->expects($this->any())
		    ->method('_loadFromFile')
		    ->will($this->returnValue(false));
		$obj->expects($this->any())
        	->method('_loadFromApi')
		    ->will($this->returnValue("title: first post\ndate: 2012-11-09 10:32:52\ntags: test1, test2, test3\n---\ntest"));

		$obj->loadFromApi($path);
		$this->assertEquals('first post', $obj->getTitle());
		$this->assertEquals(array('test1', 'test2', 'test3'), $obj->getTags());
		$this->assertEquals('2012-11-09 10:32:52', $obj->getDate('Y-m-d H:i:s'));
		$this->assertEquals('<p>test</p>'."\n", $obj->getContent());
	}

	public function testGetPost2() {

		class_alias('\GhBlog\Model\Post', 'P2');

		$path = '2012/10_06_test_post3.md';
		$obj = $this->getMock('P2', array('_loadFromApi', '_loadFromFile'));
		$obj->expects($this->any())
		    ->method('_loadFromApi')
		    ->will($this->returnValue(false));
		$obj->expects($this->any())
        	->method('_loadFromFile')
		    ->will($this->returnValue("title: first post\ndate: 2012-11-09 10:32:52\ntags: test1, test2, test3\n---\ntest"));

		$obj->loadFromFile($path);
		$this->assertEquals('first post', $obj->getTitle());
		$this->assertEquals(array('test1', 'test2', 'test3'), $obj->getTags());
		$this->assertEquals('2012-11-09 10:32:52', $obj->getDate('Y-m-d H:i:s'));
		$this->assertEquals('<p>test</p>'."\n", $obj->getContent());
	}

}
