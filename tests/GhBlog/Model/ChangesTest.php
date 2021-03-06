<?php

class GhBlog_Model_ChangesTest extends PHPUnit_Framework_TestCase {

	public function testCreateObject() {

		class_alias('\GhBlog\Model\Changes', 'C1');

		$path = '2012/10_06_test_post3.md';
		$obj = $this->getMock('C1', array('_loadFromApi', '_loadFromFile'), array($this->_createJsonRequestParserObj(0)));
		$obj->expects($this->any())
		    ->method('_loadFromFile')
		    ->will($this->returnValue('test1'));
		$obj->expects($this->any())
        	->method('_loadFromApi')
		    ->will($this->returnValue('test2'));

		$added = $obj->getAdded();
		$this->assertEquals('test2', $added[0]);
		$modified = $obj->getModified();
		$this->assertEmpty($modified);
		$this->assertTrue(is_array($modified));
		$removed = $obj->getRemoved();		
		$this->assertEquals('test1', $removed[0]);
	}


	private function _createJsonRequestParserObj($i) {
		$stream = fopen('data://text/plain,'.$this->_provider[$i], 'r');
		$obj = new \GhBlog\JsonRequestParser($stream);		
		return $obj;
	}


	private $_provider = array(
		'{ "after": "da2108038f2f353b3cc01f043cfade9ad123a400", "before": "e6d7ac42fa0c50bd8c59b5b47ab192db06bd01bc", "commits": [ { "added": [], "author": { "email": "jwest@jwest.pl", "name": "Jakub Westfalewski", "username": "jwest" }, "committer": { "email": "jwest@jwest.pl", "name": "Jakub Westfalewski", "username": "jwest" }, "distinct": true, "id": "090f71fb78e94772f4f7af7491e5a325e64946c7", "message": "Update 2012/10_04_test_post1.md", "modified": [], "removed": [], "timestamp": "2012-10-05T02:03:11-07:00", "url": "https://github.com/jwest/git-blog/commit/090f71fb78e94772f4f7af7491e5a325e64946c7" }, { "added": [], "author": { "email": "jwest@jwest.pl", "name": "Jakub Westfalewski", "username": "jwest" }, "committer": { "email": "jwest@jwest.pl", "name": "Jakub Westfalewski", "username": "jwest" }, "distinct": true, "id": "c67ac5965d62dfb2fddc752b211e1e82c76e0c60", "message": "Update 2012/10_04_test_post2.md", "modified": [], "removed": [], "timestamp": "2012-10-05T02:03:41-07:00", "url": "https://github.com/jwest/git-blog/commit/c67ac5965d62dfb2fddc752b211e1e82c76e0c60" }, { "added": [ "2012/10_06_test_post3.md" ], "author": { "email": "jwest@jwest.pl", "name": "jwest", "username": "jwest" }, "committer": { "email": "jwest@jwest.pl", "name": "jwest", "username": "jwest" }, "distinct": true, "id": "da2108038f2f353b3cc01f043cfade9ad123a400", "message": "public", "modified": [], "removed": [ "2012/10_06_test_post5.md" ], "timestamp": "2012-10-06T03:11:28-07:00", "url": "https://github.com/jwest/git-blog/commit/da2108038f2f353b3cc01f043cfade9ad123a400" } ], "compare": "https://github.com/jwest/git-blog/compare/e6d7ac42fa0c...da2108038f2f", "created": false, "deleted": false, "forced": false, "head_commit": { "added": [ "2012/10_06_test_post3.md" ], "author": { "email": "jwest@jwest.pl", "name": "jwest", "username": "jwest" }, "committer": { "email": "jwest@jwest.pl", "name": "jwest", "username": "jwest" }, "distinct": true, "id": "da2108038f2f353b3cc01f043cfade9ad123a400", "message": "public", "modified": [], "removed": [ "2012/10_06_test_post5.md" ], "timestamp": "2012-10-06T03:11:28-07:00", "url": "https://github.com/jwest/git-blog/commit/da2108038f2f353b3cc01f043cfade9ad123a400" }, "pusher": { "name": "none" }, "ref": "refs/heads/master", "repository": { "created_at": "2012-10-04T06:58:19-07:00", "description": "JWest blog posts for ghblog blog system", "fork": false, "forks": 0, "has_downloads": true, "has_issues": true, "has_wiki": true, "id": 6076083, "name": "git-blog", "open_issues": 0, "owner": { "email": "j.westfalewski@gmail.com", "name": "jwest" }, "private": false, "pushed_at": "2012-10-06T03:11:44-07:00", "size": 172, "stargazers": 0, "url": "https://github.com/jwest/git-blog", "watchers": 0 } }'
	);

}