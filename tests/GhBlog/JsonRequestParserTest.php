<?php

class GhBlog_JsonRequestParserTest extends PHPUnit_Framework_TestCase {

	public function testReadSimpleStream() {
		$obj = $this->_createObj('simpleObject');
		$this->assertEquals($obj->test, 'ok');
	}

	public function testValidationSize() {
		$obj = $this->_createObj('githubData');
		$this->assertEquals($obj->after, 'da2108038f2f353b3cc01f043cfade9ad123a400');
		$this->assertEquals($obj->before, 'e6d7ac42fa0c50bd8c59b5b47ab192db06bd01bc');
		$this->assertEquals($obj->commits[0]->modified[0], '2012/10_04_test_post1.md');
		$this->assertEquals($obj->commits[1]->modified[0], '2012/10_04_test_post2.md');
	}

	public function testInvalidJson() {
		try{
			$obj = $this->_createObj('invalidJson');
			$this->assertTrue(false);
		}
		catch(\Exception $e) {
			$this->assertTrue(true);
			$this->assertEquals($e->getMessage(), 'Content is invalid');
		}
	}

	private function _createObj($name) {
		$stream = fopen('data://text/plain,'.$this->_provider[$name], 'r');
		$obj = new \GhBlog\JsonRequestParser($stream);		
		return $obj->read();
	}

	private $_provider = array(
		'simpleObject' => '{ "test": "ok" }',
		'githubData' => '{ "after": "da2108038f2f353b3cc01f043cfade9ad123a400", "before": "e6d7ac42fa0c50bd8c59b5b47ab192db06bd01bc", "commits": [ { "added": [], "author": { "email": "jwest@jwest.pl", "name": "Jakub Westfalewski", "username": "jwest" }, "committer": { "email": "jwest@jwest.pl", "name": "Jakub Westfalewski", "username": "jwest" }, "distinct": true, "id": "090f71fb78e94772f4f7af7491e5a325e64946c7", "message": "Update 2012/10_04_test_post1.md", "modified": [ "2012/10_04_test_post1.md" ], "removed": [], "timestamp": "2012-10-05T02:03:11-07:00", "url": "https://github.com/jwest/git-blog/commit/090f71fb78e94772f4f7af7491e5a325e64946c7" }, { "added": [], "author": { "email": "jwest@jwest.pl", "name": "Jakub Westfalewski", "username": "jwest" }, "committer": { "email": "jwest@jwest.pl", "name": "Jakub Westfalewski", "username": "jwest" }, "distinct": true, "id": "c67ac5965d62dfb2fddc752b211e1e82c76e0c60", "message": "Update 2012/10_04_test_post2.md", "modified": [ "2012/10_04_test_post2.md" ], "removed": [], "timestamp": "2012-10-05T02:03:41-07:00", "url": "https://github.com/jwest/git-blog/commit/c67ac5965d62dfb2fddc752b211e1e82c76e0c60" }, { "added": [ "2012/10_06_test_post3.md" ], "author": { "email": "jwest@jwest.pl", "name": "jwest", "username": "jwest" }, "committer": { "email": "jwest@jwest.pl", "name": "jwest", "username": "jwest" }, "distinct": true, "id": "da2108038f2f353b3cc01f043cfade9ad123a400", "message": "public", "modified": [], "removed": [], "timestamp": "2012-10-06T03:11:28-07:00", "url": "https://github.com/jwest/git-blog/commit/da2108038f2f353b3cc01f043cfade9ad123a400" } ], "compare": "https://github.com/jwest/git-blog/compare/e6d7ac42fa0c...da2108038f2f", "created": false, "deleted": false, "forced": false, "head_commit": { "added": [ "2012/10_06_test_post3.md" ], "author": { "email": "jwest@jwest.pl", "name": "jwest", "username": "jwest" }, "committer": { "email": "jwest@jwest.pl", "name": "jwest", "username": "jwest" }, "distinct": true, "id": "da2108038f2f353b3cc01f043cfade9ad123a400", "message": "public", "modified": [], "removed": [], "timestamp": "2012-10-06T03:11:28-07:00", "url": "https://github.com/jwest/git-blog/commit/da2108038f2f353b3cc01f043cfade9ad123a400" }, "pusher": { "name": "none" }, "ref": "refs/heads/master", "repository": { "created_at": "2012-10-04T06:58:19-07:00", "description": "JWest blog posts for ghblog blog system", "fork": false, "forks": 0, "has_downloads": true, "has_issues": true, "has_wiki": true, "id": 6076083, "name": "git-blog", "open_issues": 0, "owner": { "email": "j.westfalewski@gmail.com", "name": "jwest" }, "private": false, "pushed_at": "2012-10-06T03:11:44-07:00", "size": 172, "stargazers": 0, "url": "https://github.com/jwest/git-blog", "watchers": 0 } }',
		'invalidJson' => '{ abc: testInvalid }',
	);

}