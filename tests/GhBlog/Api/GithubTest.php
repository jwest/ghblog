<?php

class GhBlog_Api_GithubTest extends PHPUnit_Framework_TestCase {

	public function testGetRequestPlainText() {

		class_alias('\GhBlog\Api\Github', 'A1');

		$obj = $this->getMock('A1', array('_request'));
        $obj->expects($this->any())
        	->method('_request')
            ->will($this->returnValue('{"encoding":"plain", "content":"test"}'));

		$content = $obj->getContent('');
		$this->assertEquals('test', $content);
	}

	public function testGetRequestBase64() {

		class_alias('\GhBlog\Api\Github', 'A2');

		$obj = $this->getMock('A2', array('_request'));
        $obj->expects($this->any())
        	->method('_request')
            ->will($this->returnValue('{"encoding":"base64", "content":"dGVzdA=="}'));

		$content = $obj->getContent('');
		$this->assertEquals('test', $content);
	}

	public function testGetRequestErrorNotFound() {

		class_alias('\GhBlog\Api\Github', 'A3');

		$obj = $this->getMock('A3', array('_request'));
        $obj->expects($this->any())
        	->method('_request')
            ->will($this->returnValue('{"message":"Not Found"}'));

        try {
        	$obj->getContent('');
        	$this->assertTrue(false);	
        } catch(\GhBlog\Api\Exception $e) {
        	$this->assertTrue(true);
        	$this->assertEquals('Object not found in Github Api', $e->getMessage());
        }
	}

	public function testNotImplementedMethods() {
		$this->_tryNotImplementedMethods('putContent');
		$this->_tryNotImplementedMethods('removeContent');
		$this->_tryNotImplementedMethods('listFiles');
		$this->_tryNotImplementedMethods('listDirs');
	}

	private function _tryNotImplementedMethods($method) {
		try {
			$obj = new \GhBlog\Api\Github();
        	$obj->$method('', '', '');
        	$this->assertTrue(false);
        } catch(\GhBlog\Api\Exception $e) {
        	$this->assertTrue(true);
        	$this->assertEquals('Not implemented', $e->getMessage());
        }
	}

}