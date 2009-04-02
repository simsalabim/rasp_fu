<?php
	class XMLParser extends AbstractModel {
		public $handler = null;

		public function XMLParser($params){
			$this->handler = xml_parser_create();
			xml_set_element_handler($this->handler, $params['callbacks']['before'], $params['callbacks']['after']);
			xml_set_character_data_handler($this->handler, $params['callbacks']['data']);
		}

		public static function create($params){
			$parser = new XMLParser($params);
			return $parser;
		}

		public function work_with($data){
			$returning = xml_parse($this->handler, $data);
			$this->close();
			return $returning;
		}

		public function close(){
			xml_parser_free($this->handler);
			$this->__destruct();
		}
	}
?>