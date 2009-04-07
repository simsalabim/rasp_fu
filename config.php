<?php
	class RaspConfig {

		protected $debugLevel;
		protected $environment;
		protected $debugLog;

		/**
		 * @return Config instance with properties defined by environment
		 * @param string $env[optional]
		 */
		public function Config($env = 'dev'){
			$this->debugLog =  dirname(__FILE__) . '/debug.log';
			return $this->set($this->set_environment($env));
		}

		/**
		 * @return quick sets properties of Config object with given values
		 * @param array $options[optional] associatiove arrays in format of array('Config property' => its value)
		 */
		public function set($options = array()){
			foreach($options as $key => $value){
				eval('$this->' . $key . ' = ' . $value . ';');
			}
		}

		/**
		 * @return value of Config property if it exists
		 * @param string $property
		 */
		public function get($property){
			eval('$result = $this->' . $property . ';');
			return $result;
		}

		/**
		 * @return array of config options depend of environment type defined below
		 * @param string $env
		 */
		public function set_environment($env){
			$this->_environment = $env;
			switch($this->_environment){
				case 'dev': case 'development': return array('debugLevel' => 1);
				case 'prod': case 'production': return array('debugLevel' => 0);
				default: return array('debugLevel' => 0);
			}
		}
	}
?>