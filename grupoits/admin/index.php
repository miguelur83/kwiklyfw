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
  //echo "<pre>".print_r($_POST, 1)."</pre>";die();
   //echo $_GET['collector_id'];echo $_GET['collector'];
   
   $sections = array_keys($admin_sections);
   
	if (! $_GET['section']) { 
		$_GET['section'] = $sections[0]; 
	}
	if (! $_GET['page']) {
		$section = $_GET['section'];
		$_GET['page'] = key($admin_sections[$section]['pages']);
	}
  
  
  $section = $_GET['section'];
  $page = $_GET['page'];
  $title = $admin_sections[$section]['pages'][$page]['title'];
  $_GET['manage_class'] = $admin_sections[$section]['pages'][$page]['manage_class'];
  //die ($section." - ".$page." - ".$title." - ".$_GET['manage_class']);
  $manage_class = $_GET['manage_class'];
  
  
  if(! isset($_POST['componente'])){
	  // Si estoy en la seccion componentes
	  if ($_GET['section']=='componentes'){
		// Si accion = editar
		if($_GET['action']=='edit'){
			//Si tengo component_id
			if(isset($_GET['componente_id'])){
				//Ver si existe el objeto
				$comp = new Componente($_GET['componente_id']);
				$the_class = $comp->getField('tipo');
				$the_object = new $the_class();
				$res = $the_object->getAll('',0,"componente=".$_GET['componente_id']);
				if(isset($res[0])){
					//Setear el ID
					$_GET['id'] = $res[0]['id'];
					//Editar
					$_GET['action']='edit';
				//Si no existe
				} else {
					//Crear
					$_GET['action']='create';
					if(($the_class == "Carrousel")||($the_class == "NoticiasHome")){
						$the_object = new $the_class();
						$the_object->setField("componente", $_GET['componente_id']);
						$_GET['id'] = $the_object->save();
						$_GET['action']='edit';
					}
				}
			//Si no tengo component id
			} else {
				//Crearlo c/link
				$comp = new Componente();
				$comp->setField('tipo', $manage_class);
				$comp_id = $comp->save();
				$link = new ComponentePagina();
				$link->setField('componente', $comp_id);
				$link->setField('pagina', $_GET['backpage']);
				$link->setField('seccion_layout', $_GET['layout_section']);
				$link->save();
				//Setear el compo_id
				$_GET['componente_id'] = $comp_id;
				
				if(($manage_class == "Carrousel")||($manage_class == "NoticiasHome")){
					$the_object = new $manage_class();
					$the_object->setField("componente", $_GET['componente_id']);
					$_GET['id'] = $the_object->save();
					$_GET['action']='edit';
				}
			}
		// Si accion = borrar
		} elseif($_GET['action']=='delete'){
			//Buscar el objeto
			$comp = new Componente($_GET['componente_id']);
			$the_class = $comp->getField('tipo');
			$the_object = new $the_class();
			$res = $the_object->getAll('',0,"componente=".$_GET['componente_id']);
			//echo $_GET['componente_id'];
			if(isset($res[0])){
				//Setear el ID
				$_GET['id'] = $res[0]['id'];
			}
		}
	  }	
  }
   
   
  
	//Save collection item
	if ((isset($_GET['collector_id'])) && (isset($_POST['frm_create_'.$manage_class.'_submit']))){
		$collector = new $_GET['collector']($_GET['collector_id']);
		$an_object = new $manage_class($object_id);
        
		//Save uploaded files
        if (isset($_FILES)){
          save_uploaded_files();
          unset($_POST['MAX_FILE_SIZE']);
        }
        
		//Save embedded objects
        $saved_fields = save_embedded_objects($an_object, $_POST);
        foreach($saved_fields as $key => $value){
            $_POST[$key] = $value;
        }                                        
        
        //echo "<pre>".print_r($_POST, 1)."</pre>";
        
        $an_object->setFields($_POST);
        if($an_object->validate()){
          $new_id = $an_object->save();
          if ($new_id){
			unset($_POST['frm_create_'.$manage_class.'_submit']); 
			$msg = "<p>".$lang->getString('msg_object_has_been_created', $manage_class, $new_id)."</p>";
			$page_URL = $collector->getField("manage_url");
			
			$urlparts = explode("?", $page_URL);
			$urlparts = explode("&", $urlparts[1]);
			$section = explode("=", $urlparts[0]);
			$page = explode("=", $urlparts[1]);
			$_GET['section'] = $section[1];
			$_GET['page'] = $page[1];
			$title = $admin_sections[$_GET['section']]['pages'][$_GET['page']]['title'];
			$manage_class = $_GET['collector'];
			$_GET['action'] = "edit";
			$_GET['id'] = $_GET['collector_id'];
			
			unset($_GET['collector']);
			
			$pageURL = "index.php?section=".$_GET['section']."&page=".$_GET['page']."&action=edit";
            /*echo "<p>".$lang->getString('msg_object_has_been_created', $manage_class, $new_id)."</p>";
            echo $an_object->getLayoutManager()->getViewableList($page_URL, $_GET['sortby'], $_GET['desc']);*/
          } else {              
			$msg = "<p>".$lang->getString('msg_object_could_not_be_created', $manage_class)."</p>";
            /*echo "<p>".$lang->getString('msg_object_could_not_be_created', $manage_class)."</p>";*/
          }
        } 
	} elseif ((isset($_GET['collector_id'])) && (isset($_POST['frm_update_'.$manage_class.'_submit']))){
		$collector = new $_GET['collector']($_GET['collector_id']);
		$an_object = new $manage_class($object_id);
		
		//Save uploaded files
		if (isset($_FILES)){
          $uploaded = save_uploaded_files();
          unset($_POST['MAX_FILE_SIZE']);
        }
        
		//Save embedded objects
        $saved_fields = save_embedded_objects($an_object, $_POST);
        foreach($saved_fields as $key => $value){
            $_POST[$key] = $value;
        }                          
                
        /*echo "<pre>".print_r($_POST, 1)."</pre>";         die();        */
        
        $an_object->setFields($_POST);
        if($an_object->validate()){
          $existing_id = $an_object->save();
          if ($existing_id){
			unset($_POST['frm_update_'.$manage_class.'_submit']); 
			$msg = "<p>".$lang->getString('msg_object_has_been_updated', $manage_class, $existing_id)."</p>";
			$page_URL = $collector->getField("manage_url");
			
			$urlparts = explode("?", $page_URL);
			$urlparts = explode("&", $urlparts[1]);
			$section = explode("=", $urlparts[0]);
			$page = explode("=", $urlparts[1]);
			$_GET['section'] = $section[1];
			$_GET['page'] = $page[1];
			$title = $admin_sections[$_GET['section']]['pages'][$_GET['page']]['title'];
			$manage_class = $_GET['collector'];
			$_GET['action'] = "edit";
			$_GET['id'] = $_GET['collector_id'];
			
			unset($_GET['collector']);
			
            $pageURL = "index.php?section=".$_GET['section']."&page=".$_GET['page']."&action=edit";
			/*echo "<p>".$lang->getString('msg_object_has_been_updated', $manage_class, $existing_id)."</p>";
            echo $an_object->getLayoutManager()->getViewableList($page_URL, $_GET['sortby'], $_GET['desc']);*/
          } else {                               
			$msg = "<p>".$lang->getString('msg_object_could_not_be_updated', $manage_class)."</p>";                                   
            /*echo "<p>".$lang->getString('msg_object_could_not_be_updated', $manage_class)."</p>";*/
          }
        }
	} elseif ((isset($_GET['collector_id'])) && (isset($_POST['frm_delete_'.$manage_class.'_submit']))){
		$collector = new $_GET['collector']($_GET['collector_id']);
		$object_id = $_GET['id'];
		$an_object = new $manage_class($object_id);
		
        if ($an_object->delete()){
			unset($_POST['frm_update_'.$manage_class.'_submit']); 
			$msg = "<p>".$lang->getString('msg_object_has_been_deleted', $manage_class, $object_id)."</p>";
			
			$page_URL = $collector->getField("manage_url");
			
			$urlparts = explode("?", $page_URL);
			$urlparts = explode("&", $urlparts[1]);
			$section = explode("=", $urlparts[0]);
			$page = explode("=", $urlparts[1]);
			$_GET['section'] = $section[1];
			$_GET['page'] = $page[1];
			$title = $admin_sections[$_GET['section']]['pages'][$_GET['page']]['title'];
			$manage_class = $_GET['collector'];
			$_GET['action'] = "edit";
			$_GET['id'] = $_GET['collector_id'];
			
			unset($_GET['collector']);
			
			$pageURL = "index.php?section=".$_GET['section']."&page=".$_GET['page']."&action=edit";
          /*echo "<p>".$lang->getString('msg_object_has_been_deleted', $manage_class, $object_id)."</p>";
          echo $an_object->getLayoutManager()->getViewableList($page_URL, $_GET['sortby'], $_GET['desc']);*/
        }
    } 
  
  include ("head.php");
  include ("header.php");
  echo "<h1>".$title."</h1>";
  if ($msg != ''){echo $msg;}
  include ("management.php");
  include ("footer.php");
  
  //Helper functions
  
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