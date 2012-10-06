<?php

class GhBlog_Config {

	protected static $_config = array(
		'path.templates' => 'data/templates',
		'path.posts' => 'data/posts',
		'provider' => 'Github',
		'provider.repo' => 'jwest/git-blog',
	);

	private function __construct() {}

	public static function get($key) {
		if(isset(self::$_config[$key]))
			return self::$_config[$key];
		throw new Exception('You must set "'.$key.'" config before usage');
	}

	public static function set($key, $value) {
		self::$_config[$key] = $value;
	}

}