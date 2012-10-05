<?php

class GhBlog_Parser_Markup implements GhBlog_Parser {

	protected $_rawContent;
	protected $_content;

	public function __construct($rawContent) {
		$this->_rawContent = $rawContent;
	}

	public function parse() {
		$markdownParser = new dflydev\markdown\MarkdownParser();
		$this->_content = $markdownParser->transformMarkdown($this->_rawContent);
	}

	public function __get($name) {
		return $this->_content;
	}

}