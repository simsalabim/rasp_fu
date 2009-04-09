<?php
	/**
	 * @author cheef, simsalabim
	 * Adding array functionality into project
	 */

	require_once RASP_TYPES_PATH . 'abstract_type.php';

	class RaspArray extends RaspAbstractType {

		public static function revert($array){
			$result = array();
			foreach ($array as $key => $value) $result[$value] = $value;
			return $result;
		}

		public static function keys($array){
			$result = array();
			foreach($array as $key => $value) $result[] = $key;
			return $result;
		}
		/**
		 * @return mixed $element(or $key)  value of first element of input array (or it's key if $returnKey is true)
		 * @param array $array
		 */
		public  static function first($array, $return_key = false){
			foreach($array as $key => $element) return ($return_key ?  $key : $element);
		}

		/**
		 * @return mixed $element(or $key)  value of second element of input array (or it's key if $returnKey is true)
		 * @param array $array
		 */
		function second($array, $return_key = false){
			$counter = 1;
			foreach($array as $key => $element){
				if($counter == 2) return ($return_key ?  $key : $element);
				$counter++;
			}
			return null;
		}

		/**
		 * @return mixed $element(or $key)  value of last element of input array (or it's key if $returnKey is true)
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
		public static function index($array, $index, $returning = false){
			if(isset($array[$index]) && !empty($array[$index])) return $array[$index];
			return $returning;
		}

		/**
		 * @return array('key' => $key, 'value' => $value) associative array with keys 'key' and 'value' containing sequentively key and value of searching element of input array
		 * @param object $array
		 * @param int $sequentive[optional] sequentive number of searching element
		 */
		public static function get_assoc_pair($array, $sequentive = 0){
			$index = 0;
			foreach($array as $key => $value){
				if($sequentive == $index) return array('key' => $key, 'value' => $value);
				$index++;
			}
			return false;
		}

		/**
		 * @return bool true if element of input array with given index exists and not empty, else false. Private method
		 * @param array $array
		 * @param string $index
		 */
		private function is_not_empty_check($array, $index){
			return (isset($array[$index]) && !empty($array[$index]));
		}

		/**
		 * @return bool true if element(s) of input array with given indexe(s) exist and not empty, else false
		 * @param array $array
		 * @param array or string $indexes  array of strings or a single string(if you wanna check only 1 element).
		 */
		public static function is_not_empty($array, $indexes){
			if(is_array($indexes)) {
				foreach($indexes as $index)
					if(!self::is_not_empty_check($array, $index)) return false;
				return true;
			}
			return self::is_not_empty_check($array, $indexes);
		}

		/**
		 * @return bool true if element of input array with given index exists and is empty, else false. Private method
		 * @param array $array
		 * @param string $index
		 */
		private function is_empty_check($array, $index){
			if (!isset($array[$index])) return true;
			if (isset($array[$index]) && ($array[$index] == false)) return false;
			return (isset($array[$index]) && empty($array[$index]));
		}

		/**
		 * @return bool true if element(s) of input array with given indexe(s) exist and are empty, else false
		 * @param array $array
		 * @param array or string $indexes  array of strings or a single string(if you wanna check only 1 element)
		 */
		public static function is_empty($array, $indexes){
			if(is_array($indexes)){
				foreach($indexes as $index)
					if(!self::is_empty_check($array, $index)) return false;
				return true;
			}
			return self::is_empty_check($array, $indexes);
		}

		/**
		 * @return bool true if element of input array with given index exists and it's value returns true. Else false
		 * @param array $array
		 * @param index $index
		 */
		public static function is_true($array, $index){
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
		 * @return mixed  $value of an element of input array with given index. Also removes this element from input array
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