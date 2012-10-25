<?php

class GhBlog_Generator_PostsTest extends PHPUnit_Framework_TestCase {

	public function testGetPostsList() {
		$modelList = new \GhBlog\Model\Posts();
		$obj = new \GhBlog\Generator\Posts($this->_getTwig(), $modelList);
		$this->assertTrue($obj->getList() instanceof \GhBlog\Model\Posts);
	}

	public function testIteratePostsList() {
		$modelList = new \GhBlog\Model\Posts();
		$obj = new \GhBlog\Generator\Posts($this->_getTwig(), $modelList);
		$genContent = $obj->generatePage();
		$this->assertEquals(file_get_contents('tests/data/output/index.html'), $genContent);
	}

	public function testPostGenerators() {
		$modelList = new \GhBlog\Model\Posts();
		$obj = new \GhBlog\Generator\Posts($this->_getTwig(), $modelList);
		$posts = $obj->getPosts();
		$this->assertTrue($posts[0] instanceof \GhBlog\Generator\Post);
		
	}

	private function _getTwig() {
		return new Twig_Environment(new Twig_Loader_Filesystem('data/templates'));
	}

}
