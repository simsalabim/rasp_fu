<?php
	class Socket {
		public $connection, $error_number = '', $error_value = '';

		public function Socket($url, $options = array()){
			$options = array_merge($this->default_params(), $options);
			$this->connection = fsockopen($url, $options['port'], $this->error_number, $this->error_value, $options['timeout']);
		}

		public function is_connection_established(){
			return ($this->connection ? true : false);
		}

		public function connect($request){
			if($this->is_connection_established()) return fwrite($this->connection, $request);
			else return false;
		}

		public function close(){
			return fclose($this->connection);
		}

		public function read($block = 4096){
			if(!$this->is_empty()) return fgets($this->connection, $block);
			else return false;
		}

		public function is_empty(){
			return feof($this->connection);
		}

		public function send($http_request){
			if($this->connect($http_request)){
				$response = '';
				while(!$this->is_empty()) $response .= $this->read();
				$this->close();
				return $response;
			} else return null;
		}

		public static function request($url, $params, $http_request){
			$socket = new Socket($url, $params);
			return $socket->send($http_request);
		}

		private function default_params(){
			return array('port' => 443, 'timeout' => 30);
		}
	}
?>