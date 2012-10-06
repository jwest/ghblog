<?php

class GhBlog_Model_Provider_File {

	protected $_provider;
	protected $_hash;
	protected $_ref;
	protected $_getRawContent = null; 

	public function __construct(GhBlog_Provider $provider, $hash, $ref) {
		$this->_provider = $provider;
		$this->_hash = $hash;
		$this->_ref = $ref;
	}

	public function getHash() {
		return $this->_hash;
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
		if ($this->_getRawContent === null)
			$this->_getRawContent = $this->_provider->getContent($this->_ref);
		return $this->_getRawContent;	
	}

}