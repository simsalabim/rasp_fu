<?php
	class Memory {
		public static function free(&$variable){
			if (method_exists($variable,'__destroy')) $variable->__destroy();
			$variable = null;
			unset($variable);
		}

		public static function show(){
			print "Memory Usage: " . memory_get_usage();
		}
	}
?>