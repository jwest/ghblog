<?php

class GhBlog_GithubApi {

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
		return $this->_request('repos/'.$this->_repo.'/contents/'.$path);
	}

	public function getContent($path) {
		$content = $this->_request('repos/'.$this->_repo.'/contents/'.$path);
		return $content;
	}

}