<?php
  // Session and login control
      session_start();
      if (! isset($_SESSION['logged_in'])){
        header("Location:login.php");
      }
      
      if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 1800)) {
        unset($_SESSION);
        session_destroy();
        header("Location:login.php?action=expired");
      }
      
      $_SESSION['LAST_ACTIVITY'] = time(); // update last activity time stamp
      
      if ($_GET['action'] == 'logout'){
        unset($_SESSION);
        session_destroy();
        header("Location:login.php?action=logged_out");
      }
  // END Session and login control
  
  include ("../inc/kwikly_bootstrap.php");
   
   $sections = array_keys($admin_sections);
   
	if (! $_GET['section']) { 
		$_GET['section'] = $sections[0]; 
	}
	if (! $_GET['page']) {
		$section = $_GET['section'];
		$_GET['page'] = key($admin_sections[$section]['pages']);
	}
	
  include ("head.php");
  include ("header.php");
	
  /*
  switch($_GET['section']){
    case "criticas":
      switch ($_GET['page']){
        case "criticas":
          $title = "Editar Criticas";
          $_GET['manage_class'] = "Critica";
        break;
        case "peliculas":
          $title = "Editar Peliculas / Series";
          $_GET['manage_class'] = "Pelicula";
        break;
        case "personas":
          $title = "Editar Personas";
          $_GET['manage_class'] = "Persona";
        break;
        case "generos":
          $title = "Editar Generos";
          $_GET['manage_class'] = "Genero";
        break;
        /*case "eventos":
          $title = "Editar Eventos";
          $_GET['manage_class'] = "Evento";
        break;
      }
    break;
    case "libros":    
      switch ($_GET['page']){
        case "libros":
          $title = "Editar Libros";
          $_GET['manage_class'] = "Libro";      
        break;      
        case "personas":
          $title = "Editar Personas";
          $_GET['manage_class'] = "Persona";
        break;
        case "generos":
          $title = "Editar Generos";
          $_GET['manage_class'] = "Genero";
        break;
      }
    break;
  }*/
  
  $section = $_GET['section'];
  $page = $_GET['page'];
  $title = $admin_sections[$section]['pages'][$page]['title'];
  $_GET['manage_class'] = $admin_sections[$section]['pages'][$page]['manage_class'];
  //die ($section." - ".$page." - ".$title." - ".$_GET['manage_class']);
  
  echo "<h1>".$title."</h1>";
  include ("management.php");
   
  include ("footer.php");
?>