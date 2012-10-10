<?php

class GhBlog_Model_PostsTest extends PHPUnit_Framework_TestCase {

	public function testGetPostsEmptyList() {

		class_alias('\GhBlog\Model\Posts', 'T1');

		$path = '2012/10_06_test_post3.md';
		$obj = $this->getMock('T1', array('_getFilesFromPath', '_createNewPostObject'), array(2012,10,1));
		$obj->expects($this->any())
		    ->method('_createNewPostObject')
		    ->will($this->returnValue(new \GhBlog\Model\Post()));
		$obj->expects($this->any())
		    ->method('_getFilesFromPath')
		    ->will($this->returnValue(array()));

		$posts = $obj->getList();
		$this->assertTrue(empty($posts));
	}

	public function testGetPostsList() {		
		
		class_alias('\GhBlog\Model\Posts', 'T2');

		$path = '2012/10_06_test_post3.md';
		$obj = $this->getMock('T1', array('_getFilesFromPath', '_createNewPostObject'), array(2012,10,1));
		$obj->expects($this->any())
		    ->method('_createNewPostObject')
		    ->will($this->returnValue(new \GhBlog\Model\Post()));
		$obj->expects($this->any())
		    ->method('_getFilesFromPath')
		    ->will($this->returnValue(array('file1', 'file1', 'file1')));

		$posts = $obj->getList();
		$this->assertTrue($posts[0] instanceof \GhBlog\Model\Post);
		$this->assertTrue($posts[2] instanceof \GhBlog\Model\Post);
	}

	public function testGetPostsNextList() {

		$obj = new \GhBlog\Model\Posts("2012","08",1);
		$next = $obj->getNext();
		$this->assertEquals("2012", $next->getYear());
		$this->assertEquals("12", $next->getMounth());
		$this->assertEquals(1, $next->getPage());

		$next = $next->getNext();
		$this->assertEquals("2014", $next->getYear());
		$this->assertEquals("02", $next->getMounth());
		$this->assertEquals(1, $next->getPage());

		$next = $next->getNext();
		$this->assertEquals("2014", $next->getYear());
		$this->assertEquals("07", $next->getMounth());
		$this->assertEquals(1, $next->getPage());	
	}

}
