<?php

require 'vendor/autoload.php';

use \Slim\Slim;
use \GhBlog\Model\Changes;
use \GhBlog\Config;
use \GhBlog\Model\Post;
use \GhBlog\Model\Posts;
use \GhBlog\View\Pagination;
use \GhBlog\JsonRequestParser;

// System configuration
Config::$configPath = '.';

date_default_timezone_set('Europe/Warsaw');

$loader = new Twig_Loader_Filesystem('data/templates');
//$twig = new Twig_Environment($loader, array( 'cache' => 'data/cache' ));
$twig = new Twig_Environment($loader);

$app = new Slim();

$app->get('/(:year(/:mounth(/:page)))', function ($year = null, $mounth = null, $page = 1) use ($twig) {
    $posts = new Posts($year, $mounth, $page);
    $template = $twig->loadTemplate('listing.html');
    echo $template->render(array(
        'posts' => $posts->getList(),
        'pagination' => new Pagination($posts)
    ));
});

$app->get('/post/(:year(/:mounth(/:post)))', function ($year, $mounth, $post) use ($twig) {
    
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