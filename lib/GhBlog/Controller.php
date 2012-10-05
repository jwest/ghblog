<?php

class GhBlog_Controller {

	protected $_template;

	public function __construct() {
		$this->_template = new Twig_Environment(new Twig_Loader_Filesystem('/templates'), array(
		    'cache' => '/data/templates',
		));
	}

	public function listing() {

	}

	public function post() {

	}

	protected function _template($name, $param) {
		return $twig->render('index.html', array('name' => 'Fabien'));
	}

}