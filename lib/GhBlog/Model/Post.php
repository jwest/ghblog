<?php

class GhBlog_Model_Post {

	protected $_hash;
	protected $_rawContent;

	protected $_title;
	protected $_timestamp;
	protected $_tags;
	protected $_content;

	public function __construct($hash, $rawContent) {
		$this->_hash = $hash;
		$this->_rawContent = $rawContent;
		$this->_parse();
	}

	protected function _parse() {

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

}