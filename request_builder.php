<?php
	class RequestBuilder {

		private static $br = "\r\n", $boundary = '';

		public static function create($params = array()){
			self::$boundary = $params['boundary'];
			if($params['type'] == 'multipart'){

				$content = "";
				foreach($params['data'] as $name => $value) $content .= self::each_variable($name, $value);
				$content .= self::boundary_string(true);

				$header = "Content-Type: multipart/form-data; boundary=---------------------------" . $params['boundary'] . self::br();
				$header .= "Content-Length: " . strlen($content) . self::br();
				$header .= $content;
				return $header;
			}
		}

		private static function br(){
			return self::$br;
		}

		private static function each_variable($name, $value){
			$content = '';
			$content .= self::boundary_string();
			$content .= 'Content-Disposition: form-data; name="' . $name . '"' . self::br();
			$content .= self::br();
			$content .= $value . self::br();
			return $content;
		}

		private static function boundary_string($end = false){
			return "-----------------------------" . self::$boundary . ($end ? '--' : '') . self::br();
		}
	}
?>