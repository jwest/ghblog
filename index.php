<?php

require 'vendor/autoload.php';

\GhBlog\Config::$configPath = '.';
date_default_timezone_set('Europe/Warsaw');

$app = new \Slim\Slim();

$app->get('/', function () {
    echo "Hello";
});

$app->post('/hook/'.\GhBlog\Config::app()->get('api.hook.hash'), function(){
	$changesObj = new \GhBlog\Model\Changes(new \GhBlog\JsonRequestParser());
	foreach ($changesObj->getAdded() as $added) {
		$post = new \GhBlog\Model\Post($added);
		$post->load();
		$post->save();
	}
	foreach ($changesObj->getModified() as $modified) {
		$post = new \GhBlog\Model\Post($modified);
		$post->load(true);
		$post->save();
	}
	foreach ($changesObj->getRemoved() as $removed) {
		$post = new \GhBlog\Model\Post($removed);
		$post->load();
		$post->remove();
	}
});

$app->run();