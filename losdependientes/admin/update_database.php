<?php
  include("../inc/kwikly_bootstrap.php");
  
  $db = $GLOBALS['db'];
  
  //Model Objects
  try{ 
    $objects = array(
      new Pelicula(),
      new Serie(),
      new Libro(),
      new Persona(),
      new Genero(),
      new Evento(),
      new Critica(),
	  new Elenco(),
	  new Noticia(),
	  new Pais()
    );
  } catch (Exception $error) {
    echo "Objects could not be instanciated.<br />"; die ($error->getMessage());
  }  
  
  foreach ($objects as $object){
    if ($db->table_exists($object->getField('table'))){
      echo "Table '".$object->getField('table')."' for ".get_class($object)." already exists.<br />";
      if($object->updateTable()){
        echo "Table '".$object->getField('table')."' for ".get_class($object)." has been updated.<br />";
      } else {
        echo "Table '".$object->getField('table')."' for ".get_class($object)." could not be updated.<br />";
      }
    } else {
      if($object->createTable()){
        echo "Table '".$object->getField('table')."' for ".get_class($object)." has been created.<br />";
      } else {
        echo "Table '".$object->getField('table')."' for ".get_class($object)." could not be created.<br />";
      }
    }
  }
?>