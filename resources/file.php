<?php
	require_once RASP_RESOURCES_PATH . 'abstract_resource.php';
	require_once RASP_TYPES_PATH . 'array.php';

	class RaspFile extends RaspAbstractResource {

		public $handler = null, $source = null;

		public function RaspFile($options = array()){
			$this->initilize($options);
		}

		public function initilize($options){
			if(isset($options['source'])){
				$this->source = $options['source'];
				return ($this->handler = fopen($this->source, RaspArray::index($options, 'mode', 'r')));
			} else return false;
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