<?php

namespace GhBlog\View;

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

}