<?php
	/* Kwikly Framework Bootstrap file */

	/* Site name - this is used in page titles */
	$site_name = "Vinos del Mundo";

	/* Site root, several server settings may be configured */
	$site_root = "";
	switch ($_SERVER['SERVER_NAME']){
		case 'localhost':
		  //$site_root = "http://urdinola.com.ar/gwines/";
		  $site_root = "localhost/globalwinesllc/";
		break;
		case 'urdinola.com.ar':
		  $site_root = "http://urdinola.com.ar/gwines/";
		break;
		case 'globalwinesllc.com':
		  $site_root = "http://globalwinesllc.com/";
		break;
		case 'jupish.com.ar':
		  $site_root = "http://jupish.com.ar/gwines/";
		break;
	}

	/* Default language & available languages */
	/* TODO: internationalization wasn't implemented yet. */
	$lang = new Language('en');
	$GLOBALS['lang'] = $lang;

	/* List your business model classes */
	$model_classes = array(
		'Winery',
		'Line',
		'Wine',
		'Media',
		'Country',
		'MediaSection'
	);

	/* Database connections, per server */
	/* List the connection strings for each of your servers (default: localhost) */
	  switch ($_SERVER['SERVER_NAME']){
		case 'localhost':
		  $GLOBALS['db'] = new Database('localhost', 'root', 'chingale', 'gwines' );
		break;
		case 'jupish.com.ar':
		  $GLOBALS['db'] = new Database('localhost', 'jupishc_gwines', 'gl0balw1n3s', 'jupishc_gwines' );
		break;
		case 'globalwinesllc.com':
		  $GLOBALS['db'] = new Database('localhost', 'uv013037_gwines', 'aPe1RzyMWV', 'gwines' );
		break;
	  }

	/* Error Reporting settings, per server */
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
		case 'globalwinesllc.com':
			error_reporting(0);
		break;
		case 'jupish.com.ar':
			error_reporting(0);
		break;
	  }

	/* Admin login username and password */
	/* TODO: (this should be saved encrypted in the database) */
	$admin_user = 'admin';
	$admin_pass = 'Gl0b@lW1n3s';

	/* Admin definition */
	/* Set up Sections, Pages and for each page, a manageable class */
	$admin_sections = array(
		'wineries' => array(
			'menu' => 'Manage Wineries',
			'pages' => array(
				'wineries' => array(
					'menu' => 'Wineries',
					'title' => 'Manage Wineries',
					'manage_class' => 'Winery'
				),
				'lines' => array(
					'menu' => 'Lines',
					'title' => 'Manage Wineries - Lines',
					'manage_class' => 'Line'
				),
				'wines' => array(
					'menu' => 'Wines',
					'title' => 'Manage Wineries - Wines',
					'manage_class' => 'Wine'
				),
				'countries' => array(
					'menu' => 'Countries',
					'title' => 'Manage Countries',
					'manage_class' => 'Country'
				)
			)
		),
		'posmedia' => array(
			'menu' => 'Manage POS / Media',
			'pages' => array(
				'posmedia' => array(
					'menu' => 'POS / Media',
					'title' => 'Manage POS / Media',
					'manage_class' => 'Media'
				),
				'mediasections' => array(
					'menu' => 'Sections',
					'title' => 'Manage Media Sections',
					'manage_class' => 'MediaSection'
				)
			)
		)
	);

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
?>
