<?php

class GhBlog_Api_GithubTest extends PHPUnit_Framework_TestCase {

	public function testGetRequestPlainText() {

		class_alias('\GhBlog\Api\Github', 'A1');

		$obj = $this->getMock('A1', array('_request'));
        $obj->expects($this->any())
        	->method('_request')
            ->will($this->returnValue((object)array('encoding' => 'plain', 'content' => 'test')));

		$content = $obj->getFileContent('');
		$this->assertEquals('test', $content);
	}

	public function testGetRequestBase64() {

		class_alias('\GhBlog\Api\Github', 'A2');

		$obj = $this->getMock('A2', array('_request'));
        $obj->expects($this->any())
        	->method('_request')
            ->will($this->returnValue((object)array('encoding' => 'base64', 'content' => 'dGVzdA==')));

		$content = $obj->getFileContent('');
		$this->assertEquals('test', $content);
	}

	public function testGetRequestErrorNotFound() {

		class_alias('\GhBlog\Api\Github', 'A3');

		$obj = $this->getMock('A3', array('_request'));
        $obj->expects($this->any())
        	->method('_request')
            ->will($this->returnValue((object)array('message' => 'Not Found')));

        try {
        	$obj->getFileContent('');
        	$this->assertTrue(false);	
        } catch(\GhBlog\Api\Exception $e) {
        	$this->assertTrue(true);
        	$this->assertEquals('Object not found in Github Api', $e->getMessage());
        }
	}

}