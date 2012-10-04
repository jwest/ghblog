<?php

class GhBlog_Model_Provider_File {

	public $_provider;
	public $_hash;
	public $_ref;

	public function __construct(GhBlog_Provider $provider, $hash, $ref) {
		$this->_provider = $provider;
		$this->_hash = $hash;
		$this->_ref = $ref;
	}

	public function getPost() {		
		return new GhBlog_Model_Post($this->_hash, $this->_parse());
	}

	protected function _parse() {
		$rawContent = $this->_getRawContent();
		$post['title'] = 'title';
		$post['timestamp'] = time();
		$post['tags'] = array('php', 'kohana', 'test');
		$post['content'] = $rawContent;
		return $post;
	}

	protected function _getRawContent() {
		return $this->_provider->getContent($this->_ref);
	}

}