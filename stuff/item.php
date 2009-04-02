<?php
	class Item extends AbstractModel{
		public static $table_name = 'items';

		public $inside = false, $attributes = array(), $rewrite_attributes = array(), $formating_rules = array();

		public function Item($attributes, $rules = array()){
			if(isset($attributes) && is_array($attributes)){
				foreach($rules as $name => $key){
					$this->attributes[] = $key;
					$this->rewrite_attributes[] = $name;
				}
				$this->formating_rules = $rules;
				foreach($attributes as $attribute_name => $value)
					if(in_array($attribute_name, $this->rewrite_attributes))	eval("\$this->" . $this->formating_rules[$attribute_name] . " = \$value;");
					elseif($attribute_name == 'inside') $this->inside = $value;
			}
		}

		public static function create($attributes, $rules = array()){
			$item = new Item($attributes, $rules);
			return $item;
		}

		public function save($db_object){
			return $db_object->query('INSERT INTO ' . self::$table_name . '(' . join(',', self::to_escaped_string($this->attributes, $db_object, '`')) . ') VALUES (' . join(',', self::to_escaped_string($this->values(), $db_object)) . ');');
		}

		public function values(){
			$values = array();
			foreach($this->attributes as $attribute_name){
				eval("\$values[] = \$this->$attribute_name;");
			}
			return $values;
		}

		public function update_attribute($attribute_name, $value){
			if(in_array($attribute_name, $this->rewrite_attributes)){
				eval("\$this->" . $this->formating_rules[$attribute_name] . " = \$value;");}
			elseif($attribute_name == 'inside') $this->inside = $value;
		}

		public static function to_escaped_string($array, $db_object, $escaper = "'"){
			foreach($array as $key => $element)	$array[$key]  = $escaper . $db_object->escape($element) . $escaper;
			return $array;
		}
	}

	class ItemsCollection {
		public static $current = null;
		public $formating_rules = array();

		public $items = array(), $last = null;

		public function ItemsCollection($rules = array()){
			self::$current = $this;
			$this->formating_rules = $rules;
		}

		public function push_with($attributes){
			$item = Item::create($attributes, $this->formating_rules);
			return $this->add($item);
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