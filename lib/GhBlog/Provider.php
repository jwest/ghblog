<?php

interface GhBlog_Provider {
	public function __construct($repo);
	public function getList($path);	
	public function getContent($path);	
}