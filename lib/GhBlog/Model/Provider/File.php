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
		$content = $this->_provider->getContent($this->_ref);
		return new GhBlog_Model_Post($this->_hash, $content);
	}

}