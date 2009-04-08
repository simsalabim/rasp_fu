<?php
	require_once RASP_TOOLS_PATH . 'abstract_tool.php';
	require_once RASP_RESOURCES_PATH . 'file.php';

	class RaspLogger extends RaspAbstractTool{

		public static $current,
			$options = array(
				'silence' => true
			);

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

		public static function set($options, $value = null){
			if(is_array($options)) {
				foreach($options as $option => $value) self::$options[$option] = $value;
				return true;
			} else return self::$options[$options] = $value;
		}

		public static function get($option){
			return self::$options[$option];
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