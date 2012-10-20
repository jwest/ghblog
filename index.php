<?php

require 'vendor/autoload.php';

use \Slim\Slim;
use \GhBlog\Model\Changes;
use \GhBlog\Config;
use \GhBlog\Model\Post;
use \GhBlog\Model\Posts;
use \GhBlog\JsonRequestParser;

Config::$configPath = '.';
date_default_timezone_set('Europe/Warsaw');

$app = new Slim();

$app->get('/(:year(/:mounth(/:page)))', function ($year = null, $mounth = null, $page = null) {
    $posts = new Posts($year, $mounth, $page);
    var_dump($posts->getList());
});

$app->post('/hook/'.Config::app()->get('api.hook.hash'), function(){
	$changesObj = new Changes(new JsonRequestParser());
	foreach ($changesObj->getAdded() as $post)
		$post->save();
	foreach ($changesObj->getModified() as $post)
		$post->save();
	foreach ($changesObj->getRemoved() as $post)
		$post->remove();
});

$app->run();