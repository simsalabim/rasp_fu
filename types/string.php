<?php

	require_once RASP_TYPES_PATH . 'abstract_type.php';

	class RaspString extends RaspAbstractType {

		public static function underscore($string) {
			return strtolower(preg_replace('/(?<=\w)([A-Z])(?=[a-z])/', '_\\1', $string));
		}
		
		function humanize($lowerCaseAndUnderscoredWord) {
			return ucwords(str_replace('_', ' ', $lowerCaseAndUnderscoredWord));
		}
	}
?>