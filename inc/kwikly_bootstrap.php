<?php
	/* Kwikly Framework Bootstrap file */

	/* Site name - this is used in page titles */
	$site_name = "Grupo ITS";

	/* Site root, several server settings may be configured */
	$site_root = "";
	switch ($_SERVER['SERVER_NAME']){
		case 'localhost':
		  //$site_root = "http://urdinola.com.ar/grupoits/";
		  $site_root = "localhost/grupoits/";
		break;
		case 'urdinola.com.ar':
		  $site_root = "http://urdinola.com.ar/grupoits/";
		break;
		case 'grupoits.com.ar':
		  $site_root = "http://grupoits.com.ar/";
		break;
		case 'jupish.com.ar':
		  $site_root = "http://jupish.com.ar/grupoits/";
		break;
	}

	/* Default language & available languages */
	/* TODO: internationalization wasn't implemented yet. */
	$lang = new Language('es');
	$GLOBALS['lang'] = $lang;

	/* List your business model classes */
	$model_classes = array(
		"Menu",
		"Pagina",
		"Layout",
		'Componente',
		'Carrousel',
		'SlideCarrousel',
		'TextoConFormato',
		'CodigoHTML',
		'BannerHome',
		'NoticiasHome',
		'PaginaNoticiaHome',
		'BannerTitulo',
		'ComponentePagina'
	);

	/* Database connections, per server */
	/* List the connection strings for each of your servers (default: localhost) */
	  switch ($_SERVER['SERVER_NAME']){
		case 'localhost':
		  $GLOBALS['db'] = new Database('localhost', 'root', 'chingale', 'grupoits' );
		break;
		case 'jupish.com.ar':
		  $GLOBALS['db'] = new Database('localhost', 'grupoits', 'user', 'password' );
		break;
		case 'grupoits.com.ar':
		  $GLOBALS['db'] = new Database('localhost', 'x018vm02', 'Usuario001' , 'x018vm02_Grupoits');
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
		case 'grupoits.com.ar':
			error_reporting(0);
		break;
		case 'jupish.com.ar':
			error_reporting(0);
		break;
	  }

	/* Admin login username and password */
	/* TODO: (this should be saved encrypted in the database) */
	$admin_user = 'admin';
	$admin_pass = 'password';

	/* Admin definition */
	/* Set up Sections, Pages and for each page, a manageable class */
	$admin_sections = array(
		'contenido' => array(
			'menu' => 'Contenido',
			'pages' => array(
				'paginas' => array(
					'menu' => 'P&aacute;ginas',
					'title' => 'Administraci&oacute;n de P&aacute;ginas',
					'manage_class' => 'Pagina'
				),
				'menues' => array(
					'menu' => 'Men&uacute;es',
					'title' => 'Administraci&oacute;n de Men&uacute;es',
					'manage_class' => 'Menu'
				)
			)
		),
		'home_page' => array(
			'menu' => 'Home Page',
			'pages' => array(
				'marquesina' => array(
					'menu' => 'Marquesina',
					'title' => 'Administraci&oacute;n de Marquesina',
					'manage_class' => 'Carrousel'
				),
				'noticias' => array(
					'menu' => 'Noticias',
					'title' => 'Administraci&oacute;n de Noticias',
					'manage_class' => 'NoticiasHome'
				),
				'banners' => array(
					'menu' => 'Banners',
					'title' => 'Administraci&oacute;n de Banners',
					'manage_class' => 'BannerHome'
				)
			),
			"hide" => true
		),
		'layouts' => array(
			'menu' => 'Layouts',
			'pages' => array(
				'layouts' => array(
					'menu' => 'Layouts',
					'title' => 'Administraci&oacute;n de Layouts',
					'manage_class' => 'Layout'
				)
			),
			"hide" => true
		),
		'componentes' => array(
			'menu' => 'Componentes',
			'pages' => array(
				'marquesinas' => array(
					'menu' => 'Marquesinas',
					'title' => 'Marquesinas',
					'manage_class' => 'Carrousel'
				),
				'slides' => array(
					'menu' => 'Slide de Marquesina',
					'title' => 'Slide de Marquesina',
					'manage_class' => 'SlideCarrousel'
				),
				'textos' => array(
					'menu' => 'Textos',
					'title' => 'Textos',
					'manage_class' => 'TextoConFormato'
				),
				'codigo_html' => array(
					'menu' => 'Codigos HTML',
					'title' => 'Codigos HTML',
					'manage_class' => 'CodigoHTML'
				),
				'banners_home' => array(
					'menu' => 'Banners Home',
					'title' => 'Banners Home',
					'manage_class' => 'BannerHome'
				),
				'noticias_home' => array(
					'menu' => 'Noticias Home',
					'title' => 'Noticias Home',
					'manage_class' => 'NoticiasHome'
				),
				'pagina_noticias' => array(
					'menu' => 'P&aacute;gina de Noticias Home',
					'title' => 'P&aacute;gina de Noticias Home',
					'manage_class' => 'PaginaNoticiaHome'
				),
				'banners_titulo' => array(
					'menu' => 'Banners de Titulo',
					'title' => 'Banners de Titulo',
					'manage_class' => 'BannerTitulo'
				)
			),
			"hide" => true
		)
	);

	/**
	* Magic autoload function
	* used to include the appropriate class files when they are needed
	* @param String the name of the class
	*/
	function spl_autoload_register( $class_name )
	{
		if (file_exists(dirname(__FILE__).'/../classes/' . $class_name.'.class.php')){
			require_once(dirname(__FILE__).'/../classes/' . $class_name.'.class.php' );
		} elseif (file_exists(dirname(__FILE__).'/../classes/system/' . $class_name.'.class.php')) { //for system classes
			require_once(dirname(__FILE__).'/../classes/system/' . $class_name.'.class.php' );
		}
	}
?>
