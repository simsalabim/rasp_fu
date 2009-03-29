<?php

	/**
	 * @author simsalabim, cheef
	 * Adding array functionalyto into project
	 */

	require_once 'config.php';
	
	class Utils {
		
		/**
		 * Prints $value with info about file/line where debug was called. writes it into log if $logging is true prepending with $startlog phrase
		 * @return void
		 * @param mixed $value[optional]
		 * @param bool $logging[optional]
		 * @param string $startLog[optional]
		 */
		public static function debug($value = null, $logging = false, $startLog = 'log debug'){
			$config = new Config();
			switch($config->get('debugLevel')){
				case 0: return;
				case 1: {
					$backtrace = debug_backtrace();
					if(!$logging){
						$title = '<strong>' . $backtrace[0]['file'] . '</strong>&nbsp;(line <strong>' . $backtrace[0]['line'] . '</strong>)';
						echo $title;
						echo '<pre>';
						print_r($value);
						echo '</pre>';
					} else{
						$title = $backtrace[0]['file'] . '(line ' . $backtrace[0]['line'] . ')';
						$debugLog = fopen($config->get('debugLog'), 'a');
						fwrite($debugLog, $startLog . ' ' . $title . ' ' . $value . chr(10));
						fclose($debugLog);				
					}
					break;
				}
			}
		}
		
		/**
		 * Same as debug but as an addition stop scripts
		 * Prints $value with info about file/line where debug was called. writes it into log if $logging is true prepending with $startlog phrase
		 * dies ;-)
		 * @return void
		 * @param mixed $value[optional]
		 * @param bool $logging[optional]
		 * @param string $startLog[optional]
		 */
		public static function debugDie($value = null, $logging = false, $startLog = 'log debug'){
			$config = new Config();
			switch($config->get('debugLevel')){
				case 0: return;
				case 1: {
					$backtrace = debug_backtrace();
					if(!$logging){
						$title = '<strong>' . $backtrace[0]['file'] . '</strong>&nbsp;(line <strong>' . $backtrace[0]['line'] . '</strong>)';
						echo $title;
						echo '<pre>';
						print_r($value);
						echo '</pre>';
					} else{
						$title = $backtrace[0]['file'] . '(line ' . $backtrace[0]['line'] . ')';
						$debugLog = fopen($config->get('debugLog'), 'a');
						fwrite($debugLog, $startLog . ' ' . $title . ' ' . $value . chr(10));
						fclose($debugLog);	
					}
					die;
				}
			}
		}
		
		/**
		 * RFC822 Email Parser By Cal Henderson <cal@iamcal.com>
		 * This code is licensed under a Creative Commons Attribution-ShareAlike 2.5 License
		 * @return true if input e-mail is valid, false if not
		 * @param string $email
		 */
		public static function isEmailValid($email){
			$qtext = '[^\\x0d\\x22\\x5c\\x80-\\xff]';
	        $dtext = '[^\\x0d\\x5b-\\x5d\\x80-\\xff]';
	        $atom = '[^\\x00-\\x20\\x22\\x28\\x29\\x2c\\x2e\\x3a-\\x3c'.
	            '\\x3e\\x40\\x5b-\\x5d\\x7f-\\xff]+';
	        $quoted_pair = '\\x5c[\\x00-\\x7f]';
	        $domain_literal = "\\x5b($dtext|$quoted_pair)*\\x5d";
	        $quoted_string = "\\x22($qtext|$quoted_pair)*\\x22";
	        $domain_ref = $atom;
	        $sub_domain = "($domain_ref|$domain_literal)";
	        $word = "($atom|$quoted_string)";
	        $domain = "$sub_domain(\\x2e$sub_domain)*";
	        $local_part = "$word(\\x2e$word)*";
	        $addr_spec = "$local_part\\x40$domain";

	        return preg_match("!^$addr_spec$!", $email) ? true : false;
		}

	}

?>