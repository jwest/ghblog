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
		return new GhBlog_Model_Post($this->_hash, $this->_parsePost());
	}

	protected function _parsePost() {
		$parser = new GhBlog_Parser_Post($this->_getRawContent());
		$parser->parse();
		return $parser;
	}

	protected function _getRawContent() {
		return $this->_provider->getContent($this->_ref);
	}

}