<?php

namespace GhBlog\Model;

class Changes {

	const ADDED = 'added';
	const MODIFIED = 'modified';
	const REMOVED = 'removed';

	protected $_pushInfo;

	public function __construct($requestPushInfo) {
		$this->_pushInfo = $requestPushInfo->read();
	}

	public function getAdded() {
		$files = array();
		foreach ($this->_getFiles(self::ADDED) as $file){
			$files[] = $this->_loadFromApi($file);
		};
		return $files;
	}

	public function getModified() {
		$files = array();
		foreach ($this->_getFiles(self::MODIFIED) as $file){
			$files[] = $this->_loadFromApi($file);
		};
		return $files;
	}

	public function getRemoved() {
		$files = array();
		foreach ($this->_getFiles(self::REMOVED) as $file){
			$files[] = $this->_loadFromFile($file);
		};
		return $files;
	}

	protected function _loadFromApi($file) {
		$post = new Post();
		return $post->loadFromApi($file);
	}

	protected function _loadFromFile($file) {
		$post = new Post();
		return $post->loadFromFile($file);	
	}

	protected function _getCommits() {
		return $this->_pushInfo->commits;
	}

	protected function _getPropFromCommit($commitObj, $prop) {		
		return array_fill_keys($commitObj->$prop, true);
	}

	protected function _getFiles($prop) {
		$files = array();
		foreach ($this->_getCommits() as $commit) {
			$files += $this->_getPropFromCommit($commit, $prop);
		}
		return array_keys($files);
	}

}