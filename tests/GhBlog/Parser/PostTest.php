<?php

class GhBlog_Parser_PostTest extends PHPUnit_Framework_TestCase {

	public function testParseDescriptionFirst() {
		$obj = new \GhBlog\Parser\Post($this->_firstTest);
		$post = $obj->parse();
		$this->assertEquals('first post', $post['title']);
		$this->assertEquals('1352453572', $post['date']);
		$this->assertEquals(array('php', 'git', 'test'), $post['tags']);
		$this->assertEquals('<p>test post first</p>'."\n", $post['content']);
	}

	public function testParseBadTimestamp() {
		$obj = new \GhBlog\Parser\Post($this->_secondTest);
		try {
			$post = $obj->parse();
			$this->assertTrue(false);
		} catch(\GhBlog\Parser\Exception $e) {
			$this->assertTrue(true);
			$this->assertEquals('Date is invalid', $e->getMessage());
		}		
	}

	public function testWithoutTitle() {
		$obj = new \GhBlog\Parser\Post($this->_withoutTitle);
		try {
			$post = $obj->parse();
			$this->assertTrue(false);
		} catch(\GhBlog\Parser\Exception $e) {
			$this->assertTrue(true);
			$this->assertEquals('Title must exists', $e->getMessage());
		}		
	}

	public function testParseBadContent() {
		$obj = new \GhBlog\Parser\Post($this->_invalidContent);
		try {
			$post = $obj->parse();
			$this->assertTrue(false);
		} catch(\GhBlog\Parser\Exception $e) {
			$this->assertTrue(true);
			$this->assertEquals('Post file is invalid', $e->getMessage());
		}		
	}

	protected $_firstTest = 'title: first post
date: 2012-11-09 10:32:52
tags: php, git, test
---
test post first';

	protected $_secondTest = 'title: first post!
date: 2012-13-05 8:34:12
tags: php, git, test
---
test post';

	protected $_withoutTitle = 'date: 2012-11-05 8:34:12
tags: php, git, test
---
test without title';

	protected $_invalidContent = 'test';

}