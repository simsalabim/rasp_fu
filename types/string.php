<?php

	require_once RASP_TYPES_PATH . 'abstract_type.php';

	class RaspString extends RaspAbstractType {

		public static function underscore($string) {
			$string = strtolower(preg_replace('/(?<=\w)([A-Z])(?=[a-z])/', '_\\1', $string));
			return $string;
		}
	}
?>