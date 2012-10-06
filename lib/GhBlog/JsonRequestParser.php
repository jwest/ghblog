<?php

namespace GhBlog;

class JsonRequestParser {

	protected $_stream;
	protected $_streamSize;

	public function __construct($stream = null, $size = 0) {
		if ($stream === null) {
			$this->_stream = $this->_getStream();
			$this->_streamSize = $this->_getStreamSize();
			return;
		}
		$this->_stream = $stream;
		$this->_streamSize = $size;
	}

	protected function _getStream() {
		return fopen ('php://input', 'r');
	}

	protected function _getStreamSize() {
		return (int)$_SERVER['CONTENT_LENGTH'];
	}

	public function getRealStreamSize() {
		$stream = tmpfile ();
	    $realSize = stream_copy_to_stream($this->_stream, $stream);
	    fclose ($stream);
	    fseek($this->_stream, 0, SEEK_SET);
	    return $realSize;
	}

	public function read() {
		$this->_validationSize($this->getRealStreamSize());
		$obj = json_decode(stream_get_contents($this->_stream));
		if ($obj === null)
			throw new \Exception('Content is invalid');
		fseek($this->_stream, 0, SEEK_SET);
		return $obj;
	}

	protected function _validationSize($realSize) {
		if ($realSize !== $this->_streamSize)
			throw new \Exception('Stream length is invalid!');
	}

}