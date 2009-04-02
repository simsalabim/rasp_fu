<?php

 class RaspRequester {
 	public $handler;

 	public function Requester($options = array()){
		$this->handler = curl_init();
		curl_setopt($this->handler, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($this->handler, CURLOPT_HEADER, true);
		if(ArrayFu::index($options, 'post', false)) curl_setopt($this->handler, CURLOPT_POST, 1);
		if(ArrayFu::index($options, 'data', false)) curl_setopt($this->handler, CURLOPT_POSTFIELDS, $options['data']);
		if(ArrayFu::index($options, 'cookies', false)) curl_setopt($this->handler, CURLOPT_COOKIE, $options['cookies']);
 	}

 	public function send($url){
 		curl_setopt($this->handler, CURLOPT_URL, $url);
 		$this->response_body = curl_exec($this->handler);
 		$response = HttpResponse::separate($this->response_body, array('header_size' => curl_getinfo($this->handler, CURLINFO_HEADER_SIZE)));
		return $response;
 	}

 	public function close(){
 		curl_close($this->handler);
 		$this->handler = null;
 		unset($this->handler);
 	}

 	public static function create($url, $options = array()){
 		$request = new Requester($options);
 		$returning = $request->send($url);
 		$request->close();
 		return $returning;
 	}
 }
?>