<?php

namespace GhBlog;

class Api {

	public static function factory($name) {		
		$name = '\\GhBlog\\Api\\'.ucfirst($name);
		if (class_exists($name)) {
			return new $name();
		}
		throw new \GhBlog\Api\Exception('Api not exists!');
	}

}