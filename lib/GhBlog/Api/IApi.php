<?php

namespace GhBlog\Api;

interface IApi {
	public function __construct(array $param = array());
	public function getContent($path);
	public function putContent($path, $content);
	public function listFiles($path = '');
	public function listDirs($path = '');
}