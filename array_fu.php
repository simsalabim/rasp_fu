<?php
	
	/**
	 * @author cheef, simsalabim
	 * Adding array functionalyto into project
	 */
	
	class ArrayFu {
		
		/**
		 * @return array of keys of input array
		 * @param array $array
		 */
		public static function keysAsValues($array){
			$result = array();
			foreach ($array as $key => $value)
				$result[$value] = $value;		
			return $result;
		}
		
		/**
		 * @return value of first element of input array (or it's key if $returnKey is true)
		 * @param array $array
		 */
		public  static function first($array, $returnKey = false){
			foreach($array as $key => $element) if($returnKey) return $key; else return $element;
		}
		
		/**
		 * @return value of second element of input array (or it's key if $returnKey is true)
		 * @param array $array
		 */
		function second($array, $returnKey = false){
			$counter = 1;
			foreach($array as $key => $element)
				if($counter == 2) if($returnKey) return $key; else return $element;
				$counter++;
			return array();
		}
		
		/**
		 * @return value of last element of input array (or it's key if $returnKey is true)
		 * @param array $array
		 * @param bool $returnKey[optional]
		 */
		public static function last($array, $returnKey = false){
			$counter = 0;
			foreach($array as $key => $element){
				if($counter == count($array) - 1)
					if ($returnKey) return $key;
					else return $element;
				$counter++;
			}
		}
		
		/**
		 * @return value of element given by defined index from input array if it exists, $returning if not
		 * @param array $array
		 * @param string $index
		 * @param [bool] $returning[optional]
		 */
		public static function getIndex($array, $index, $returning = false){
			if(isset($array[$index]) && !empty($array[$index])) return $array[$index];
			return $returning;
		}
		
		/**
		 * @return associative array with keys 'key' and 'value' containing sequentively key and value of searching element of input array
		 * @param object $array
		 * @param int $sequentive[optional] sequentive number of searching element
		 */
		public static function getAssocPair($array, $sequentive = 0){
			$index = 0;
			foreach($array as $key => $value){
				if($sequentive == $index) return array('key' => $key, 'value' => $value);
				$index++;
			}
			return false;
		}
		
		/**
		 * @return true if element of input array with given index exists and not empty, else false. Private method
		 * @param array $array
		 * @param string $index
		 */
		private function isNotEmptyCheck($array, $index){
			return (isset($array[$index]) && !empty($array[$index]));
		}
	
		/**
		 * @return true if element(s) of input array with given indexe(s) exist and not empty, else false
		 * @param array $array
		 * @param array or string $indexes  array of strings or a single string(if you wanna check only 1 element).
		 */
		public static function isNotEmpty($array, $indexes){
			if(is_array($indexes)) {
				foreach($indexes as $index)
					if(!self::isNotEmptyCheck($array, $index)) return false;
				return true;
			}
			return self::isNotEmptyCheck($array, $indexes);
		}
		
		/**
		 * @return true if element of input array with given index exists and is empty, else false. Private method
		 * @param array $array
		 * @param string $index
		 */
		private function isEmptyCheck($array, $index){
			if (!isset($array[$index])) return true;
			if (isset($array[$index]) && ($array[$index] == false)) return false;
			return (isset($array[$index]) && empty($array[$index]));
		}
	
		/**
		 * @return true if element(s) of input array with given indexe(s) exist and are empty, else false
		 * @param array $array
		 * @param array or string $indexes  array of strings or a single string(if you wanna check only 1 element)
		 */
		public static function isEmpty($array, $indexes){
			if(is_array($indexes)){
				foreach($indexes as $index)
					if(!self::isEmptyCheck($array, $index)) return false;
				return true;
			}
			return self::isEmptyCheck($array, $indexes);
		}
		
		/**
		 * @return true if element of input array with given index exists and it's value returns true. Else false
		 * @param array $array
		 * @param index $index
		 */
		public static function isTrue($array, $index){
			return ((isset($array[$index]) && $array[$index]) ? true : false);
		}
		
		/**
		 * @return array $collection without subtracted $array
		 * @param array $collection
		 * @param array $array
		 */
		public static function subtract($collection, $array){
			foreach ($collection as $key => $element)
				if ($element == $array) unset($collection[$key]);
			return $collection;
		}
	
		/**
		 * @return value of an element of input array with given index. Also removes this element from input array
		 * @param array $array
		 * @param string $index
		 */
		public static function delete(&$array, $index){
			$value = $array[$index];
			unset($array[$index]);
			return $value;
		}

	}

?>