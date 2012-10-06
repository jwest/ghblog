<?php

require 'vendor/autoload.php';

date_default_timezone_set('Europe/Warsaw');

$api = new GhBlog_Provider_Github_Api(GhBlog_Config::get('provider.repo'));
$files = $api->getList('2012');

foreach($files as $file) {
	
}

var_dump($files[0]->getPost());