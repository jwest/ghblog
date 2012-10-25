<?php

namespace GhBlog\Generator;

use \GhBlog\Model;

class Posts { 

	protected $_twig;
	protected $_posts;

	public function __construct(\Twig_Environment $twig, Model\Posts $posts) {
		$this->_twig = $twig;
		$this->_posts = $posts;
	}

	public function getList() {
		return $this->_posts;
		
	}

	public function generatePage() {
		$template = $this->_twig->loadTemplate('listing.html');
	    return $template->render($this->_prepareDateForTemplate());
	}

	protected function _prepareDateForTemplate() {
		return array(
	        'posts' => $this->_posts->getList(),
	        'pagination' => new \GhBlog\View\Pagination($this->_posts)
	    );
	}

	public function generatePosts() {

	}

	public function getPostGenerator() {

	}

}
