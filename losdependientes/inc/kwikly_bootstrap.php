<?php
	//Bootstrap Kwikly Framework:
	switch ($_SERVER['SERVER_NAME']){
		case 'localhost':
			//error_reporting(E_ALL - E_WARNING - E_NOTICE);
			ini_set('display_errors', '0');     # don't show any errors...
			error_reporting(E_ALL | E_STRICT);  # ...but do log them
			//error_reporting(E_ALL);
		break;
		case 'urdinola.com.ar':
			error_reporting(0);
		break;
		case 'losdependientes.com.ar':
			error_reporting(0);
		break;
	  }

	/**
	* Magic autoload function
	* used to include the appropriate class files when they are needed
	* @param String the name of the class
	*/
	function __autoload( $class_name )
	{
		if (file_exists(dirname(__FILE__).'/../classes/' . $class_name.'.class.php')){
		   require_once(dirname(__FILE__).'/../classes/' . $class_name.'.class.php' );
		}
	}

	$site_root = "";
	switch ($_SERVER['SERVER_NAME']){
		case 'localhost':
		  //$site_root = "http://urdinola.com.ar/losdependientes/";
		  $site_root = "localhost/losdependientes/";
		break;
		case 'urdinola.com.ar':
		  $site_root = "http://urdinola.com.ar/losdependientes/";
		break;
		case 'losdependientes.com.ar':
		  $site_root = "http://losdependientes.com.ar/";
		break;
	}


	//DB Connection
	  switch ($_SERVER['SERVER_NAME']){
		case 'localhost':
		  $GLOBALS['db'] = new Database('localhost', 'root', 'chingale', 'losdependientes' );
		break;
		case 'urdinola.com.ar':
		  $GLOBALS['db'] = new Database('localhost', 'jupishc_dependie', 'E466ZLNIUX6B', 'jupishc_losdependientes' );
		break;
		case 'losdependientes.com.ar':
		  $GLOBALS['db'] = new Database('localhost', 'ldepend_dependie', 'WBiivaROoMJu', 'ldepend_losdependientes' );
		break;
	  }
?>
