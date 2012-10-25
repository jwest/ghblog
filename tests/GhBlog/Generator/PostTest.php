<?php

class GhBlog_Generator_PostTest extends PHPUnit_Framework_TestCase {

	public function testGetPostsList() {
		$model = $this->_preparePostObj('GP1');
		$obj = new \GhBlog\Generator\Post($this->_getTwig(), $model);
		$this->assertTrue($obj->getPost() instanceof \GhBlog\Model\Post);
	}

	public function testGeneratePostPage() {
		$model = $this->_preparePostObj('GP2');
		$obj = new \GhBlog\Generator\Post($this->_getTwig(), $model);
		$genContent = $obj->generatePage();
		$this->assertEquals(file_get_contents('tests/data/output/2012/10/06_test_post3.html'), $genContent);
	}

	private function _preparePostObj($alias) {
		class_alias('\GhBlog\Model\Post', $alias);

		$path = 'posts/2012/10/06_test_post3.md';
		$obj = $this->getMock($alias, array('_loadFromFile'));
		$obj->expects($this->any())
        	->method('_loadFromFile')
		    ->will($this->returnValue("title: first post\ndate: 2012-11-09 10:32:52\ntags: test1, test2, test3\n---\ntest"));		
		$obj->loadFromFile($path);
		return $obj;	
	}

	private function _getTwig() {
		return new Twig_Environment(new Twig_Loader_Filesystem('data/templates'));
	}
}
