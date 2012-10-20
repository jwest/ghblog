<?php

class GhBlog_Api_FilesTest extends PHPUnit_Framework_TestCase {

	public function testListDirectories() {
		$path = 'tests/data/posts';
		$obj = new \GhBlog\Api\Files(array('path' => $path));		
		$dirs = $obj->listDirs('2012');
		$this->assertEquals('2012/03', $dirs[0]);
		$this->assertEquals('2012/08', $dirs[1]);
		$this->assertEquals('2012/12', $dirs[2]);
		$dirs = $obj->listDirs('2012/04');
		$this->assertEmpty($dirs);


		$obj->listFiles($path);
		$this->assertEquals('test', $obj->getContent('testContent.md'));
		$obj->putContent('testContent.md', 'test');
		$this->assertEquals('test', $obj->getContent('testContent.md'));
	}

	public function testListFiles() {
		$path = 'tests/data/posts';
		$obj = new \GhBlog\Api\Files(array('path' => $path));		
		$files = $obj->listFiles('2012/08');
		$this->assertEquals('2012/08/test_post_10.md', $files[0]);
		$this->assertEquals('2012/08/test_post_6.md', $files[1]);
		$this->assertEquals('2012/08/test_post_8.md', $files[2]);
		$this->assertEquals('2012/08/test_post_9.md', $files[3]);
		$files = $obj->listFiles('2012/04');
		$this->assertEmpty($files);
	}

	public function testPutAndGetAndRemoveContent() {
		$path = 'tests/data';
		$filename = time().'_test.md';
		$obj = new \GhBlog\Api\Files(array('path' => $path));
		$obj->putContent($filename, 'test');
		$content = $obj->getContent($filename);
		$this->assertEquals('test', $content);
		$obj->removeContent($filename);
		try {
			$obj->getContent($filename);
			$this->assertTrue(false);
		} catch(\GhBlog\Api\Exception $e) {
			$this->assertTrue(true);
			$this->assertEquals('File not exists', $e->getMessage());
		}
	}

}