<?php
	require_once RASP_RESOURCES_PATH . 'abstract_resource.php';

	class RaspMemory extends RaspAbstractResource {
		public static function free(&$variable){
			if (method_exists($variable,'__destroy')) $variable->__destroy();
			$variable = null;
		}

		public static function show(){
			print "Memory Usage: " . memory_get_usage();
		}
	}
?>