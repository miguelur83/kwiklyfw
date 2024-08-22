<?php
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
  
  if (isset($_GET['up'])){
	$object = new $manage_class($_GET['up']);
	$object->moveUp();
  }
  if (isset($_GET['down'])){
	$object = new $manage_class($_GET['down']);
	$object->moveDown();
  }
  
	$an_object = new $manage_class($object_id);
  
  if (($_GET['page']=='criticas') || ($_GET['page']=='libros')){
		if(! isset($_GET['sortby'])){ 
			if($an_object->getField('sorter_field')!=''){
				$_GET['sortby']=$an_object->getField('sorter_field');
			} else {
				$_GET['sortby']="id";
			}
		}             
		
		if(! isset($_GET['desc'])){ $_GET['desc']="1";}             
  } else {
		if(! isset($_GET['sortby'])){ 
			if($an_object->getField('sorter_field')!=''){
				$_GET['sortby']=$an_object->getField('sorter_field');
			} else {
				$_GET['sortby']="id";
			}
		}             
  }
  
  //echo "<pre>".print_r($_POST, 1)."</pre>";die();
  $an_object->setFields($_POST);
  //echo "<pre>".print_r($_POST, 1)."</pre>";die();
		
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
        //echo "<pre>".print_r($_POST, 1)."</pre>";die();
		
        $an_object->setFields($_POST);
		
        if($an_object->validate()){
          $new_id = $an_object->save();
          if ($new_id){
			if (($_POST['components']) && (get_class($an_object) == 'Pagina')){
				$components = array();
				foreach($_POST['components'] as $component){
					$component = explode("|", $component);
					$component_id = $component[0];
					$object_id = $component[1];
					$component_type = $component[2];
					$seccion_layout = $component[3];
					$components[$seccion_layout][]= array('id' => $component_id, 'object_id' => $object_id, 'type' => $component_type);
				}
				$_POST['components'] = array();
				foreach($components as $seccion_layout => $comp_array){
					foreach ($comp_array as $component){
						$_POST['components'][] = $component['id']."|".$component['object_id']."|".$component['type']."|".$seccion_layout;
					}
				}
				$an_object->saveComponents($_POST['components']);
				unset($_POST['components']);
			}
			
            echo "<p>".$lang->getString('msg_object_has_been_created', $manage_class, $new_id)."</p>";
            $page_URL = "index.php?section=".$_GET['section']."&page=".$_GET['page']."&action=edit";
			if ($_POST['continue']){
				echo $an_object->getLayoutManager()->getUpdateForm($page_URL);
			} else {
				$the_class=get_class($an_object);
				if (($the_class=='Carrousel') || ($the_class=='NoticiasHome')){
					$componente_id = $an_object->getField('componente');
					$link = new ComponentePagina();
					$links = $link->getAll('',0,"componente=".$componente_id);
					if(isset($links[0])){
						$_GET['backpage'] = $links[0]['pagina'];
					}
				}
				
				if(isset($_GET['backpage'])){	
					$pagina = new Pagina($_GET['backpage']);
					$_GET['section'] = 'contenido';
					$_GET['page'] = 'paginas';
					$title = $admin_sections[$_GET['section']]['pages'][$_GET['page']]['title'];
					$page_URL = "index.php?section=".$_GET['section']."&page=".$_GET['page']."&action=edit";
					echo $pagina->getLayoutManager()->getUpdateForm($page_URL);
				} else {
					echo $an_object->getLayoutManager()->getViewableList($page_URL, $_GET['sortby'], $_GET['desc']);
				}
			}
          } else {              
            echo "<p>".$lang->getString('msg_object_could_not_be_created', $manage_class)."</p>";                                                        
          }
        } else {
          $validation_errors = $an_object->getValidationErrors(); 
          echo "<p>".$lang->getString('msg_please_input_all_required_fields').":<br />".$validation_errors."</p>";
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
			if (($_POST['components']) && (get_class($an_object) == 'Pagina')){
				$components = array();
				foreach($_POST['components'] as $component){
					$component = explode("|", $component);
					$component_id = $component[0];
					$object_id = $component[1];
					$component_type = $component[2];
					$seccion_layout = $component[3];
					$components[$seccion_layout][]= array('id' => $component_id, 'object_id' => $object_id, 'type' => $component_type);
				}
				$_POST['components'] = array();
				foreach($components as $seccion_layout => $comp_array){
					foreach ($comp_array as $component){
						$_POST['components'][] = $component['id']."|".$component['object_id']."|".$component['type']."|".$seccion_layout;
					}
				}
				$an_object->saveComponents($_POST['components']);
				unset($_POST['components']);
			}
			
            echo "<p>".$lang->getString('msg_object_has_been_updated', $manage_class, $existing_id)."</p>";
            $page_URL = "index.php?section=".$_GET['section']."&page=".$_GET['page']."&action=edit";
            if ($_POST['continue']){
				echo $an_object->getLayoutManager()->getUpdateForm($page_URL);
			} else {
				$the_class=get_class($an_object);
				if (($the_class=='Carrousel') || ($the_class=='NoticiasHome')){
					$componente_id = $an_object->getField('componente');
					$link = new ComponentePagina();
					$links = $link->getAll('',0,"componente=".$componente_id);
					if(isset($links[0])){
						$_GET['backpage'] = $links[0]['pagina'];
					}
				}
				
				if(isset($_GET['backpage'])){	
					$pagina = new Pagina($_GET['backpage']);
					$_GET['section'] = 'contenido';
					$_GET['page'] = 'paginas';
					$title = $admin_sections[$_GET['section']]['pages'][$_GET['page']]['title'];
					$page_URL = "index.php?section=".$_GET['section']."&page=".$_GET['page']."&action=edit";
					echo $pagina->getLayoutManager()->getUpdateForm($page_URL);
				} else {
					echo $an_object->getLayoutManager()->getViewableList($page_URL, $_GET['sortby'], $_GET['desc']);
				}
			}
          } else {                                                                
            echo "<p>".$lang->getString('msg_object_could_not_be_updated', $manage_class)."</p>";
          }
        } else {
          $validation_errors = $an_object->getValidationErrors(); 
          echo "<p>".$lang->getString('msg_please_input_all_required_fields').":<br />".$validation_errors."</p>";
          echo $an_object->getLayoutManager()->getUpdateForm($pageURL);
        }
      } else {
        echo $an_object->getLayoutManager()->getUpdateForm($pageURL);
      }
    break;
    case "delete":
      if ($_POST['frm_delete_'.$manage_class.'_submit']){
		if($_GET['componente_id']){
			$comp = new Componente($_GET['componente_id']);
			$link = new ComponentePagina();
			$links = $link->getAll('',0,"componente=".$_GET['componente_id']);
			if(isset($links[0])){
				$link = new ComponentePagina($links[0]['id']);
				$link->delete();
				$comp->delete();
			}
		}
        if ($an_object->delete()){
          echo "<p>".$lang->getString('msg_object_has_been_deleted', $manage_class, $object_id)."</p>";
          $page_URL = "index.php?section=".$_GET['section']."&page=".$_GET['page']."&action=edit";
				
			$the_class=get_class($an_object);
			if (($the_class=='Carrousel') || ($the_class=='NoticiasHome')){
				$componente_id = $an_object->getField('componente');
				$link = new ComponentePagina();
				$links = $link->getAll('',0,"componente=".$componente_id);
				if(isset($links[0])){
					$_GET['backpage'] = $links[0]['pagina'];
				}
			}
				
			if(isset($_GET['backpage'])){	
				$pagina = new Pagina($_GET['backpage']);
				$_GET['section'] = 'contenido';
				$_GET['page'] = 'paginas';
					$title = $admin_sections[$_GET['section']]['pages'][$_GET['page']]['title'];
				$page_URL = "index.php?section=".$_GET['section']."&page=".$_GET['page']."&action=edit";
				echo $pagina->getLayoutManager()->getUpdateForm($page_URL);
			} else {
				echo $an_object->getLayoutManager()->getViewableList($page_URL, $_GET['sortby'], $_GET['desc']);
			}
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
?>