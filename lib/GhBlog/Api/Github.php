<?php

namespace GhBlog\Api;

use GhBlog\Config;

class Github implements IApi {

	const API_ADDRESS = 'https://api.github.com/';

	protected $_repo;

	public function __construct($param = null) {
		if ($param === null)
			$param = Config::app()->get('api.provider.repo');
		$this->_repo = $param;
	}

	public function getFileContent($path) {
		$content = $this->_getContentAndValidate($path);
		return $this->_conversion($content);
	}

	protected function _getContentAndValidate($path) {
		$content = json_decode($this->_request('repos/'.$this->_repo.'/contents/'.$path));
		if(isset($content->message) && $content->message == 'Not Found')
			throw new Exception('Object not found in Github Api');
		return $content;
	}

	protected function _conversion($content) {
		if($content->encoding == 'base64'){
			return base64_decode($content->content);
		}
		return $content->content;
	}

	protected function _request($url) {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, self::API_ADDRESS.$url);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$output = curl_exec($ch);
		curl_close($ch);
		return $output;
	}

}