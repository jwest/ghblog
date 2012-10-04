<?php

class GhBlog_Provider_Github_Api implements GhBlog_Provider {

	protected $_repo = '';

	public function __construct($repo) {
		$this->_repo = $repo;
	}

	protected function _request($url) {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, 'https://api.github.com/'.$url);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$output = curl_exec($ch);
		curl_close($ch);
		return json_decode($output);
	}

	public function getList($path) {
		$list = $this->_request('repos/'.$this->_repo.'/contents/'.$path);
		foreach ($list as $file) {
			
		}
	}

	public function getContent($path) {
		$content = $this->_request('repos/'.$this->_repo.'/contents/'.$path);
		if($content->encoding == 'base64'){
			return base64_decode($content->content);
		}
		return $content->content;		
	}

}