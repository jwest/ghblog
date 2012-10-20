<?php

namespace GhBlog\Api;

interface IApi {
	public function __construct(array $params = array());
	public function getContent($path);
	public function putContent($path, $content);
	public function removeContent($path);
	public function listFiles($path = '');
	public function listDirs($path = '');
}