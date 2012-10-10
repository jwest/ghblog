<?php

class GhBlog_Api_FilesTest extends PHPUnit_Framework_TestCase {

	public function testListDirectories() {
		$path = 'tests/data/posts';
		$obj = new \GhBlog\Api\Files($path);
		$obj->listFiles($path);
		$obj->listDirs($path);
		$obj->getContent($path);
		$obj->putContent($path, $content);
	}

}