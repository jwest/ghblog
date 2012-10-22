<?php

namespace GhBlog\View;

use GhBlog\Config;
use GhBlog\Model\Posts;

class Pagination {

    protected $_posts;

    public function __construct(Posts $posts) {
        $this->_posts = $posts;
    }

    public function getActual() {
        return $this->_posts;
    }

    public function getNextPage() {
        return $this->_posts->getNext();
    }

    public function getPrevPage() {
        return $this->_posts->getPrev();
    }

    public function getNextPageUrl($absolute = true) {
        $next = $this->getNextPage();
        return $this->_prepareLink($next, $absolute);
    }

    public function getPrevPageUrl($absolute = true) {
        $prev = $this->getPrevPage();
        return $this->_prepareLink($prev, $absolute);
    }

    protected function _prepareLink($obj, $absolute = true) {
        $url = ($absolute) ? Config::app()->get('url') : '';
        return $url . $obj->getYear() . '/' . $obj->getMounth() . ($obj->getPage() !== 1 ? '/' . $obj->getPage() : null);
    }

}