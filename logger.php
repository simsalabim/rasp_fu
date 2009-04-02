<?php
	class Logger {
		public static $logger;
		public $file_name, $handler;

		public function Logger($file_name = ''){
			$this->file_name = $file_name;
		}

		public static function save($message){
			self::$logger->open_log_file();
			$returning = fwrite(self::$logger->handler, $message);
			self::$logger->close_log_file();
			return $returning;
		}

		public static function save_and_print($message){
			print $message;
			return self::save($message);
		}

		private function open_log_file(){
			$this->handler = fopen($this->file_name, 'a');
		}

		private function close_log_file(){
			fclose($this->handler);
		}

		public static function create($file_name){
			self::$logger = new Logger($file_name);
		}
	}
?>