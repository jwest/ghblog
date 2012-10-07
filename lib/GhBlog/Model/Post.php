<?php

namespace GhBlog\Model;

use GhBlog\Config;

class Post {

	protected $_path;
	protected $_title;
	protected $_tags;
	protected $_timestamp;
	protected $_content;
	protected $_rawContent;

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
		$this->_rawContent = $content;
		$this->_parse($content);
		return true;
	}

	public function save() {
		file_put_contents($this->_getFilePath(), $this->_rawContent);
	}

	public function remove() {
		unlink($this->_getFilePath());
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
		$content = $this->_getProvider()->getFileContent($this->_path);		
		return $content;
	}

	protected function _getProvider() {
		$providerName = Config::app()->get('api.provider');
		$providerClass = '\\GhBlog\\Api\\'.ucfirst($providerName);
		return new $providerClass();
	}

	protected function _getFilePath() {
		return Config::app()->get('path.posts').'/'.md5($this->_path).'.md';
	}

	protected function _parse($content) {
		$parser = new \GhBlog\Parser\Post($content);
		$this->_bindValues($parser->parse());
	}

}