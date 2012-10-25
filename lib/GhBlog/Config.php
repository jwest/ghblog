<?php

namespace GhBlog;

class Config {

	public static $configPath = '.';

	protected $_config = array();

	protected static $_instances = array();

	public static function __callStatic($name, $args) {
		if (!array_key_exists($name, self::$_instances))
			self::$_instances[$name] = new self($name);
		return self::$_instances[$name];
	}

	protected function __construct($name) {
		$this->_config = $this->_loadConfigFile($name);
	}

	protected function _loadConfigFile($name) {
		$path = self::$configPath.'/config'.ucfirst($name).'.ini';
		if (file_exists($path))
			return parse_ini_file($path);
		throw new \Exception('Config file "'.$name.'" not exists');
	}

	public function get($name) {
		if (array_key_exists($name, $this->_config))
			return $this->_config[$name];
		throw new \Exception('Config value "'.$name.'" not defined');
	}

	public function set($name, $value) {
		$this->_config[$name] = $value;
	}

}