<?php

	require_once RASP_PATH . 'abstract_model.php';
	require_once RASP_TYPES_PATH . 'string.php';
	require_once RASP_TYPES_PATH . 'array.php';

	class RaspItem extends RaspAbstractModel {

		public static $table_name = 'items';
		public $attributes = array();
		public $fields = array('formatted_price' => 'formated_amount');

		public function RaspItem($params = array()){
			foreach($params as $attribute => $value) $this->set($attribute, $value);
		}

		public function set($attribute, $value){
			$this->attributes[RaspString::underscore($attribute)] = $value;
			eval("return \$this->" . RaspString::underscore($attribute) . " = \$value;");
		}

		public function save($db_object){
			return $db_object->query('INSERT INTO ' . self::$table_name . '(' . join(',', self::escape($this->attributes(), $db_object, '`')) . ') VALUES (' . join(',', self::escape($this->values(), $db_object)) . ');');
		}

		public static function escape($array, $db_object, $escaper = "'"){
			foreach($array as $key => $element)	$array[$key]  = $escaper . $db_object->escape($element) . $escaper;
			return $array;
		}

		public function attributes(){
			$attributes = array();
			foreach($this->attributes as $attribute => $value) $attributes[] = in_array($attribute, RaspArray::keys($this->fields)) ? $this->fields[$attribute] : $attribute;
			return $attributes;
		}

		public function values(){
			$values = array();
			foreach($this->attributes as $attribute => $value) $values[] = $value;
			return $values;
		}
	}

	class RaspItemsCollection {
		public static $current = null;

		public $items = array(), $last = null;

		public function RaspItemsCollection(){
			self::$current = $this;
		}

		public function add($item){
			$this->items[] = $item;
			$this->last = &$this->items[count($this->items) - 1];
			return true;
		}

		public function save_all($db_object){
			$returning = true;
			foreach($this->items as $item) $returning = $returning && $item->save($db_object);
			return $returning;
		}
	}
?>