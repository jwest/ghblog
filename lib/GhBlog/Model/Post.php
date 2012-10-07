<?php

namespace GhBlog\Model;

class Post {

	protected $_path;
	protected $_title;
	protected $_tags;
	protected $_timestamp;
	protected $_content;

	protected $_loaded = false;

	public function __construct($path) {
		$this->_path = $path;
	}

	public function isLoaded() {
		return $this->_loaded;
	}

	public function getTitle() {
		return $this->_title;
	}

	public function getTags() {
		return $this->_tags;
	}

	public function getDate($format = 'Y-m-d H:i:s') {
		return date($format, $this->_timestamp);
	}

	public function getContent() {
		return $this->_content;
	}

	public function load() {
		if ($this->isLoaded()) 
			return true;
		$content = $this->_loadFromData();
		if($content === false) {
			$content = $this->_loadFromApi();
			if($content === false)
				return false;
		}
		$this->_parse($content);
		return true;
	}

	protected function _bindValues($values) {
		$this->_title = $values['title'];
		$this->_tags = $values['tags'];
		$this->_timestamp = $values['date'];
		$this->_content = $values['content'];
	}

	protected function _loadFromData() {
		if (file_exists($this->_getFilePath())) {
			$content = file_get_contents($this->_getFilePath());
			return $content;
		}
		return false;
	}

	protected function _loadFromApi() {
		$api = new \GhBlog\Api\Github();
		$content = $api->getFileContent($this->_path);
		$this->_parse($content);
		return $content;
	}

	protected function _getFilePath() {
		return '/'.$this->_path;
	}

	protected function _parse($content) {
		$parser = new \GhBlog\Parser\Post($content);
		$this->_bindValues($parser->parse());
	}

}