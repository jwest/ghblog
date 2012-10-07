<?php

namespace GhBlog\Api;

interface IApi {
	public function __construct($param = null);
	public function getFileContent($path);
}