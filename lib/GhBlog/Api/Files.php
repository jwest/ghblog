<?php

namespace GhBlog\Api;

use GhBlog\Config;

class Files implements IApi {

	protected $_path;

	public function __construct(array $params = array()) {
		if (empty($params)){
			$params = Config::app()->get('api.files');
		}
		$this->_path = $params['path'];
	}

	public function getContent($path) {
		if (file_exists($this->_path.'/'.$path)) {
			return file_get_contents($this->_path.'/'.$path);
		}
		throw new Api/Exception('File not exists');
	}

	public function putContent($path, $content) {
		return file_put_contents($this->_path.'/'.$path, $content);
	}

	public function listFiles($path = '') {
		$items = glob($this->_path.'/'.$path.'/*');
		natsort($items);
		return array_map(array($this, '_removeDefaultPath'), $items);
	}

	public function listDirs($path = '') {
		$items = glob($this->_path.'/'.$path.'/*', GLOB_ONLYDIR);
		natsort($items);		
		return array_map(array($this, '_removeDefaultPath'), $items);
	}

	protected function _removeDefaultPath($path) {
		return ltrim($path, $this->_path);
	}
}