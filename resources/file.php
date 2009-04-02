<?php

class File {
	public $handler;

	function File($path, $mode = "r"){
		$this->handler = fopen($path, $mode);
	}

	public function write($data){
		fwrite($this->handler, $data);
	}

	public function close(){
		fclose($this->handler);
	}

	public function read($block = 4096){
		return fgets($this->handler, $block);
	}

	public function is_eof(){
		return feof($this->handler);
	}
}

?>