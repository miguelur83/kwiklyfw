<?php

  include("../inc/kwikly_bootstrap.php");
  
  if(isset($_GET)){
    $field_name = $_GET['field_name'];
    $suggestions = array();
	$data = array();
    switch ($field_name){
      case 'pelicula_director':
      case 'critico':
      case 'autor':    
      case 'director':
	  	if ($pos = strpos($field_name, "_")){
			$tipo = substr($field_name, $pos + 1);
		} else {
			$tipo = $field_name;
		}
        $una_persona = new Persona();
        $results = $una_persona->getAll("'nombre'", 0, "nombre LIKE '".$_GET['query']."%' AND tipo = '".$tipo."'");
        foreach($results as $a_result){
          $suggestions[] = $a_result['nombre'];
        }
      break;
      case 'evento':
        $un_evento = new Evento();
        $results = $un_evento->getAll("'nombre'", 0, "nombre LIKE '".$_GET['query']."%'");
        foreach($results as $a_result){
          $suggestions[] = $a_result['nombre'];
        }
      break;
      case 'genero':
      case 'pelicula_genero':
      case 'serie_genero':
        $un_genero = new Genero();
        $results = $un_genero->getAll("'nombre'", 0, "nombre LIKE '".$_GET['query']."%'");
        foreach($results as $a_result){
          $suggestions[] = $a_result['nombre'];
        }
      break;
      case 'pelicula_titulo':
      case 'titulo':
        $una_pelicula = new Pelicula();
        $results = $una_pelicula->getAll("'titulo'", 0, "titulo LIKE '".$_GET['query']."%'");
        foreach($results as $a_result){
          $suggestions[] = $a_result['titulo'];
        }
      break;
	  case 'elenco':
	  case 'pelicula_elenco':
	  	if ($pos = strpos($field_name, "_")){
			$tipo = substr($field_name, $pos + 1);
		} else {
			$tipo = $field_name;
		}
        $una_persona = new Persona();
        $results = $una_persona->getAll("'nombre'", 0, "nombre LIKE '".$_GET['query']."%' AND tipo = 'actor'");
        foreach($results as $a_result){
          $suggestions[] = $a_result['nombre'];
        }
	  break;
	  case 'pais':
	  	if ($pos = strpos($field_name, "_")){
			$tipo = substr($field_name, $pos + 1);
		} else {
			$tipo = $field_name;
		}
        $un_pais = new Pais();
        $results = $un_pais->getAll("'nombre'", 0, "nombre LIKE '".$_GET['query']."%'");
        foreach($results as $a_result){
          $suggestions[] = $a_result['nombre'];
        }
	  break;
    }
    
    $arr = array(
      "query" => $_GET['query'],
      "suggestions" => $suggestions,
	  "data" => $data
    );
    $log = fopen("log.txt", "a");
    fwrite($log, "GET: ".json_encode($_GET)."\r\n"."ANSWER: ".json_encode($arr)."\r\n\r\n");
    fclose($log);
    echo (json_encode($arr));
  }
?>