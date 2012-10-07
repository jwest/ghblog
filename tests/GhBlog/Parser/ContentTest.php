<?php

class GhBlog_Parser_ContentTest extends PHPUnit_Framework_TestCase {

	public function testParseMarkup() {
		$obj = new \GhBlog\Parser\Content('*title*');
		$this->assertEquals('<p><em>title</em></p>'."\n", $obj->parse());
	}

}