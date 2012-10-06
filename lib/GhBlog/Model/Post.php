<?php

class GhBlog_Model_Post {

	protected $_hash;
	protected $_title;
	protected $_timestamp;
	protected $_tags;
	protected $_content;

	public function __construct($hash, $data) {
		$this->_hash = $hash;
		$this->_title = $data->title;
		$this->_timestamp = $data->timestamp;
		$this->_tags = $data->tags;
		$this->_content = $data->content;
	}

	public function getHash() {
		return $this->_hash;
	}

	public function getTitle() {
		return $this->_title;
	}

	public function getDate($format = 'Y-m-d H:i') {
		return date($format, $this->_timestamp);
	}

	public function getTags() {
		return $this->_tags;
	}

	public function getContent() {
		return $this->_content;
	}

	public function save() {
		file_put_contents($this->_getContentFileName(), $this->getContent());
		file_put_contents($this->_getDescriptionFileName(), json_encode($this));
	}

	protected function _getContentFileName() {
		return GhBlog_Config::get('path.posts').'/'.
			$this->getDate('Y').'/'.
			$this->getDate('m').'/'.
			$this->getDate('d_H_i').'_'.
			$this->getHash().
			'.md';
	}

	protected function _getDescriptionFileName() {
		return GhBlog_Config::get('path.posts').'/'.
			$this->getDate('Y').'/'.
			$this->getDate('m').'/'.
			$this->getDate('d_H_i').'_'.
			$this->getHash().
			'.json';
	}

	protected function _isChange() {

	}

}