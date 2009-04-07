<?php
	require_once RASP_TOOLS_PATH . 'abstract_tool.php';
	require_once RASP_RESOURCES_PATH . 'file.php';

	class RaspLogger extends RaspAbstractTool{

		public static $current;

		public $file_name, $file;

		public function RaspLogger($options = array()){
			$this->initilize($options);
		}

		public function initilize($options){
			if(isset($options['file_name'])) $this->file_name = $options['file_name'];
		}

		public static function save($message){
			self::$current->open();
			$returning = self::$current->file->write($message);
			self::$current->close();
			return $returning;
		}

		public static function save_and_print($message){
			print $message;
			return self::save($message);
		}

		private function open(){
			return ($this->file = new RaspFile(array('source' => $this->file_name, 'mode' => 'a')));
		}

		private function close(){
			return $this->file->close();
		}

		public static function create($options){
			self::$current = new RaspLogger($options);
		}
	}
?>