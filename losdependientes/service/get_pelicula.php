<?php
	
  include("../inc/kwikly_bootstrap.php");
  
  if(isset($_GET)){
    $data = array();
    
	$una_pelicula = new Pelicula();
    $results = $una_pelicula->getAll("'titulo'", 0, "titulo LIKE '".$_GET['titulo']."'");
	
	if (isset($results[0])){
		$una_pelicula = new Pelicula($results[0]['id']);
		$data['id'] = $results[0]['id'];
		$data['titulo'] = $results[0]['titulo'];
		$data['tipo'] = $results[0]['tipo'];
		$data['anio'] = $results[0]['anio'];
		$data['elenco'] = $una_pelicula->getElencoString();
		$data['afiche'] = $results[0]['afiche'];
		$data['youtube_ID'] = $results[0]['youtube_ID'];
		$director = new Persona($results[0]['director']);
		$genero = new Genero($results[0]['genero']);
		$data['director'] = $director->getField('nombre');
		$data['genero'] = $genero->getField('nombre');
	}
    
    $arr = array(
      "query" => $_GET['titulo'],
	  "data" => $data
    );
    $log = fopen("log_peli.txt", "a");
    fwrite($log, "GET: ".json_encode($_GET)."\r\n"."ANSWER: ".json_encode($arr)."\r\n\r\n");
    fclose($log);
    echo (json_encode($arr));
  }
?>