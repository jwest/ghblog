<?php

namespace GhBlog\Model;

use GhBlog\Api;
use GhBlog\Config;

class Post {

	protected $_path;
	protected $_title;
	protected $_tags;
	protected $_timestamp;
	protected $_content;
	protected $_rawContent;

	protected $_loaded = false;

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

	public function getUrl() {
		$pathPart = explode('.', $this->_path);
		unset($pathPart[count($pathPart)-1]);
		return Config::app()->get('url') . 'post/' . ltrim(implode('.', $pathPart), 'posts/');
	}

	public function load($year = null, $mounth = null, $postName = null) {
		if ($year !== null && $mounth !== null && $postName !== null)
			$this->loadFromFile('posts/'.$year.'/'.$mounth.'/'.$postName.'.md');
	}

	public function loadFromFile($path) {
		$this->_path = $path;
		$content = $this->_loadFromFile();
		$this->_parse($content);
	}

	public function loadFromApi($path) {
		$this->_path = $path;
		$content = $this->_loadFromApi();
		$this->_parse($content);
	}

	public function save() {
		Api::factory('Files')->putContent($this->_getFilePath(), $this->_rawContent);
	}

	public function remove() {
		Api::factory('Files')->removeContent($this->_getFilePath());
	}

	protected function _bindValues($values) {
		$this->_title = $values['title'];
		$this->_tags = $values['tags'];
		$this->_timestamp = $values['date'];
		$this->_content = $values['content'];
	}

	protected function _loadFromFile() {
		return Api::factory('Files')->getContent($this->_getFilePath());
	}

	protected function _loadFromApi() {
		return Api::factory('Github')->getContent($this->_path);		
	}

	protected function _getFilePath() {
		return $this->_path;
	}

	protected function _parse($content) {
		$parser = new \GhBlog\Parser\Post($content);
		$this->_bindValues($parser->parse());
	}

}
