<?php

namespace GhBlog\Model;

use GhBlog\Config;

class Posts {

	protected $_year;
	protected $_mounth;
	protected $_page;

	protected $_itemsPerPage = 5;

	public function __construct($year = null, $mounth = null, $page = 1) {
		$this->_year = ($year === null) ? date('Y') : $year;
		$this->_mounth = ($mounth === null) ? date('m') : $mounth;
		$this->_page = $page;
	}

	public function getYear() {
		return $this->_year;
	}

	public function getMounth() {
		return $this->_mounth;
	}

	public function getPage() {
		return $this->_page;
	}

	public function getList() {
		$files = array();
		foreach ($this->_getFilesFromPath($this->_year, $this->_mounth, $this->_page) as $file) {
			$files[] = $this->_createNewPostObject($file);	
		}
		return $files;
	}

	public function getNext() {
		//if ($this->_checkIfPageExists($this->_year, $this->_mounth, $this->_page+1));
		//	return new self($this->_year, $this->_mounth, $this->_page+1);
		$mounth = $this->_getNextMounth($this->_year, 12);
		var_dump(new self($this->_year, $mounth, 1));
	}

	protected function _checkIfPageExists($year, $mounth, $page) {
		return (bool) array_slice(glob($this->_getPath($year, $mounth).'/*'), ($page-1) * $this->_itemsPerPage, $this->_itemsPerPage);
	}

	protected function _getNextMounth($year, $mounth) {
		$mounths = glob($this->_getPath($year).'/*');
		$i = array_search($this->_getPath($year, $mounth), $mounths);
		if ($i === false)
			throw new \Exception('Mounth not find!');
		if (array_key_exists($i+1, $mounths)) {
			$pathPart = explode('/', $mounths[$i+1]);
			return $pathPart[count($pathPart)-1];
		}
		return false;
	}

	protected function _createNewPostObject($file) {
		$post = new Post();
		$post->loadFromFile($file);
		return $post;
	}

	protected function _getFilesFromPath($year, $mounth, $page) {
		$files = array_slice(glob($this->_getPath($year, $mounth).'/*'), ($page-1) * $this->_itemsPerPage, $this->_itemsPerPage);
		return $files;
	}

	protected function _getPath($year = null, $mounth = null) {
		$path = Config::app()->get('path.posts');
		$path .= ($year !== null) ? '/'.$year : '';
		$path .= ($mounth !== null) ? '/'.$mounth : '';
		return $path;
	}

}
