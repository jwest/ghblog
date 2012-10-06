<?php

class GhBlog_Model_HashTable {
	
	protected $_hashTable;

	public function __construct(array $hashTable = null) {
		if ($hashTable === null)
			$this->_hashTable = $this->_load();
		else
			$this->_hashTable = $hashTable;
	}

	protected function _load() {
		$path = GhBlog_Config::get('path.hashtable');
		return json_decode(file_get_contents($path));
	}

	public function isHashExists($hash) {
		return array_key_exists($hash, $this->_hashTable);
	}

	public function diff($hashTable) {
		
	}

}