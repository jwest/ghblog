<?php

namespace GhBlog;

class JsonRequestParser {

	protected $_stream;

	public function __construct($stream = null) {
		$this->_stream = ($stream === null)
			? $this->_getDefaultStream()
			: $stream;
	}

	protected function _getDefaultStream() {
		return fopen('php://input', 'r');
	}

	protected function _getDefaultStreamSize() {
		return (int)$_SERVER['CONTENT_LENGTH'];
	}

	public function read() {
		$obj = json_decode(stream_get_contents($this->_stream));
		if ($obj === null)
			throw new \Exception('Content is invalid');
		return $obj;
	}

}