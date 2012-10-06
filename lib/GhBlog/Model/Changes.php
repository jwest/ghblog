<?php

namespace GhBlog\Model;

class Changes {

	const ADDED = 'added';
	const MODIFIED = 'modified';
	const REMOVED = 'removed';

	protected $_pushInfo;

	public function __construct($pushInfo) {
		$this->_pushInfo = $pushInfo;
	}

	public function getAdded() {
		return $this->_getFiles(self::ADDED);
	}

	public function getModified() {
		return $this->_getFiles(self::MODIFIED);
	}

	public function getRemoved() {
		return $this->_getFiles(self::REMOVED);
	}

	protected function _getCommits() {
		return $this->_pushInfo->commits;
	}

	protected function _getPropFromCommit($commitObj, $prop) {
		return $commitObj->$prop;
	}

	protected function _getFiles($prop) {
		$files = array();
		foreach ($this->_getCommits() as $commit) {
			$files += $this->_getPropFromCommit($commit, $prop);
		}
		return $files;
	}

}