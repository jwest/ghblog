<?php

namespace GhBlog\Parser;

interface IParser {
	public function __construct($content);
	public function parse(array $params = null);
}