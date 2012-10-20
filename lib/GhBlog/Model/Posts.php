<?php

namespace GhBlog\Model;

use GhBlog\Config;

class Posts {

	protected $_filesProvider;

	protected $_year;
	protected $_mounth;
	protected $_page;

	protected $_itemsPerPage = 3;

	public function __construct($year = null, $mounth = null, $page = 1) {
		$this->_filesProvider = \GhBlog\Api::factory('Files');
		if ($year === null && $mounth === null) {
			$this->_loadActual();
			return;
		}
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

	public function _loadActual() {
		$years = $this->_filesProvider->listDirs($this->_getPath());
		$this->_year = $this->_getYearFromPath($years[count($years)-1]);
		$mounths = $this->_filesProvider->listDirs($this->_getPath($this->_year));
		$this->_mounth = $this->_getMounthFromPath($mounths[count($mounths)-1]);
		$this->_page = 1;
	}

	public function getList() {
		$files = array();
		foreach ($this->_getFilesFromPath($this->_year, $this->_mounth, $this->_page) as $file) {
			$files[] = $this->_createNewPostObject($file);	
		}
		return $files;
	}

	public function getNext() {		
		if ($this->_checkIfPageExists($this->_year, $this->_mounth, $this->_page+1))
			return new self($this->_year, $this->_mounth, $this->_page+1);
		$year = $this->_year;
		$mounth = $this->_getNextElem($this->_year, $this->_mounth);
		if ($mounth === false) {
			$year = $this->_getNextElem($this->_year);
			$mounth = $this->_getFirstMounth($year);
		}
		return new self($year, $mounth, 1);
	}

	public function getPrev() {
		if ($this->_page > 1 && $this->_checkIfPageExists($this->_year, $this->_mounth, $this->_page-1))
			return new self($this->_year, $this->_mounth, $this->_page-1);
		$year = $this->_year;
		$mounth = $this->_getPrevElem($this->_year, $this->_mounth);
		if ($mounth === false) {
			$year = $this->_getPrevElem($this->_year);
			$mounth = $this->_getLastMounth($year);			
		}
		$page = $this->_getLastPage($year, $mounth);
		return new self($year, $mounth, $page);
	}

	protected function _checkIfPageExists($year, $mounth, $page) {
		$files = $this->_filesProvider->listFiles($this->_getPath($year, $mounth));		
		$files = array_slice($files, ($page-1) * $this->_itemsPerPage, $this->_itemsPerPage);
		return (bool) !empty($files);
	}

	protected function _getNextElem($year, $mounth = null) {
		$items = $this->_filesProvider->listDirs($this->_getPath($mounth == null ? null : $year));
		return $this->_searchElem($items, $year, $mounth);
	}

	protected function _getPrevElem($year, $mounth = null) {
		$items = $this->_filesProvider->listDirs($this->_getPath($mounth == null ? null : $year));
		$items = array_reverse($items);
		return $this->_searchElem($items, $year, $mounth);	
	}

	protected function _searchElem($items, $year, $mounth) {
		$i = array_search($this->_getPath($year, $mounth), $items);
		if ($i === false)
			throw new \Exception('Elem not found!');
		if (array_key_exists($i+1, $items)) {
			$pathPart = explode('/', $items[$i+1]);
			return $pathPart[count($pathPart)-1];
		}
		return false;
	}
 
	protected function _getFirstMounth($year) {
		$mounths = $this->_filesProvider->listDirs($this->_getPath($year));
		$pathPart = explode('/', $mounths[0]);
		return $pathPart[count($pathPart)-1];
	}

	protected function _getLastMounth($year) {
		$mounths = $this->_filesProvider->listDirs($this->_getPath($year));
		$pathPart = explode('/', $mounths[count($mounths)-1]);
		return $pathPart[count($pathPart)-1];
	}

	protected function _getLastPage($year, $mounth) {
		$files = $this->_filesProvider->listFiles($this->_getPath($year, $mounth));
		$files = array_reverse($files);
		$pagesCount = ceil(count($files) / $this->_itemsPerPage);
		return (int) $pagesCount == 0 ? 1 : $pagesCount;
	}

	protected function _createNewPostObject($file) {
		$post = new Post();
		$post->loadFromFile($file);
		return $post;
	}

	protected function _getFilesFromPath($year, $mounth, $page) {		
		$files = $this->_filesProvider->listFiles($this->_getPath($year, $mounth));
		return array_slice($files, ($page-1) * $this->_itemsPerPage, $this->_itemsPerPage);
	}

	protected function _getPath($year = null, $mounth = null) {
		$path = 'posts';
		$path .= ($year !== null) ? '/'.$year : '';
		$path .= ($mounth !== null) ? '/'.$mounth : '';		
		return $path;
	}

	protected function _getYearFromPath($path) {		
		return $this->_getElemFromPath($path, 1);
	}

	protected function _getMounthFromPath($path) {
		return $this->_getElemFromPath($path, 2);
	}

	private function _getElemFromPath($path, $i) {
		$pathPart = explode('/', $path);		
		return array_key_exists($i, $pathPart) ? $pathPart[$i] : false;
	}

}
