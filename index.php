<?php

require 'vendor/autoload.php';

$api = new GhBlog_Provider_Github_Api('jwest/git-blog');
$files = $api->getList('2012');
var_dump($files[0]->getPost());