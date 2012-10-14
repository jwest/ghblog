<?php

class GhBlog_Api_FilesTest extends PHPUnit_Framework_TestCase {

	public function testListDirectories() {
		$path = 'tests/data/posts';
		$obj = new \GhBlog\Api\Files(array('path' => $path));
		$obj->listFiles($path);
		$obj->listDirs();
		$this->assertEquals('test', $obj->getContent('testContent.md'));
		$obj->putContent('testContent.md', 'test');
		$this->assertEquals('test', $obj->getContent('testContent.md'));
	}

}