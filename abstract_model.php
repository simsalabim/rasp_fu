<?php
	class RaspAbstractModel {

		public function __destruct(){
			$attributes = get_object_vars($this);
			foreach($attributes as $attribute_name => $value) eval("\$this->$attribute_name = null;");
		}
	}
?>