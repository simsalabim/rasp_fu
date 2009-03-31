<?php
	class RaspMemory {
		public static function free(&$variable){
			if (method_exists($variable,'__destroy')) $variable->__destroy();
			$variable = null;
		}
	}
?>