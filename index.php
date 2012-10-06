<?php

require 'vendor/autoload.php';

date_default_timezone_set('Europe/Warsaw');

$app = new \Slim\Slim();

$app->get('/', function () {
    echo "Hello";
});

$app->post('/hook', function(){
	$request = new \GhBlog\JsonRequestParser();
	var_dump($request->read());
});

$app->run();