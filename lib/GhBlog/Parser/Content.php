<?php

namespace GhBlog\Parser;

class Content implements IParser {

	protected $_content;

	public function __construct($content) {
		$this->_content = $content;
	}

	public function parse(array $params = null) {
		$markdownParser = new \dflydev\markdown\MarkdownParser();
		return $markdownParser->transformMarkdown($this->_content);
	}

}