<?php

interface GhBlog_Parser {
	public function __construct($rawContent);
	public function parse();
	public function __get($name);
}