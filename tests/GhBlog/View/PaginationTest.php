<?php

use GhBlog\View\Pagination;

class GhBlog_View_PaginationTest extends PHPUnit_Framework_TestCase {

    public function testGetNext() {
        $obj = new Pagination(new \GhBlog\Model\Posts(2012,8,1));
        $obj = $this->_getNext($obj, "2012", "08", 2);
        $obj = $this->_getNext($obj, "2012", "12", 1);
        $obj = $this->_getNext($obj, "2014", "02", 1);
        $obj = $this->_getNext($obj, "2014", "04", 1);
        $obj = $this->_getNext($obj, "2014", "07", 1);
        $obj = $this->_getNext($obj, "2014", "10", 1);
        $this->assertEmpty($obj->getNextPage());
    }

    public function testGetPrev() {
        $obj = new Pagination(new \GhBlog\Model\Posts(2014,10,1));
        $obj = $this->_getPrev($obj, "2014", "07", 1);
        $obj = $this->_getPrev($obj, "2014", "04", 1);
        $obj = $this->_getPrev($obj, "2014", "02", 1);
        $obj = $this->_getPrev($obj, "2012", "12", 1);
        $obj = $this->_getPrev($obj, "2012", "08", 2);
        $obj = $this->_getPrev($obj, "2012", "08", 1);
        $obj = $this->_getPrev($obj, "2012", "03", 1);
        $this->assertEmpty($obj->getPrevPage());
    }

    public function testGetActual() {
        $obj = new Pagination(new \GhBlog\Model\Posts(2014,10,1));
        $this->_objAssert($obj->getActual(), 2014, 10, 1);
    }

    private function _getNext($obj, $year, $mounth, $page) {
        $obj = $obj->getNextPage();
        $this->_objAssert($obj, $year, $mounth, $page);
        return new Pagination($obj);
    }

    private function _getPrev($obj, $year, $mounth, $page) {
        $obj = $obj->getPrevPage();
        $this->_objAssert($obj, $year, $mounth, $page);
        return new Pagination($obj);
    }

    private function _objAssert($obj, $year, $mounth, $page) {
        $this->assertEquals($year, $obj->getYear());
        $this->assertEquals($mounth, $obj->getMounth());
        $this->assertEquals($page, $obj->getPage());
    }

}