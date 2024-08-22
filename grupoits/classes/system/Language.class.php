<?php
	class Language{
		protected $lang;
		protected $strings;
		
		function __construct($lang){
			$this->lang = $lang;
			$this->strings = array();
			
			if (file_exists(dirname(__FILE__).'/../../lang/lang-' . $this->lang.'.php')){
			   include(dirname(__FILE__).'/../../lang/lang-' . $this->lang.'.php');
			   $this->strings = $strings;
			} else {
				return null;
			}
		}
		
		function getLang(){
			return $this->lang;
		}
		
		function setLang($lang){
			$this->lang = $lang;
			
			if (file_exists(dirname(__FILE__).'/../lang/lang-' . $this->lang.'.php')){
			   include(dirname(__FILE__).'/../lang/lang-' . $this->lang.'.php');
			   $this->strings = $strings;
			   return true;
			} else {
				return false;
			}
		}
		
		function setStrings($strings){
			$this->strings = $strings;
		}
		
		function getString(){
			$args = array();
			$args = func_get_args();
			$str_id = array_shift($args);
			$str = $this->strings[$str_id];
			if (func_num_args()>1){
				return vsprintf($str, $args);
			} elseif (func_num_args() == 1) {
				return $str;
			} else {
				return null;
			}
		}
	}
?>