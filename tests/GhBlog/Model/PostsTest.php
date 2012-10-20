<?php

class GhBlog_Model_PostsTest extends PHPUnit_Framework_TestCase {

	public function testGetPostsEmptyList() {

		$obj = new \GhBlog\Model\Posts("2012","10",1);
		$posts = $obj->getList();
		$this->assertTrue(empty($posts));
	}

	public function testGetPostsList() {		
		
		$obj = new \GhBlog\Model\Posts("2014","07");
		$posts = $obj->getList();
		$this->assertTrue($posts[0] instanceof \GhBlog\Model\Post);
		$this->assertTrue($posts[1] instanceof \GhBlog\Model\Post);
	}

	public function testGetPostsNextList() {

		$obj = new \GhBlog\Model\Posts("2012","03",1);
		$obj = $this->_getNext($obj, "2012", "08", 1);
		$obj = $this->_getNext($obj, "2012", "08", 2);	
		$obj = $this->_getNext($obj, "2012", "12", 1);
		$obj = $this->_getNext($obj, "2014", "02", 1);
		$obj = $this->_getNext($obj, "2014", "04", 1);
		$obj = $this->_getNext($obj, "2014", "07", 1);
	}

	public function testGetPostsPrevList() {

		$obj = new \GhBlog\Model\Posts("2014","10",1);
		$obj = $this->_getPrev($obj, "2014", "07", 1);
		$obj = $this->_getPrev($obj, "2014", "04", 1);
		$obj = $this->_getPrev($obj, "2014", "02", 1);
		$obj = $this->_getPrev($obj, "2012", "12", 1);
		$obj = $this->_getPrev($obj, "2012", "08", 2);
		$obj = $this->_getPrev($obj, "2012", "08", 1);
		$obj = $this->_getPrev($obj, "2012", "03", 1);
	}

	public function testGetNewPost() {
		$obj = new \GhBlog\Model\Posts();
		$this->_objAssert($obj, "2014", "10", 1);
	}

	private function _getNext($obj, $year, $mounth, $page) {
		$obj = $obj->getNext();
		$this->_objAssert($obj, $year, $mounth, $page);		
		return $obj;
	}

	private function _getPrev($obj, $year, $mounth, $page) {
		$obj = $obj->getPrev();
		$this->_objAssert($obj, $year, $mounth, $page);		
		return $obj;
	}

	private function _objAssert($obj, $year, $mounth, $page) {
		$this->assertEquals($year, $obj->getYear());
		$this->assertEquals($mounth, $obj->getMounth());
		$this->assertEquals($page, $obj->getPage());	
	}

}
