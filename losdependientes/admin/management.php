<?php
  $manage_class = $_GET['manage_class'];
  $page_URL = "index.php?section=".$_GET['section']."&page=".$_GET['page'].(($_GET['action'])?"&action=".$_GET['action']:"").(($_GET['filter'])?"&filter=".$_GET['filter']:""); 
  // previously: $page_URL = substr($_SERVER["REQUEST_URI"], strrpos($_SERVER["REQUEST_URI"], "/") + 1);
  
  if( isset($_GET['id'] )){
    $object_id = $_GET['id']; 
  } else {
    $object_id = 0;
  }
  
  if(isset($_POST['filtertxt'])){
  	$_GET['filter'] = $_POST['filtertxt'];
  }
  
  switch ($manage_class){
    case "Critica":
      $an_object = new Critica($object_id);
    break;
    case "Pelicula":                
      $an_object = new Pelicula($object_id);
    break;
    case "Genero":           
      $an_object = new Genero($object_id);
    break;
    case "Noticia":           
      $an_object = new Noticia($object_id);
    break;
    /*case "Evento":           
      $an_object = new Evento($object_id);
    break;*/
    case "Libro":           
      $an_object = new Libro($object_id);
    break;
    case "Persona":           
      $an_object = new Persona($object_id);
    break;
  }                
  
  if (($_GET['page']=='criticas') || ($_GET['page']=='libros')){
	  if(! isset($_GET['sortby'])){ $_GET['sortby']="id";}             
	  if(! isset($_GET['desc'])){ $_GET['desc']="1";}             
  } elseif ($_GET['page']=='noticias') {
	  if(! isset($_GET['sortby'])){ $_GET['sortby']="fecha";}                   
	  if(! isset($_GET['desc'])){ $_GET['desc']="1";}       
  } else {
	  if(! isset($_GET['sortby'])){ $_GET['sortby']="id";}  
  }
  
  switch ($_GET['action']){
    case "create":
      if ($_POST['frm_create_'.$manage_class.'_submit']){
        unset($_POST['frm_create_'.$manage_class.'_submit']); 
        
        if (isset($_FILES)){
          save_uploaded_files();
          unset($_POST['MAX_FILE_SIZE']);
        }
        
        $saved_fields = save_embedded_objects($an_object, $_POST);
        foreach($saved_fields as $key => $value){
            $_POST[$key] = $value;
        }                                        
        
        //echo "<pre>".print_r($_POST, 1)."</pre>";
        
        $an_object->setFields($_POST);
        if($an_object->validate()){
          $new_id = $an_object->save();
          if ($new_id){
            echo "<p>".$manage_class." #".$new_id." ha sido creado.</p>";
            $page_URL = "index.php?section=".$_GET['section']."&page=".$_GET['page'];
            echo $an_object->getLayoutManager()->getViewableList($page_URL, $_GET['sortby'], $_GET['desc']);
          } else {                                                                      
            echo "<p>Nuevo ".$manage_class." no pudo ser creado.</p>";
          }
        } else {
          $validation_errors = $an_object->getValidationErrors(); 
          echo "<p>Asegur&aacute;te de ingresar todos los campos requeridos:<br />".$validation_errors."</p>";
          echo $an_object->getLayoutManager()->getCreateForm($pageURL);
        }
      } else {
        echo $an_object->getLayoutManager()->getCreateForm($pageURL);
      }
    break;
    case "edit":
      if ($_POST['frm_update_'.$manage_class.'_submit']){
        unset($_POST['frm_update_'.$manage_class.'_submit']); 
		
        if (isset($_FILES)){
          $uploaded = save_uploaded_files();
		  //foreach ($uploaded as $key => $file){ $_POST[$key] = $file; }
          unset($_POST['MAX_FILE_SIZE']);
		  //die("<pre>".print_r($_POST,true)."</pre>");
        }
        
		//die("<pre>".print_r($_POST,true)."</pre>");
        $saved_fields = save_embedded_objects($an_object, $_POST);
        foreach($saved_fields as $key => $value){
            $_POST[$key] = $value;
        }                                        
                
        //echo "<pre>".print_r($_POST, 1)."</pre>";         die();        
        
        $an_object->setFields($_POST);
        if($an_object->validate()){
          $existing_id = $an_object->save();
          if ($existing_id){
            echo "<p>".$manage_class." #".$existing_id." ha sido actualizado.</p>";
            $page_URL = "index.php?section=".$_GET['section']."&page=".$_GET['page'];
            echo $an_object->getLayoutManager()->getViewableList($page_URL, $_GET['sortby'], $_GET['desc']);
          } else {                                                                      
            echo "<p>".$manage_class." no pudo ser actualizado.</p>";
          }
        } else {
          $validation_errors = $an_object->getValidationErrors(); 
          echo "<p>Asegur&aacute;te de ingresar todos los campos requeridos:<br />".$validation_errors."</p>";
          echo $an_object->getLayoutManager()->getUpdateForm($pageURL);
        }
      } else {
        echo $an_object->getLayoutManager()->getUpdateForm($pageURL);
      }
    break;
    case "delete":
      if ($_POST['frm_delete_'.$manage_class.'_submit']){
        if ($an_object->delete()){
          echo "<p>".$manage_class." #".$object_id." ha sido borrado.</p>";
          $page_URL = "index.php?section=".$_GET['section']."&page=".$_GET['page'];
          echo $an_object->getLayoutManager()->getViewableList($page_URL, $_GET['sortby'], $_GET['desc']);
        }
      } else {     
        echo $an_object->getLayoutManager()->getDeleteForm($pageURL);
      }
    break;
    default:
      $page_URL = "index.php?section=".$_GET['section']."&page=".$_GET['page'];
      echo $an_object->getLayoutManager()->getViewableList($page_URL, $_GET['sortby'], $_GET['desc'], $_GET['filter']);
    break;
  }
  
  function save_uploaded_files(){
  	$uploaded = array();
    if (isset($_FILES)){
      foreach($_FILES as $uploadedfile => $a_file){
	  	if (trim($a_file['name']) != ''){
			//die($uploadedfile);
			// echo "<pre>".print_r($a_file,true)."</pre>";
			$pos = strrpos($a_file['name'], ".");
			$ext = substr($a_file['name'], $pos + 1);
			// $target_path = "../uploads/".sanitizeFileName(basename( $a_file['name'] )); // original
			$new_file_name = genRandomString().".".$ext; //random name
			$target_path = "../uploads/".$new_file_name;
			if(move_uploaded_file($a_file['tmp_name'], $target_path)) {
			  if (chmod($target_path, 0777)){
				// $_POST[$uploadedfile] = sanitizeFileName(basename( $a_file['name'] )); // original
				$_POST[$uploadedfile] = $new_file_name;
				//$uploaded[$uploadedfile] = $new_file_name;
			  } else {
				die("Error chmoding uploaded file");
			  }
			} else {
				die("Error moving uploaded file. name: ".$a_file['name']." - tmp_name: ".$a_file['tmp_name']. " - target: ".$target_path);
			}
		}
      }
    }
	//die("<pre>".print_r($uploaded,true)."</pre>");
	return $uploaded;
  }
  
  function sanitizeFileName($dangerous_filename){
    $dangerous_characters = array(" ", '"', "'", "&", "/", "\\", "?", "#", "á", "Á", "é", "É",
                                  "í", "Í", "ó", "Ó", "ú", "Ú", "ñ", "Ñ");
    // every forbidden character is replaced by an underscore
    return str_replace($dangerous_characters, '_', $dangerous_filename);
  }
  
  function save_embedded_objects($an_object, $post_data){
    //Try to save embedded objects
    $saved_fields = array();
    $field_types = $an_object->getField('field_types');
    $keys = array_keys ($field_types, 'embedded_object');
	
    foreach ($keys as $emb_field){     
       $data = array();
       foreach ($post_data as $post_field => $post_value){
           if (strpos($post_field, $emb_field."_") === 0){
              $new_key = substr($post_field, strlen($emb_field."_"));
              $data[$new_key] = $post_value;
              unset($post_data[$post_field]);
           }
       }                       
       $objects = $an_object->getField('objects');
       $class = $objects[$emb_field]['class_name'];
       $new_object = new $class($data['id']);
       $new_object->setFields($data);      
	   
       if($new_object->validate()){
           $new_object->save();
           $saved_fields[$emb_field] = $new_object->getField('id');
       } else {
           $saved_fields[$emb_field] = '';
       }    
    }  
    return $saved_fields;
  }
	
	function genRandomString($length = 10) {
		$characters = '0123456789abcdefghijklmnopqrstuvwxyz';
		$string = '';    
		for ($p = 0; $p < $length; $p++) {
			$string .= $characters[mt_rand(0, strlen($characters))];
		}
		return $string;
	}
?>