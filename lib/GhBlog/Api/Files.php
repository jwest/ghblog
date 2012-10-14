<?php

namespace GhBlog\Api;

class Files implements IApi {

	protected $_path;

	public function __construct(array $params = array()) {
		$this->_path = $params['path'];
	}

	public function getContent($path) {
		return file_get_contents($this->_path.'/'.$path);
	}

	public function putContent($path, $content) {
		return file_put_contents($this->_path.'/'.$path, $content);
	}

	public function listFiles($path = '') {
		
	}

	public function listDirs($path = '') {
		return glob($this->_path.'/'.$path, GLOB_ONLYDIR);
	}

}