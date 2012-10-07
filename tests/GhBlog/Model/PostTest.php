<?php

class GhBlog_Model_PostTest extends PHPUnit_Framework_TestCase {

	public function testGetPost() {

		class_alias('\GhBlog\Model\Post', 'P1');

		$obj = $this->getMock('P1', array('_loadFromApi', '_loadFromData'), array('2012/10_06_test_post3.md'));
		$obj->expects($this->any())
			->method('_loadFromData')
			->will($this->returnValue(false));
        $obj->expects($this->any())
        	->method('_loadFromApi')
            ->will($this->returnValue('title: first post
date: 2012-11-09 10:32:52
tags: test1, test2, test3
---
test'));

		$obj->load();
		$this->assertEquals('first post', $obj->getTitle());
		$this->assertEquals(array('test1', 'test2', 'test3'), $obj->getTags());
		$this->assertEquals('2012-11-09 10:32:52', $obj->getDate('Y-m-d H:i:s'));
		$this->assertEquals('<p>test</p>'."\n", $obj->getContent());
	}

	public function testGetPost2() {

		class_alias('\GhBlog\Model\Post', 'P2');

		$obj = $this->getMock('P2', array('_loadFromApi', '_loadFromData'), array('2012/10_06_test_post3.md'));
		$obj->expects($this->any())
			->method('_loadFromApi')
			->will($this->returnValue(false));
        $obj->expects($this->any())
        	->method('_loadFromData')
            ->will($this->returnValue('title: first post
date: 2012-11-09 10:32:52
tags: test1, test2, test3
---
test'));

		$obj->load();
		$this->assertEquals('first post', $obj->getTitle());
		$this->assertEquals(array('test1', 'test2', 'test3'), $obj->getTags());
		$this->assertEquals('2012-11-09 10:32:52', $obj->getDate('Y-m-d H:i:s'));
		$this->assertEquals('<p>test</p>'."\n", $obj->getContent());
	}

}