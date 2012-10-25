<?php

namespace GhBlog\Generator;

use \GhBlog\Model;

class Post { 

	protected $_twig;
	protected $_post;

	public function __construct(\Twig_Environment $twig, Model\Post $post) {
		$this->_twig = $twig;
		$this->_post = $post;
	}

	public function getPost() {
		return $this->_post;		
	}

	public function generatePage() {
		$template = $this->_twig->loadTemplate('post.html');
	    return $template->render($this->_prepareDateForTemplate());
	}

	protected function _prepareDateForTemplate() {
		return array(
	        'post' => $this->_post	        
	    );
	}

}
