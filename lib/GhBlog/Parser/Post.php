<?php

class GhBlog_Parser_Post implements GhBlog_Parser {

	protected $_rawContent;
	protected $_container = array();

	public function __construct($rawContent) {
		$this->_rawContent = $rawContent;
	}

	public function parse() {
		$description = $this->_getDescription();
		$this->_container = $this->_parseDescription($description);
		$this->_container = $this->_parseValues($this->_container);	
		$this->_validationContainer();	
	}

	protected function _parseValues($data) {
		$data['title'] = trim($data['title']);
		$data['date'] = $this->_parseDate($data['date']);
		$data['tags'] = $this->_parseTags($data['tags']);
		$data['content'] = $this->_parseContent($this->_rawContent);
		return $data;
	}

	protected function _getDescription() {
		$contentParts = explode('---', $this->_rawContent);
		if (count($contentParts) < 2)
			throw new GhBlog_Parser_Exception('Post file is invalid');		
		$description = $contentParts[0];
		unset($contentParts[0]);
		$this->_rawContent = implode('---', $contentParts);		
		return $description;
	}

	protected function _parseContent($content) {
		$markup = new GhBlog_Parser_Markup($content);
		$markup->parse();
		return $markup->content;
	}

	protected function _parseDescription($description) {
		preg_match_all('/^([a-z0-9]+):\ *(.+)$/im', $description, $result);
		return array_combine($result[1], $result[2]);		
	}

	protected function _parseDate($date) {
		return strtotime($date);
	}

	protected function _parseTags($tags) {
		$tags = explode(',', $tags);
		foreach($tags as &$tag)
			$tag = trim($tag);
		return $tags;
	}

	protected function _validationContainer() {
		if (!isset($this->_container['title']) || empty($this->_container['title'])) 
			throw new GhBlog_Parser_Exception('Title must exists');
		if (!isset($this->_container['date']) || !$this->_container['date'])
			throw new GhBlog_Parser_Exception('Date is invalid');
		if (!isset($this->_container['tags']) || !is_array($this->_container['tags']))
			throw new GhBlog_Parser_Exception('Tags must exists');
		if (!isset($this->_container['content']) || empty($this->_container['content'])) 
			throw new GhBlog_Parser_Exception('Content must exists');
	}

	public function __get($name) {
		return isset($this->_container[$name]) ? $this->_container[$name] : null;
	}

}