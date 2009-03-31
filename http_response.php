<?php
	class HttpResponse {
		public $response, $body, $header;

		public function HttpResponse($response_body, $options = array()){
			$this->response = $response_body;
			$this->body = trim(substr($response_body, $options['header_size']));
			$this->header = $this->extract_header_from_response(substr($response_body, 0, $options['header_size']));
		}

		public static function separate($response_body, $options){
			$http_response = new HttpResponse($response_body, $options);
			return $http_response;
		}

		private function extract_header_from_response($response_body){
			$matches = array(); $header = array();
			preg_match_all('/([a-zA-Z-]*):(.*?)\\r\\n/is', $response_body, $matches);
			foreach($matches[1] as $key => $attribute) $header[$attribute] = $matches[2][$key];
			return $header;
		}

		public function __destruct(){
			$this->response = null;
			unset($this->response);
			$this->body = null;
			unset($this->body);
			$this->header = null;
			unset($this->header);
		}
	}
?>