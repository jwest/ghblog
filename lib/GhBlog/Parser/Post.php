<?php

namespace GhBlog\Parser;

class Post implements IParser {

	protected $_content;

	public function __construct($content) {
		$this->_content = $content;
	}

	public function parse(array $params = null) {
		$description = $this->_getDescription();
		$items = $this->_parseDescription($description);
		$this->_validationExists($items);
		$items = $this->_parseValues($items);	
		$this->_validationValues($items);
		return $items;
	}

	protected function _getDescription() {
		$contentParts = explode('---', $this->_content);
		if (count($contentParts) < 2)
			throw new Exception('Post file is invalid');		
		$description = $contentParts[0];
		unset($contentParts[0]);
		$this->_content = implode('---', $contentParts);		
		return $description;
	}

	protected function _parseDescription($description) {
		preg_match_all('/^([a-z0-9]+):\ *(.+)$/im', $description, $result);
		return array_combine($result[1], $result[2]);		
	}

	protected function _parseValues($data) {
		$data['title'] = trim($data['title']);
		$data['date'] = $this->_parseDate($data['date']);
		$data['tags'] = $this->_parseTags($data['tags']);
		$data['content'] = $this->_parseContent($this->_content);
		return $data;
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

	protected function _parseContent($content) {
		$markup = new Content($content);		
		return $markup->parse();
	}

	protected function _validationExists($items) {
		if (!isset($items['title'])) 
			throw new Exception('Title must exists');
		if (!isset($items['date']))
			throw new Exception('Date must exists');
		if (!isset($items['tags']))
			throw new Exception('Tags must exists');
	}

	protected function _validationValues($items) {
		if (empty($items['title'])) 
			throw new Exception('Title must exists');
		if (!$items['date'])
			throw new Exception('Date is invalid');
		if (!is_array($items['tags']))
			throw new Exception('Tags must exists');
		if (empty($items['content'])) 
			throw new Exception('Content must exists');
	}

}